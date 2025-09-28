<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
#[Title('Thank you <3')]
#[Layout('components.layouts.blank')]
class Thankyou extends Component
{
    public function render()
    {
        return view('livewire.thankyou');
    }
}
