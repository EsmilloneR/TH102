<div>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 my-2">
        @foreach ($browseCars as $car)
            <div wire:key="{{ $car->id }}">
                <div class="border border-gray-300 dark:border-gray-700 rounded-lg overflow-hidden">
                    <div class="relative bg-gray-200">
                        <a href="/vehicle/{{ $car->id }}" wire:navigate>
                            <img src="{{ url('storage', $car->photo) }}" alt="{{ $car->make }} {{ $car->model }}"
                                class="object-cover w-full h-56">
                        </a>
                    </div>

                    <div class="p-3">
                        <div class="flex items-center justify-between gap-2 mb-2">
                            <h3 class="text-xl font-medium dark:text-gray-400 font-bold">
                                <span class="text-red-600 dark:text-red-600">{{ $car->make }}</span>
                                {{ $car->model }}
                                {{ $car->year }}
                            </h3>
                        </div>
                        <p class="text-md font-semibold">
                            From:
                            <span class="text-green-600 dark:text-green-600">
                                {{ Number::currency($car->rate_hour, 'PHP') }}
                            </span>
                            -
                            <span class="text-green-600 dark:text-green-600">
                                {{ Number::currency($car->rate_week, 'PHP') }}
                            </span>
                        </p>
                    </div>

                    <div class="flex justify-center p-4 border-t border-gray-300 dark:border-gray-700">
                        <a href="/pickup/{{ $car->id }}"
                            class="text-gray-500 flex items-center space-x-2 dark:text-gray-400 hover:text-red-500 dark:hover:text-red-300"
                            wire:navigate>
                            {{-- svg start --}}

                            {{-- svg end --}}
                            <span>Rent Now</span>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
