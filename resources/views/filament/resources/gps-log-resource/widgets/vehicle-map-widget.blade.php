<x-filament::widget>
    <x-filament::card>

        @push('styles')
            <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
                integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
        @endpush

        @push('scripts')
        @endpush
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

        <div id="map" style="height: 400px;"></div>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                if (typeof L === "undefined") {
                    console.error("Leaflet not loaded!");
                    return;
                }

                var map = L.map('map').setView([12.8797, 121.7740], 5); // PH center

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; OpenStreetMap contributors'
                }).addTo(map);

                let logs = @json($logs);

                logs.forEach(log => {
                    if (log.lat && log.lng) {
                        L.marker([log.lat, log.lng]).addTo(map)
                            .bindPopup(`<b>${log.model}</b><br>Speed: ${log.speed} km/h`);
                    }
                });
            });
        </script>

    </x-filament::card>
</x-filament::widget>
