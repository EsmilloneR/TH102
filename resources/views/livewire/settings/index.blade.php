<div class="flex max-w-4xl mx-auto mt-8 bg-white shadow rounded-lg overflow-hidden">

    {{-- Sidebar --}}
    <aside class="w-1/4 bg-gray-100 p-4 border-r">
        <ul class="space-y-2">
            <li>
                <button wire:click="switchTab('profile')"
                    class="w-full text-left px-3 py-2 rounded {{ $tab === 'profile' ? 'bg-blue-600 text-white' : 'hover:bg-gray-200' }}">
                    Profile
                </button>
            </li>
            <li>
                <button wire:click="switchTab('password')"
                    class="w-full text-left px-3 py-2 rounded {{ $tab === 'password' ? 'bg-blue-600 text-white' : 'hover:bg-gray-200' }}">
                    Change Password
                </button>
            </li>
            <li>
                <button wire:click="switchTab('appearance')"
                    class="w-full text-left px-3 py-2 rounded {{ $tab === 'appearance' ? 'bg-blue-600 text-white' : 'hover:bg-gray-200' }}">
                    Appearance
                </button>
            </li>
        </ul>
    </aside>

    {{-- Main Content --}}
    <main class="flex-1 p-6">
        @if (session()->has('success'))
            <div class="mb-4 p-2 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        {{-- Profile Tab --}}
        @if ($tab === 'profile')
            <h2 class="text-lg font-bold mb-4">Profile Settings</h2>
            <form wire:submit.prevent="saveProfile" class="space-y-4">
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

                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Save</button>
            </form>
        @endif

        {{-- Password Tab --}}
        @if ($tab === 'password')
            <h2 class="text-lg font-bold mb-4">Change Password</h2>
            <form wire:submit.prevent="changePassword" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium">Current Password</label>
                    <input type="password" wire:model="current_password" class="w-full mt-1 p-2 border rounded" />
                    @error('current_password')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium">New Password</label>
                    <input type="password" wire:model="new_password" class="w-full mt-1 p-2 border rounded" />
                    @error('new_password')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium">Confirm Password</label>
                    <input type="password" wire:model="new_password_confirmation"
                        class="w-full mt-1 p-2 border rounded" />
                </div>

                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Update Password</button>
            </form>
        @endif

        {{-- Appearance Tab --}}
        @if ($tab === 'appearance')
            <h2 class="text-lg font-bold mb-4">Appearance</h2>
            <form wire:submit.prevent="saveAppearance" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium">Theme</label>
                    <select wire:model="theme" class="w-full mt-1 p-2 border rounded">
                        <option value="light">Light</option>
                        <option value="dark">Dark</option>
                    </select>
                </div>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Save Appearance</button>
            </form>
        @endif
    </main>
</div>
