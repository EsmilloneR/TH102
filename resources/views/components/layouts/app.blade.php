<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Drive & Go' }}</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

</head>

<body>
    @livewire('partial.header')

    {{ $slot }}

    @if (!request()->routeIs('pickup-detail') || !request()->routeIs('confirmation') || !request()->routeIs('thankyou'))
        @livewire('partial.footer')
    @endif

    @livewireScripts
    <script>
        document.addEventListener("livewire:navigated", function() {
            // prevent double init
            let mapEl = document.getElementById('map');
            if (!mapEl || mapEl.dataset.initialized) return;

            var map = L.map('map').setView([8.184637, 126.354568], 12);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            @foreach (\App\Models\GpsLog::with('vehicle')->latest()->take(50)->get() as $log)
                L.marker([{{ $log->latitude }}, {{ $log->longitude }}])
                    .addTo(map)
                    .bindPopup(
                        "<b>{{ $log->vehicle->model ?? 'Unknown Car' }}</b><br>Speed: {{ $log->speed }} km/h");
            @endforeach

            setTimeout(() => {
                map.invalidateSize();
            }, 100);

            mapEl.dataset.initialized = true;
        });
    </script>

</body>

</html>
