<x-filament-panels::page>
    @push('styles')
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="" />
    @endpush

    @push('scripts')
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
    @endpush

    <div x-data="leafletMap()" id="map-container" style="width: 100%; height: 500px;"></div>



    <script>
        document.addEventListener("livewire:navigated", () => {
            const gpsLogs = @json($gpsLogs);

            function leafletMap() {
                return {
                    map: null,

                    init() {
                        this.initMap();
                        this.addMarkers();
                    },

                    initMap() {
                        // Default center: Philippines
                        this.map = L.map('map-container').setView([12.8797, 121.7740], 6);

                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            attribution: '&copy; OpenStreetMap contributors'
                        }).addTo(this.map);
                    },

                    addMarkers() {
                        gpsLogs.forEach(log => {
                            let popupContent = `
                                <strong>Car:</strong>${log.make} ${log.model}<br>
                                 <strong>Plate:</strong> ${log.licensed_number}<br>
                                <strong>Vehicle ID:</strong> ${log.vehicle_id}<br>
                                <strong>Speed:</strong> ${log.speed ?? 'N/A'} km/h
                            `;

                            L.marker([log.latitude, log.longitude])
                                .addTo(this.map)
                                .bindPopup(popupContent);
                        });
                    }
                }
            }

            const mapComponent = leafletMap();
            mapComponent.init();
        });
    </script>
</x-filament-panels::page>
