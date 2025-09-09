<div class="max-w-7xl mx-auto px-6">
    <!-- Filter Header -->
    <div class="bg-white dark:bg-gray-800 shadow-md rounded-xl p-6 mb-8 flex flex-col md:flex-row md:items-end gap-4">
        <div>
            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Rent Start</label>
            <input type="date" wire:model.live="rental_start"
                class="border rounded-lg px-3 py-2 w-full md:w-auto dark:bg-gray-900 dark:text-gray-200">
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Rent End</label>
            <input type="date" wire:model.live="rental_end"
                class="border rounded-lg px-3 py-2 w-full md:w-auto dark:bg-gray-900 dark:text-gray-200">
        </div>
    </div>

    <!-- Cars List -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 my-2">
        @forelse ($browseCars as $car)
            <div wire:key="{{ $car->id }}">
                <div class="border border-gray-300 dark:border-gray-700 rounded-lg overflow-hidden">
                    <div class="relative bg-gray-200">
                        <a href="/vehicle/{{ $car->id }}" wire:navigate>
                            <img src="{{ url('storage', $car->photo) }}" alt="{{ $car->car_name }}"
                                class="object-cover w-full h-56">
                        </a>
                    </div>

                    <div class="p-3">
                        <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-2">
                            {{ $car->car_name }}
                            <span class="text-sm text-gray-500">({{ $car->year }})</span>
                        </h3>

                        <p class="text-md font-semibold">
                            From:
                            <span class="text-green-600 dark:text-green-500">
                                {{ Number::currency($car->rate_hour, 'PHP') }}
                            </span>
                            —
                            <span class="text-green-600 dark:text-green-500">
                                {{ Number::currency($car->rate_week, 'PHP') }}
                            </span>
                        </p>
                    </div>

                    <div class="flex justify-center p-4 border-t border-gray-300 dark:border-gray-700">
                        <a href="/pickup/{{ $car->id }}"
                            class="text-gray-600 flex items-center space-x-2 dark:text-gray-400 hover:text-red-500 dark:hover:text-red-300"
                            wire:navigate>
                            <span>Rent Now</span>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center text-gray-600 dark:text-gray-400">
                🚗 No cars available for these dates.
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="flex justify-center m-6">
        {{ $browseCars->links() }}
    </div>
</div>
