<div>
    <h2 class="text-xl font-bold mb-4">My Rentals</h2>
    <div id="map" style="height: 500px;"></div>


    @if ($rentals->isEmpty())
        <p class="text-gray-500">You don’t have any rentals yet.</p>
    @else
        <ul class="space-y-4">
            @foreach ($rentals as $rental)
                <li class="p-4 border rounded-lg shadow-sm flex items-start gap-4">

                    {{-- Vehicle Image --}}
                    <div class="w-32 h-24 flex-shrink-0 overflow-hidden rounded-md border bg-gray-100">
                        @if ($rental->vehicle && $rental->vehicle->photo)
                            <img src="{{ url('storage', $rental->vehicle->photo) }}" alt="{{ $rental->vehicle->name }}"
                                class="w-full h-full object-cover">
                        @else
                            <div class="flex items-center justify-center h-full text-gray-400 text-sm">
                                No Image
                            </div>
                        @endif
                    </div>

                    {{-- Rental Info --}}
                    <div class="flex-1">
                        <div class="font-semibold text-lg">
                            {{ $rental->vehicle->make . ' ' . $rental->vehicle->model ?? 'Unknown Vehicle' }}
                        </div>
                        <div class="text-sm text-gray-600">
                            <strong>Agreement No:</strong> {{ $rental->agreement_no }}
                        </div>
                        <div class="text-sm text-gray-600">
                            <strong>Pickup:</strong> {{ $rental->pickup_location }} <br>
                            <strong>Dropoff:</strong> {{ $rental->dropoff_location }}
                        </div>
                        <div class="text-sm text-gray-600">
                            <strong>Start:</strong> {{ $rental->rental_start->format('M d, Y H:i') }} <br>
                            <strong>End:</strong> {{ $rental->rental_end->format('M d, Y H:i') }}
                        </div>
                        <div class="text-sm text-gray-600">
                            <strong>Total:</strong> ₱{{ number_format($rental->total, 2) }}
                        </div>
                        <div class="mt-2">
                            <span
                                class="px-2 py-1 rounded text-white
                                {{ $rental->status === 'active' ? 'bg-green-600' : 'bg-gray-500' }}">
                                {{ ucfirst($rental->status) }}
                            </span>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    @endif

</div>
