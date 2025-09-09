<div class="max-w-2xl mx-auto p-6 bg-white shadow-lg rounded-xl">
    <h2 class="text-2xl font-bold mb-4">Booking Confirmation</h2>

    <div class="mb-6">
        <p><strong>Car:</strong> {{ $car->make }} {{ $car->model }}</p>
        <p><strong>Rental Dates:</strong> {{ $rental_start }} → {{ $rental_end }}</p>
        <p><strong>Days:</strong> {{ $days }}</p>
        <p><strong>Rate/Day:</strong> ₱{{ number_format($car->rate_day, 2) }}</p>
        <p><strong>Total:</strong> ₱{{ number_format($total, 2) }}</p>
    </div>

    <div class="space-y-4">
        <label for="payment-method" class="block">
            <span class="font-semibold">Choose Payment Method:</span>
            <select id="payment-method" wire:model="payment_method" class="mt-1 block w-full border rounded-lg p-2">
                <option value="cash">Cash on Delivery (Pay at Pickup)</option>
                <option value="online">Online Payment (Pay Now)</option>
            </select>
        </label>

        <button type="submit" wire:click="confirmReservation"
            class="w-full bg-red-600 hover:bg-red-700 text-white py-2 rounded-lg font-bold" wire:loading.attr="disabled"
            wire:loading.class="bg-gray-400 hover:bg-gray-400">
            <span wire:loading.remove>Confirm & Pay</span>
            <span wire:loading>Processing...</span>
        </button>
    </div>
</div>
