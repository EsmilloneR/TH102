<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Index extends Component
{
    public $tab = 'profile';

    // Profile fields
    public $name, $email, $phone_number;

    // Password fields
    public $current_password, $new_password, $new_password_confirmation;

    // Appearance field
    public $theme = 'light'; // default theme

    public function mount()
    {
        $user = Auth::user();
        $this->name  = $user->name;
        $this->email = $user->email;
        $this->phone_number = $user->phone_number ?? '';
        $this->theme = $user->theme ?? 'light'; // assuming you add "theme" column to users table
    }

    public function switchTab($tab)
    {
        $this->tab = $tab;
    }

    public function saveProfile()
    {
        $this->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'phone_number' => 'nullable|string|max:20',
        ]);

        Auth::user()->update([
            'name'  => $this->name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
        ]);

        session()->flash('success', 'Profile updated successfully!');
    }

    public function changePassword()
    {
        $this->validate([
            'current_password' => 'required',
            'new_password'     => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($this->current_password, $user->password)) {
            $this->addError('current_password', 'Current password is incorrect.');
            return;
        }

        $user->update([
            'password' => Hash::make($this->new_password),
        ]);

        $this->reset(['current_password', 'new_password', 'new_password_confirmation']);
        session()->flash('success', 'Password updated successfully!');
    }

    public function saveAppearance()
    {
        Auth::user()->update(['theme' => $this->theme]);
        session()->flash('success', 'Appearance updated!');
    }

    public function render()
    {
        return view('livewire.settings.index');
    }
}
