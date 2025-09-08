<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
    <section class="bg-white py-11 font-poppins dark:bg-gray-800 rounded-lg shadow-md">
        <div class="max-w-5xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                <!-- LEFT: Vehicle Images -->
                <div x-data="{ mainImage: '{{ url('storage', $vehicle->photo) }}' }">
                    <!-- Main Image -->
                    <div class="mb-4">
                        <img x-bind:src="mainImage" alt="{{ $vehicle->make }} {{ $vehicle->model }}"
                            class="object-cover w-full h-[300px] rounded-lg shadow-md">
                    </div>

                    <!-- Thumbnails -->
                    <div class="flex flex-wrap gap-2">
                        <!-- Primary photo -->
                        <div class="w-20 h-20 cursor-pointer border rounded-md overflow-hidden hover:border-red-500"
                            x-on:click="mainImage='{{ url('storage', $vehicle->photo) }}'">
                            <img src="{{ url('storage', $vehicle->photo) }}" alt="Main Photo"
                                class="object-cover w-full h-full">
                        </div>

                        <!-- Extra images -->
                        @if ($vehicle->images)
                            @foreach ($vehicle->images as $image)
                                <div class="w-20 h-20 cursor-pointer border rounded-md overflow-hidden hover:border-red-500"
                                    x-on:click="mainImage='{{ url('storage', $image) }}'">
                                    <img src="{{ url('storage', $image) }}" alt="Extra Image"
                                        class="object-cover w-full h-full">
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>

                <!-- RIGHT: Vehicle Info + Pickup Form -->
                <div>
                    <!-- Vehicle Summary -->
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-2">
                            Rent <span class="text-red-600 dark:text-red-600">{{ $vehicle->make }}</span>
                            {{ $vehicle->model }}
                            <span class="text-sm text-gray-500">({{ $vehicle->year }})</span>
                        </h2>
                        <p class="text-gray-600 dark:text-gray-400">
                            Rate:
                            <span class="text-green-600 font-semibold">
                                {{ Number::currency($vehicle->rate_hour, 'PHP') }}/hr
                            </span> or
                            <span class="text-green-600 font-semibold">
                                {{ Number::currency($vehicle->rate_day, 'PHP') }}/day
                            </span>
                        </p>
                    </div>

                    <!-- Pickup & Return Form -->
                    <form wire:submit.prevent="save" class="space-y-6">
                        <!-- Pickup Location -->
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 font-medium mb-2">
                                Pickup Location
                            </label>
                            <input type="text" wire:model="pickup_location" required
                                class="w-full p-3 border rounded-md focus:ring-2 focus:ring-red-500 dark:bg-gray-700 dark:text-white">
                        </div>

                        {{-- <!-- Pickup Date & Time -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-gray-700 dark:text-gray-300 font-medium mb-2">
                                    Pickup Date
                                </label>
                                <input type="date" wire:model="pickup_date" required
                                    class="w-full p-3 border rounded-md focus:ring-2 focus:ring-red-500 dark:bg-gray-700 dark:text-white">
                            </div>
                            <div>
                                <label class="block text-gray-700 dark:text-gray-300 font-medium mb-2">
                                    Pickup Time
                                </label>
                                <input type="time" wire:model="pickup_time" required
                                    class="w-full p-3 border rounded-md focus:ring-2 focus:ring-red-500 dark:bg-gray-700 dark:text-white">
                            </div>
                        </div>

                        <!-- Return Date & Time -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-gray-700 dark:text-gray-300 font-medium mb-2">
                                    Return Date
                                </label>
                                <input type="date" wire:model="return_date" required
                                    class="w-full p-3 border rounded-md focus:ring-2 focus:ring-red-500 dark:bg-gray-700 dark:text-white">
                            </div>
                            <div>
                                <label class="block text-gray-700 dark:text-gray-300 font-medium mb-2">
                                    Return Time
                                </label>
                                <input type="time" wire:model="return_time" required
                                    class="w-full p-3 border rounded-md focus:ring-2 focus:ring-red-500 dark:bg-gray-700 dark:text-white">
                            </div>
                        </div> --}}

                        <!-- Action Button -->
                        <div class="pt-4">
                            <button type="submit"
                                class="w-full p-4 bg-red-600 rounded-md text-white hover:bg-red-700 transition">
                                Continue to Confirmation
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
