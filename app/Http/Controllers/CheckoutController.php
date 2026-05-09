<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class CheckoutController extends Controller
{
    public function process(Request $request)
    {
        // Validate request
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'package_name' => 'required|string',
            'package_price' => 'required|numeric'
        ]);

        $stripeSecret = config('services.stripe.secret');
        if (! $stripeSecret) {
            return back()->with('error', 'Stripe is not configured correctly. Please contact support.');
        }

        // Set Stripe secret key from configuration
        Stripe::setApiKey($stripeSecret);

        // Stripe requires the amount in cents (or smallest currency unit).
        // Since price is in INR, multiply by 100
        $amountInPaise = (int) ($request->package_price * 100);

        try {
            // Create Stripe Checkout Session
            $checkout_session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'inr',
                        'product_data' => [
                            'name' => $request->package_name,
                            'description' => 'Health Package Booking for ' . $request->name,
                        ],
                        'unit_amount' => $amountInPaise,
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'customer_email' => $request->email,
                'success_url' => route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('checkout.cancel'),
            ]);

            // Redirect user to Stripe Checkout page
            return redirect($checkout_session->url);
        } catch (\Exception $e) {
            return back()->with('error', 'Error creating payment session: ' . $e->getMessage());
        }
    }

    public function success(Request $request)
    {
        // Ideally we would verify the session ID with Stripe and save the booking to the DB
        // For this prototype, we just show the success page
        return view('pages.checkout-success');
    }

    public function cancel()
    {
        // Redirect back to health packages page
        return redirect()->route('health-packages')->with('error', 'Payment was cancelled.');
    }
}
