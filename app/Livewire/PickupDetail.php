<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\Vehicle;
use Carbon\Carbon;

// #[Layout('components.layouts.blank')]
#[Title('Pickup Detail')]
class PickupDetail extends Component
{
    public $id;
    public $vehicle;
    public $trip_type;
    public $pickup_location;
    public $rental_start;
    public $rental_end;

    public $days = 0;
    public $total = 0;
    public $error = null;

    public function mount($id)
    {
        $this->id = $id;
        $this->vehicle = Vehicle::findOrFail($id);
    }

    public function updated($field)
    {
        if ($this->rental_start && $this->rental_end) {
            $start = Carbon::parse($this->rental_start);
            $end   = Carbon::parse($this->rental_end);

            if ($end->lessThanOrEqualTo($start)) {
                $this->error = "End date must be after start date.";
                $this->days = 0;
                $this->total = 0;
            } else {
                $this->error = null;
                $this->days = $start->diffInDays($end); // always positive
                $this->total = $this->days * $this->vehicle->rate_day;
            }
        }
    }

    public function calculateTotal()
    {
        $this->error = null;
        $this->days = 0;
        $this->total = 0;

        if (!$this->rental_start || !$this->rental_end) {
            return;
        }

        try {
            $start = Carbon::parse($this->rental_start)->startOfDay();
            $end   = Carbon::parse($this->rental_end)->startOfDay();

            // 🛑 Prevent negative or invalid ranges
            if ($end->lt($start)) {
                $this->error = 'Return date must be the same or after the start date.';
                return;
            }

            // Same day = count as 1 day
            $days = $end->diffInDays($start, false);
            if ($days === 0) {
                $days = 1;
            }

            $this->days = $days;
            $this->total = $days * (float) $this->vehicle->rate_day;

        } catch (\Throwable $e) {
            $this->error = 'Invalid date format.';
        }
    }

    public function save()
    {
        // Log::debug('Pickup Location: ' . $this->pickup_location);
        // dd($this->pickup_location);
        if ($this->error || $this->days <= 0 || $this->total <= 0) {
            return; // prevent invalid submission
        }

        // 🔥 next step → save rental or go to confirmation page

        if ($this->error || $this->days <= 0 || $this->total <= 0) {
            return;
        }

        session()->flash('success', 'Booking details saved! Continue to confirmation.');

        return redirect()->route('confirmation', [
            'car' => $this->vehicle->id,
            'trip_type' => $this->trip_type,
            'pickup_location' => $this->pickup_location,
            'rental_start' => $this->rental_start,
            'rental_end' => $this->rental_end,
            'rate_day' => Vehicle::find($this->vehicle->id)->rate_day,
            'total' => $this->total,
        ]);
    }

    public function render()
    {
        return view('livewire.pickup-detail', [
            'vehicle' => $this->vehicle,
        ]);
    }
}
