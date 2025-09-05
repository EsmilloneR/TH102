<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
    <section class="overflow-hidden bg-white py-11 font-poppins dark:bg-gray-800">
        <div class="max-w-6xl px-4 py-4 mx-auto lg:py-8 md:px-6">
            <div class="flex flex-wrap -mx-4">
                <!-- LEFT: Images -->
                <div class="w-full mb-8 md:w-1/2 md:mb-0" x-data="{ mainImage: '{{ url('storage', $vehicle->images[0]) }}' }">

                    <div class="sticky top-0 overflow-hidden">
                        <!-- Main Image -->
                        <div class="relative mb-6">
                            <img x-bind:src="mainImage" alt="{{ $vehicle->make }} {{ $vehicle->model }}"
                                class="object-cover w-full h-[400px] rounded-lg shadow-md">
                        </div>

                        <!-- Thumbnails -->
                        <div class="flex flex-wrap gap-2">
                            @foreach ($vehicle->images as $image)
                                <div class="w-20 h-20 cursor-pointer border rounded-md overflow-hidden hover:border-red-500"
                                    x-on:click="mainImage='{{ url('storage', $image) }}'">
                                    <img src="{{ url('storage', $image) }}"
                                        alt="{{ $vehicle->make }} {{ $vehicle->model }}"
                                        class="object-cover w-full h-full">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- RIGHT: Details -->
                <div class="w-full px-4 md:w-1/2">
                    <div class="lg:pl-10">
                        <div class="mb-8 [&>ul]:list-disc [&>ul]:pl-6 [&>ul]:text-gray-700 dark:[&>ul]:text-gray-400">
                            <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-200">
                                <span class="text-red-600 dark:text-red-600">{{ $vehicle->make }}</span>
                                {{ $vehicle->model }}
                                {{ $vehicle->year }}
                            </h2>
                            <p class="text-md font-bold text-gray-800 dark:text-gray-200 mb-3">Seats:
                                {{ $vehicle->seats }}</p>
                            <p class="text-2xl font-semibold  mb-4">
                                <span
                                    class="text-green-600 dark:text-green-400">{{ Number::currency($vehicle->rate_day, 'PHP') }}</span>
                                / day
                            </p>
                            <div
                                class="max-w-md max-h-100 overflow-y-auto pr-2 text-gray-700 dark:text-gray-400
               space-y-3 [&>ul]:list-disc [&>ul]:pl-6 [&>p]:leading-relaxed">
                                {!! Str::markdown($vehicle->description) !!}
                            </div>
                        </div>

                        <!-- Action Button -->
                        <div class="flex flex-wrap items-center gap-4">
                            <button
                                class="w-full p-4 bg-red-600 rounded-md lg:w-2/5 text-white hover:bg-red-700 transition">
                                Rent Now
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
