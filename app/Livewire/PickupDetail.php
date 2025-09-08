<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\Vehicle; // make sure you have this model
#[Layout('components.layouts.app')]
#[Title('Pickup Detail')]
class PickupDetail extends Component
{
    public $id;
    public $vehicle;

    public function mount($id)
    {
        $this->id = $id;

        // load vehicle data
        $this->vehicle = Vehicle::findOrFail($id);
    }

    public function render()
    {
        return view('livewire.pickup-detail', [
            'vehicle' => $this->vehicle
        ]);
    }
}
