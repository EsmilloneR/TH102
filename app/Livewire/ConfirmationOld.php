<?php

namespace App\Livewire;

use App\Models\Payment;
use App\Models\Rental;
use App\Models\Vehicle;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

// #[Title('Confirmation Please...')]
// #[Layout('components.layouts.blank')]

class ConfirmationOld extends Component
{
    // public $car;
    // public $pickup_location;
    // public $rental_start;
    // public $rental_end;
    // public $rate_day;
    // public $days;
    // public $total;
    // public $payment_method = 'cash';

    // public function mount($car, $pickup_location, $rental_start, $rental_end, $rate_day, $total)
    // {
    //     $this->car = Vehicle::findOrFail($car);
    //     $this->pickup_location = $pickup_location;
    //     $this->rental_start = $rental_start;
    //     $this->rental_end = $rental_end;
    //     $this->rate_day = $rate_day;
    //     $this->total = $total;

    //     $this->days = Carbon::parse($rental_start)
    //         ->diffInDays(Carbon::parse($rental_end)) + 1;
    // }

    // public function confirmReservation()
    // {

    //     $rental = Rental::create([
    //         'user_id' => auth()->id(),
    //         'vehicle_id' => $this->car->id,
    //         'rental_start' => $this->rental_start,
    //         'rental_end' => $this->rental_end,
    //         'pickup_location' => $this->pickup_location,
    //         'base_amount' => $this->total,
    //         'total' => $this->total,
    //         'status' => $this->payment_method === 'online' ? 'pending' : 'confirmed',
    //     ]);

    //     Payment::create([
    //         'rental_id' => $rental->id,
    //         'payment_method' => $this->payment_method,
    //         'amount' => $this->total,
    //         'transaction_reference' => 'TXN-' . strtoupper(uniqid()),
    //         'status' => $this->payment_method === 'cash' ? 'pending' : 'completed',
    //     ]);

    //     if ($this->payment_method === 'cash') {
    //         session()->flash('success', 'Booking confirmed. Please pay at pickup.');
    //         return redirect()->route('thankyou');
    //     }

    //     if ($this->payment_method === 'online') {
    //         return $this->handleOnlinePayment($rental);
    //     }
    // }

    //  public function handleOnlinePayment($rental)
    // {
    //     try {
    //         $client = new Client();

    //         $reference = Payment::create([
    //             'rental_id' => $rental->id,
    //             'payment_method' => $this->payment_method,

    //             'amount' => $this->total,
    //             'transaction_reference' => 'TXN-' . strtoupper(uniqid()),
    //             'status' => $this->payment_method === 'cash' ? 'pending' : 'completed',
    //         ]);


    //         $response = $client->request('POST', 'https://api.paymongo.com/v1/checkout_sessions', [
    //             'json' => [
    //                 'data' => [
    //                     'attributes' => [
    //                         'billing' => [
    //                         'name' => Auth::user()?->name,
    //                         'email' => Auth::user()?->email,
    //                         'phone' => Auth::user()?->phone_number,
    //                         ],
    //                         'send_email_receipt' => true,
    //                         'show_description' => true,
    //                         'show_line_items' => true,
    //                         'cancel_url' => route('/'),
    //                         'description' => "Car Rental for {$this->car->make} {$this->car->model} ({$this->rental_start} to {$this->rental_end})",
    //                         'line_items' => [
    //                             [
    //                                 'currency' => 'PHP',
    //                                 'amount' => $this->total * 100, // cents
    //                                 'description' => "Car Rental # {$rental->id}",
    //                                 'name' => "{$this->car->make} {$this->car->model}",
    //                                 'quantity' => 1
    //                             ]
    //                         ],
    //                         'payment_method_types' => ['card', 'gcash', 'paymaya', 'brankas_metrobank'],
    //                         'reference_number' => $reference->transaction_reference,
    //                         'success_url' => route('/'),
    //                     ]
    //                 ]
    //             ],
    //             'headers' => [
    //                 'Content-Type' => 'application/json',
    //                 'Accept' => 'application/json',
    //                 'Authorization' => 'Basic ' . base64_encode(env('PAYMONGO_SK')),
    //             ],
    //         ]);

    //         $checkoutData = json_decode($response->getBody()->getContents(), true);
    //         $checkoutSessionUrl = $checkoutData['data']['attributes']['checkout_url'];

    //         return redirect()->away($checkoutSessionUrl);

    //     } catch (RequestException $e) {
    //         // Handle error
    //         $error = $e->getMessage();
    //         session()->flash('error', 'There was an issue creating the checkout session: ' . $error);
    //     }
    // }


    // public function render()
    // {
    //     return view('livewire.confirmation');
    // }
}
