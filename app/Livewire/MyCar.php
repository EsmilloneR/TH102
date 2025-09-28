<?php

namespace App\Livewire;

use App\Models\Rental;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MyCar extends Component
{
    public $rentals;

    public function mount(){
        $this->rentals = Rental::with('vehicle')
                    ->where('user_id', Auth::id())
                    ->latest()
                    ->get();
    }

    public function render()
    {
        return view('livewire.my-car');
    }
}
