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
                        <div class="w-20 h-20 cursor-pointer border rounded-md overflow-hidden hover:border-red-500"
                            x-on:click="mainImage='{{ url('storage', $vehicle->photo) }}'">
                            <img src="{{ url('storage', $vehicle->photo) }}" alt="Main Photo"
                                class="object-cover w-full h-full">
                        </div>

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
                            Rent <span class="text-red-600">{{ $vehicle->make }}</span>
                            {{ $vehicle->model }}
                            <span class="text-sm text-gray-500">({{ $vehicle->year }})</span>
                        </h2>
                        <p class="text-gray-600 dark:text-gray-400">
                            Rate:
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

                        <!-- Rental Dates -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-gray-700 dark:text-gray-300 font-medium mb-2">
                                    Rental Start
                                </label>
                                <input type="date" wire:model.live="rental_start" required
                                    class="w-full p-3 border rounded-md focus:ring-2 focus:ring-red-500 dark:bg-gray-700 dark:text-white">
                            </div>
                            <div>
                                <label class="block text-gray-700 dark:text-gray-300 font-medium mb-2">
                                    Rental End
                                </label>
                                <input type="date" wire:model.live="rental_end" required
                                    class="w-full p-3 border rounded-md focus:ring-2 focus:ring-red-500 dark:bg-gray-700 dark:text-white">
                            </div>
                        </div>

                        <!-- Receipt / Price Calculation -->
                        <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg shadow-inner">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-3">Booking Summary</h3>

                            @if ($error)
                                <p class="text-red-600 font-medium">{{ $error }}</p>
                            @else
                                <ul class="text-gray-700 dark:text-gray-300 space-y-1">
                                    <li>Days: <span class="font-semibold">{{ $days }}</span></li>
                                    <li>Rate/Day:
                                        <span class="font-semibold text-green-600">
                                            {{ Number::currency($vehicle->rate_day, 'PHP') }}
                                        </span>
                                    </li>
                                    <li>Total:
                                        <span class="font-bold text-green-700">
                                            {{ Number::currency($total, 'PHP') }}
                                        </span>
                                    </li>
                                </ul>
                            @endif
                        </div>

                        <!-- Action Button -->
                        <div class="pt-4">
                            <button type="submit" wire:click="save"
                                class="w-full p-4 rounded-md text-white transition
                                       {{ $error || $days <= 0 ? 'bg-gray-400 cursor-not-allowed' : 'bg-red-600 hover:bg-red-700' }}"
                                {{ $error || $days <= 0 ? 'disabled' : '' }}>
                                <span wire:loading.remove>Continue to Confirmation</span>
                                <span wire:loading>Processing...</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
