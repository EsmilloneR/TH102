<?php

namespace App\Livewire;

use App\Models\Rental;
use Livewire\Component;

class PickupDetail extends Component
{

    public $id;

    public function mount($id)
    {
        $this->id = $id;
    }


    public function render()
    {

        return view('livewire.pickup-detail', ['rental' => Rental::where('id', $this->id)->firstOrFail()]);
    }
}
