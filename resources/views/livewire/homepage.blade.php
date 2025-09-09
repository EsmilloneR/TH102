<div>
    {{--  Hero Section  --}}
    <section class="relative h-[43rem] bg-cover bg-center"
        style="background-image: url('{{ asset('storage/images/bg.jpg') }}')">
        <!-- Red transparent overlay -->

        <!-- Content -->
        <div class="relative z-10 flex flex-col items-center justify-end h-full text-center text-white px-6 pb-10">
            <div>
                <h2 class="text-3xl font-bold">RENT <span class="text-red-600">Cars</span></h2>
            </div>
            <div class="bg-white text-black rounded-2xl shadow-lg p-6 flex flex-col  items-center gap-6">

                <form wire:submit.prevent="search" method="POST" class="flex flex-col md:flex-row gap-4 items-center">
                    <!-- Rent Start -->
                    <div>
                        <label class="block text-sm font-semibold">Rent Start</label>
                        <input type="date" class="border rounded-lg px-3 py-2" wire:model="rental_start">
                    </div>
                    <!-- Rent End -->
                    <div>
                        <label class="block text-sm font-semibold">Rent End</label>
                        <input type="date" class="border rounded-lg px-3 py-2" wire:model="rental_end">
                    </div>
                    <!-- Search Button -->
                    <button type="submit" class="bg-black text-white p-3 rounded-full hover:bg-red-600 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </section>

    {{-- Hero End --}}

    {{-- Services Start --}}
    <section id="services" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <h2 class="text-3xl font-bold text-red-600 mb-12">Our Services</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-8">

                <!-- Pickup & Drop-off -->
                <div class="bg-white shadow-lg rounded-xl p-6 hover:shadow-2xl transition">
                    <h3 class="text-xl font-semibold text-black mb-3">Pickup & Drop-off</h3>
                    <p class="text-gray-600">Convenient door-to-door car delivery and return service.</p>
                </div>


                <!-- Roundtrip -->
                <div class="bg-white shadow-lg rounded-xl p-6 hover:shadow-2xl transition">
                    <h3 class="text-xl font-semibold text-black mb-3">Roundtrip</h3>
                    <p class="text-gray-600">Perfect for return trips with cost-saving packages.</p>
                </div>

                <!-- 24 Hours -->
                <div class="bg-white shadow-lg rounded-xl p-6 hover:shadow-2xl transition">
                    <h3 class="text-xl font-semibold text-black mb-3">24 Hours</h3>
                    <p class="text-gray-600">Get the car for a full 24 hours – unlimited freedom.</p>
                </div>


                <!-- Monthly Rentals -->
                <div class="bg-white shadow-lg rounded-xl p-6 hover:shadow-2xl transition">
                    <h3 class="text-xl font-semibold text-black mb-3">Monthly Rentals</h3>
                    <p class="text-gray-600">Long-term rentals at the best monthly rates.</p>
                </div>

            </div>
        </div>
    </section>

    {{-- Services End --}}


    {{-- Booking Start --}}
    {{-- <section id="booking" class="py-20">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <h3 class="text-3xl font-bold mb-6">Book Your Car</h3>
            @livewire('browse-cars')
        </div>
    </section> --}}
    {{-- Booking End --}}
</div>
