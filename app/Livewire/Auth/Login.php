<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;

class Login extends Component
{
    // Declare properties for the form fields
    #[Validate('required|email|exists:users,email')]
    public string $email = '';

    #[Validate('required|min:6')]
    public string $password = '';

    public function save()
    {
        $this->validate();
        // Attempt to authenticate the user
        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            if (Auth::user()->role == 'admin') {
                return redirect()->intended('/admin');
            }

            session()->flash('message', 'Login successful!');
            return redirect()->route('/');
        } else {
            session()->flash('error', 'Invalid credentials!');
        }
        $this->addError('email', 'Invalid credentials, please try again.');
        $this->addError('password', 'Invalid credentials, please try again.');
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
