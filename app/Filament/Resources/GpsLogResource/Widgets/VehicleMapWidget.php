<?php

namespace App\Filament\Resources\GpsLogResource\Widgets;

use App\Models\GpsLog;
use Filament\Widgets\Widget;

class VehicleMapWidget extends Widget
{
    protected static string $view = 'filament.resources.gps-log-resource.widgets.vehicle-map-widget';
    protected int | string | array $columnSpan = 'full';
    protected static ?int $sort = 3;

    public function getViewData(): array
        {
            return [
                'logs' => GpsLog::with('vehicle')
                    ->latest()
                    ->take(50)
                    ->get()
                    ->map(fn ($log) => [
                        'lat'   => $log->latitude,
                        'lng'   => $log->longitude,
                        'model' => $log->vehicle->model ?? 'Unknown Car',
                        'speed' => $log->speed,
                    ])->toArray(),
            ];

    }
    public static function getStyles(): array
        {
            return [
                'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css',
            ];
        }

    public static function getScripts(): array
    {
        return [
            'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js',
        ];
    }
}

