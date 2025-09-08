<?php

namespace App\Livewire;

use App\Models\Vehicle;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Browse Cars')]
#[Layout('components.layouts.app')]
class BrowseCars extends Component
{

    public function render()
    {

        $browseCars = Vehicle::where('active', true)->paginate(6);
        // dd($browseCars);
        return view('livewire.browse-cars', ['browseCars' => $browseCars]);
    }
}
