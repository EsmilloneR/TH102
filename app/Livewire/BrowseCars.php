<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Vehicle as Car;

class BrowseCars extends Component
{
    use WithPagination;

    public $rental_start;
    public $rental_end;

    protected $queryString = [
        'rental_start' => ['except' => ''],
        'rental_end'   => ['except' => ''],
    ];

    public function mount()
    {
        // Default to today + tomorrow if not set
        $this->rental_start = request()->query('rental_start', now()->toDateString());
        $this->rental_end   = request()->query('rental_end', now()->addDay()->toDateString());
    }

    public function updatingRentalStart()
    {
        $this->resetPage();
    }

    public function updatingRentalEnd()
    {
        $this->resetPage();
    }

    public function render()
    {
        $browseCars = Car::query()->where('active', true)
            ->when($this->rental_start && $this->rental_end, function ($query) {
                return $query;
            })
            ->paginate(6);

        return view('livewire.browse-cars', compact('browseCars'));
    }
}
