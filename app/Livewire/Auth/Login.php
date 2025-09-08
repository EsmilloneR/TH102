<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;

class Login extends Component
{
    // Declare properties for the form fields
    public string $email = '';
    public string $password = '';


    #[Validate([
        'email' => 'required|email|exists:users,email',
        'password' => 'required|min:6',
    ])]
    public function save()
    {
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
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
