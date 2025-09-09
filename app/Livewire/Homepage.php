<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class Homepage extends Component
{
    public $rental_start;
    public $rental_end;

    public function search()
    {
        return redirect()->route('browse-cars', [
            'start' => $this->rental_start,
            'end'   => $this->rental_end,
        ]);
    }

    public function render()
    {
        return view('livewire.homepage');
    }
}
