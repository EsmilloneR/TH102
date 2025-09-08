<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Title('Forgot Password')]
#[Layout('components.layouts.app')]

class ForgotPassword extends Component
{
    public $email;

    /**
     * Send a password reset link to the provided email address.
     */
    public function save(): void
    {
        $this->validate([
            'email' => 'required|email|exists:users,email|max:255',
        ]);

        $status = Password::sendResetLink(['email' => $this->email]);

        if($status === Password::RESET_LINK_SENT){
            session()->flash('success', __('A Password reset link will be sent if the account exists.'));
        }
    }

    public function render()
    {
        return view('livewire.auth.forgot-password');
    }
}
