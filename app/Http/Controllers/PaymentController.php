<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function handlePaymentSuccess($payment_id)
    {
        $payment = Payment::where('transaction_reference', $payment_id)->first();

        if (!$payment) {
            return redirect()->route('home')->with('error', 'Payment not found.');
        }

        // If payment was successful, confirm the rental
        if ($payment->status !== 'completed') {
            return redirect()->route('home')->with('error', 'Payment was not successful.');
        }

        // Update the rental status to 'confirmed'
        $rental = Rental::find($payment->rental_id);
        if ($rental) {
            $rental->status = 'confirmed';
            $rental->save();
        }

        // Broadcasting the payment confirmed event
        broadcast(new \App\Events\PaymentConfirmed($payment));

        return redirect()->route('thankyou')->with('success', 'Booking confirmed and payment successful!');
    }

    public function paymentWebhook(Request $request)
    {
        $payload = $request->getContent();
        $signature = $request->header('X-PayMongo-Signature');
        $secret = env('PAYMONGO_WEBHOOK_SECRET');

        // Validate the webhook signature
        $expectedSignature = hash_hmac('sha256', $payload, $secret);
        if ($signature !== $expectedSignature) {
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        $data = json_decode($payload, true);
        $paymentStatus = $data['data']['attributes']['status'];
        $paymentId = $data['data']['id'];

        // Find the payment record
        $payment = Payment::where('transaction_reference', $paymentId)->first();
        if (!$payment) {
            return response()->json(['error' => 'Payment not found'], 404);
        }

        // Update payment status
        $payment->status = $paymentStatus === 'successful' ? 'completed' : 'failed';
        $payment->save();

        // Update rental status if payment is successful
        if ($paymentStatus === 'successful') {
            $rental = Rental::find($payment->rental_id);
            $rental->status = 'confirmed';
            $rental->save();
        }

        return response()->json(['status' => 'success']);
    }
}
