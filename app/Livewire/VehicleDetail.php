<?php

namespace App\Livewire;

use App\Models\Vehicle;
use Livewire\Component;

class VehicleDetail extends Component
{
    public $id;

    public function mount($id)
    {
        $this->id = $id;
    }


    public function render()
    {

        return view('livewire.vehicle-detail', ['vehicle' => Vehicle::where('id', $this->id)->firstOrFail()]);
    }
}
