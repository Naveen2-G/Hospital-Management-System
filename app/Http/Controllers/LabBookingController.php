<?php

namespace App\Http\Controllers;

use App\Models\LabBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class LabBookingController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'patient_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'gender' => 'required|in:Male,Female,Other',
            'age' => 'required|integer|min:0|max:150',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'pincode' => 'required|string|max:10',
            'preferred_date' => 'required|date|after_or_equal:today',
            'preferred_time_slot' => 'required|string',
            'test_name' => 'required|string|max:255',
            'test_price' => 'required|numeric',
            'notes' => 'nullable|string',
            'payment_method' => 'required|in:online,home',
        ]);

        $data['user_id'] = Auth::id();
        $data['payment_status'] = 'pending';
        $data['booking_status'] = 'pending';

        $booking = LabBooking::create($data);

        if ($data['payment_method'] === 'online') {
            return $this->processOnlinePayment($booking);
        }

        return redirect()->route('lab-bookings.success', $booking->id)
            ->with('success', 'Booking confirmed. Please pay at home.');
    }

    private function processOnlinePayment(LabBooking $booking)
    {
        $stripeSecret = config('services.stripe.secret');
        if (!$stripeSecret) {
            return back()->with('error', 'Stripe is not configured correctly.');
        }

        Stripe::setApiKey($stripeSecret);

        $amountInPaise = (int) ($booking->test_price * 100);

        try {
            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'inr',
                        'product_data' => [
                            'name' => $booking->test_name,
                            'description' => 'Lab Test Booking for ' . $booking->patient_name,
                        ],
                        'unit_amount' => $amountInPaise,
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'customer_email' => $booking->email,
                'success_url' => route('lab-bookings.payment.success', $booking->id) . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('lab-tests') . '?error=payment_cancelled',
                'metadata' => [
                    'booking_id' => $booking->id,
                ],
            ]);

            return redirect($session->url);
        } catch (\Exception $e) {
            return back()->with('error', 'Error creating payment session: ' . $e->getMessage());
        }
    }

    public function paymentSuccess(Request $request, LabBooking $booking)
    {
        $sessionId = $request->get('session_id');
        if ($sessionId) {
            $stripeSecret = config('services.stripe.secret');
            Stripe::setApiKey($stripeSecret);
            try {
                $session = Session::retrieve($sessionId);
                if ($session->payment_status === 'paid') {
                    $booking->update([
                        'payment_status' => 'paid',
                        'transaction_id' => $session->payment_intent,
                        'booking_status' => 'confirmed',
                    ]);
                }
            } catch (\Exception $e) {
                // Log error
            }
        }

        return redirect()->route('lab-bookings.success', $booking->id);
    }

    public function success(LabBooking $booking)
    {
        return view('pages.lab-booking-success', compact('booking'));
    }

    public function receipt(LabBooking $booking)
    {
        // For simplicity, we'll just return a printable view as the "receipt"
        // or a raw HTML that can be printed.
        return view('pages.lab-booking-receipt', compact('booking'));
    }
}
