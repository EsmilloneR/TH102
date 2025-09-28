<div class="max-w-xl mx-auto p-6 bg-white shadow rounded-lg">
    <h2 class="text-xl font-bold mb-4">Profile Settings</h2>

    @if (session()->has('success'))
        <div class="mb-4 p-2 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="save" class="space-y-4">
        <div>
            <label class="block text-sm font-medium">Name</label>
            <input type="text" wire:model="name" class="w-full mt-1 p-2 border rounded" />
            @error('name')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium">Email</label>
            <input type="email" wire:model="email" class="w-full mt-1 p-2 border rounded" />
            @error('email')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium">Phone</label>
            <input type="text" wire:model="phone_number" class="w-full mt-1 p-2 border rounded" />
            @error('phone_number')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex justify-end">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Save Changes
            </button>
        </div>
    </form>
</div>
