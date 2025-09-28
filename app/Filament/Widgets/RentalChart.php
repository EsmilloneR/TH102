<?php

namespace App\Filament\Widgets;

use App\Models\Payment;
use Filament\Widgets\ChartWidget;

class RentalChart extends ChartWidget
{
   protected static ?string $heading = 'Monthly Revenue';
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {
        $data = Payment::where('status', 'completed')
            ->selectRaw('MONTH(created_at) as month, SUM(amount) as total')
            ->groupBy('month')
            ->pluck('total', 'month');

        return [
            'datasets' => [
                [
                    'label' => 'Revenue',
                    'data' => $data->values(),
                ],
            ],
            'labels' => $data->keys()->map(fn ($m) => date('F', mktime(0, 0, 0, $m, 1))),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
