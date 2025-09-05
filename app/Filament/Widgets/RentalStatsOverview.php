<?php

namespace App\Filament\Widgets;

use App\Models\Rental;
use App\Models\Payment;
use App\Models\Vehicle;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;


class RentalStatsOverview extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

      protected static ?int $sort = 1;
    protected function getStats(): array
    {
        return [
            Card::make('Total Rentals', Rental::count()),

            Card::make('Total Revenue', '₱' . number_format(
                Payment::where('status', 'completed')->sum('amount'), 2
            ))->description('Completed payments only'),

            Card::make('Active Rentals', Rental::where('status', 'ongoing')->count()),

            Card::make('Vehicles Available', Vehicle::doesntHave('rentals')->count()),
        ];
    }
}
