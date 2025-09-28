<?php

namespace App\Livewire;

use App\Models\Payment;
use App\Models\Rental;
use App\Models\Vehicle;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;

class Confirmation extends Component
{
    public $car;
    public $pickup_location;
    public $rental_start;
    public $rental_end;
    public $rate_day;
    public $days;
    public $total;
    public $payment_method = 'cash';
    public $paymentStatus = 'pending'; // Track payment status

    public function mount($car, $pickup_location, $rental_start, $rental_end, $rate_day, $total)
    {
        $this->car = Vehicle::findOrFail($car);
        $this->pickup_location = $pickup_location;
        $this->rental_start = $rental_start;
        $this->rental_end = $rental_end;
        $this->rate_day = $rate_day;
        $this->total = $total;
        $this->days = Carbon::parse($rental_start)
            ->diffInDays(Carbon::parse($rental_end)) + 1;
    }

    public function confirmReservation()
    {
        // Start reservation
        $rental = Rental::create([
            'user_id' => auth()->id(),
            'vehicle_id' => $this->car->id,
            'rental_start' => $this->rental_start,
            'rental_end' => $this->rental_end,
            'pickup_location' => $this->pickup_location,
            'base_amount' => $this->total,
            'total' => $this->total,
            'status' => $this->payment_method === 'online' ? 'pending' : 'confirmed',
        ]);

        // Create payment record
        $payment = Payment::create([
            'rental_id' => $rental->id,
            'payment_method' => $this->payment_method,
            'amount' => $this->total,
            'transaction_reference' => 'CRTG-' . strtoupper(uniqid()),
            'status' => $this->payment_method === 'cash' ? 'pending' : 'completed',
        ]);

        if ($this->payment_method === 'cash') {
            session()->flash('success', 'Booking confirmed. Please pay at pickup.');
            return redirect()->route('thankyou');
        }

        if ($this->payment_method === 'online') {
            return $this->handleOnlinePayment($rental, $payment);
        }
    }

public function handleOnlinePayment($rental, $payment)
{
    try {
        $client = new Client();

        // Create a PayMongo checkout session
        $response = $client->request('POST', 'https://api.paymongo.com/v1/checkout_sessions', [
            'json' => [
                'data' => [
                    'attributes' => [
                        'billing' => [
                            'name' => Auth::user()->name,
                            'email' => Auth::user()->email,
                            'phone' => Auth::user()->phone_number,
                        ],
                        'send_email_receipt' => true,
                        'show_description' => true,
                        'show_line_items' => true,
                        'cancel_url' => route('/'), // Cancel URL in case payment fails
                        'description' => "Car Rental for {$this->car->make} {$this->car->model} ({$this->rental_start} to {$this->rental_end})",
                        'line_items' => [
                            [
                                'currency' => 'PHP',
                                'amount' => $this->total * 100, // In cents
                                'description' => "Car Rental #{$rental->id}",
                                'name' => "{$this->car->make} {$this->car->model}",
                                'quantity' => 1,
                            ]
                        ],
                        'payment_method_types' => ['card', 'gcash', 'paymaya'],
                        'reference_number' => $payment->transaction_reference,
                        'success_url' => route('thankyou', ['payment_id' => $payment->transaction_reference]),
                    ]
                ]
            ],
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'Authorization' => 'Basic ' . base64_encode(env('PAYMONGO_SK')),
            ],
        ]);

        // Decode the response from PayMongo API
        $checkoutData = json_decode($response->getBody()->getContents(), true);

        // Log the full response for debugging
        Log::info('PayMongo Response: ' . json_encode($checkoutData, JSON_PRETTY_PRINT));

        // Check if checkout_url exists in the response
        if (isset($checkoutData['data']['attributes']['checkout_url'])) {
            $checkoutSessionUrl = $checkoutData['data']['attributes']['checkout_url'];

            // Log the checkout URL
            Log::info('Checkout URL: ' . $checkoutSessionUrl);

            // Redirect to the PayMongo checkout page
            return redirect()->away($checkoutSessionUrl);
        } else {
            // Log error if no checkout URL is returned
            Log::error('Failed to get checkout URL from PayMongo response.');
            session()->flash('error', 'Could not generate the checkout session. Please try again.');
        }

    } catch (\Exception $e) {
        // Log the error message and response body if available
        Log::error('PayMongo Error: ' . $e->getMessage());
        if ($e->getResponse()) {
            Log::error('Response: ' . $e->getResponse()->getBody());
        }
        session()->flash('error', 'There was an issue creating the checkout session. Please try again.');
    }
}

    public function render()
    {
        return view('livewire.confirmation');
    }
}
