<?php

namespace App\Livewire;

use App\Models\Vehicle;
use Livewire\Component;

class BrowseCars extends Component
{

    public function render()
    {
        $browseCars = Vehicle::where('active', true)->get();
        // dd($browseCars);
        return view('livewire.browse-cars', ['browseCars' => $browseCars]);
    }
}
