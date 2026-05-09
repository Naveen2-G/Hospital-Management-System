<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class InvoicePaymentController extends Controller
{
    public function create(Invoice $invoice)
    {
        $this->authorizeInvoice($invoice);

        if ((float) $invoice->due_amount <= 0) {
            return redirect()->route('patient.dashboard')->with('error', 'This invoice is already fully paid.');
        }

        try {
            $stripeSecret = config('services.stripe.secret');
            if (! $stripeSecret) {
                return redirect()->route('patient.dashboard')->with('error', 'Stripe is not configured correctly. Please contact support.');
            }

            Stripe::setApiKey($stripeSecret);

            $amountInPaise = (int) round(((float) $invoice->due_amount) * 100);

            $checkoutSession = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'inr',
                        'product_data' => [
                            'name' => 'Invoice ' . ($invoice->invoice_number ?? ('#' . $invoice->id)),
                            'description' => 'Payment for outstanding hospital invoice',
                        ],
                        'unit_amount' => $amountInPaise,
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'customer_email' => Auth::user()?->email ?? $invoice->patient?->email,
                'metadata' => [
                    'invoice_id' => (string) $invoice->id,
                    'invoice_number' => (string) ($invoice->invoice_number ?? $invoice->id),
                ],
                'success_url' => route('patient.invoices.payment.success', $invoice) . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('patient.invoices.payment.cancel', $invoice),
            ]);

            return redirect()->away($checkoutSession->url);
        } catch (\Throwable $e) {
            return redirect()->route('patient.dashboard')->with('error', 'Unable to start Stripe checkout. Please try again.');
        }
    }

    public function success(Request $request, Invoice $invoice)
    {
        $this->authorizeInvoice($invoice);

        $sessionId = $request->query('session_id');
        if (! $sessionId) {
            return redirect()->route('patient.dashboard')->with('error', 'Payment session was not found.');
        }

        try {
            $stripeSecret = config('services.stripe.secret');
            if (! $stripeSecret) {
                return redirect()->route('patient.dashboard')->with('error', 'Stripe is not configured correctly. Please contact support.');
            }

            Stripe::setApiKey($stripeSecret);
            $session = Session::retrieve($sessionId);

            Log::info('Stripe session retrieved', [
                'session_id' => $sessionId,
                'payment_status' => $session->payment_status ?? null,
                'amount_total' => $session->amount_total ?? null,
                'customer_email' => $session->customer_email ?? null,
                'metadata' => $session->metadata ?? [],
                'status' => $session->status ?? null,
            ]);

            if (($session->payment_status ?? null) !== 'paid') {
                Log::warning('Stripe payment not completed', [
                    'session_id' => $sessionId,
                    'payment_status' => $session->payment_status,
                ]);
                return redirect()->route('patient.dashboard')->with('error', 'Payment was not completed.');
            }

            if (Payment::where('transaction_id', $sessionId)->exists()) {
                return redirect()->route('patient.dashboard')->with('success', 'Invoice payment already recorded.');
            }

            $amountPaid = ((float) ($session->amount_total ?? 0)) / 100;
            $amountPaid = min($amountPaid, (float) $invoice->due_amount);

            Log::info('Amount validation', [
                'invoice_id' => $invoice->id,
                'stripe_amount_total' => $session->amount_total,
                'calculated_amount' => $amountPaid,
                'invoice_due_amount' => $invoice->due_amount,
            ]);

            if ($amountPaid <= 0) {
                return redirect()->route('patient.dashboard')->with('success', 'Invoice is already fully settled.');
            }

            $payment = Payment::create([
                'invoice_id' => $invoice->id,
                'amount' => $amountPaid,
                'method' => 'stripe',
                'transaction_id' => $sessionId,
                'paid_at' => now(),
            ]);

            Log::info('Payment record created successfully', [
                'payment_id' => $payment->id,
                'invoice_id' => $invoice->id,
                'amount' => $amountPaid,
                'stripe_session_id' => $sessionId,
            ]);

            $invoice->update(['payment_status' => 'paid']);

            Log::info('Invoice payment_status updated', [
                'invoice_id' => $invoice->id,
                'payment_status' => 'paid',
            ]);

            $newPaidAmount = round(((float) $invoice->paid_amount) + $amountPaid, 2);
            $newDueAmount = round(max(((float) $invoice->total_amount) - $newPaidAmount, 0), 2);

            $invoice->forceFill([
                'paid_amount' => $newPaidAmount,
                'due_amount' => $newDueAmount,
                'status' => $newDueAmount <= 0 ? 'paid' : 'partial',
            ])->save();

            return redirect()->route('patient.dashboard')->with('success', 'Invoice payment completed successfully!');
        } catch (\Throwable $e) {
            Log::error('Stripe payment callback error', [
                'session_id' => $sessionId,
                'invoice_id' => $invoice->id ?? null,
                'exception_class' => get_class($e),
                'exception_message' => $e->getMessage(),
                'exception_code' => $e->getCode(),
                'exception_file' => $e->getFile(),
                'exception_line' => $e->getLine(),
                'exception_trace' => $e->getTraceAsString(),
            ]);
            report($e);
            return redirect()->route('patient.dashboard')->with('error', 'We could not verify the Stripe payment. Please contact support.');
        }
    }

    public function cancel(Invoice $invoice)
    {
        $this->authorizeInvoice($invoice);

        return redirect()->route('patient.dashboard')->with('error', 'Invoice payment was cancelled.');
    }

    private function authorizeInvoice(Invoice $invoice): void
    {
        $user = Auth::user();
        abort_unless($user && $user->role === 'patient', 403);
        abort_unless($invoice->patient && $invoice->patient->user_id === $user->id, 403);
    }
}