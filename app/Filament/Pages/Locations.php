<?php

namespace App\Filament\Pages;

use App\Models\GpsLog;
use Filament\Pages\Page;

class Locations extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-map-pin';
     protected static ?string $title = 'Map';
    protected static string $view = 'filament.pages.locations';

    public $gpsLogs;
    public function mount()
    {
           $this->gpsLogs = GpsLog::with('vehicle')
        ->latest()
        ->take(100)
        ->get()
        ->map(function ($log) {
            return [
                'latitude' => $log->latitude,
                'longitude' => $log->longitude,
                'speed' => $log->speed,
                'vehicle_id' => $log->vehicle_id,
                'licensed_number' => $log->vehicle->licensed_number ?? 'Unknown',
                'make' => $log->vehicle->make ?? 'Unknown',
                'model' => $log->vehicle->model ?? 'Unknown',
            ];
        });
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
