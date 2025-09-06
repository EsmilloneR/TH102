<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Vehicle;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function receipt($id)
    {
        $payment = Payment::with('rental.user')->findOrFail($id);
        $rental = $payment->rental;
        $vehicle = $rental->vehicle;
        // dd($vehicle);

        $pdf = Pdf::loadView('pdf.receipt', compact('payment', 'rental', 'vehicle'));
        return $pdf->download('receipt-'.$payment->id.'.pdf');
    }
}
