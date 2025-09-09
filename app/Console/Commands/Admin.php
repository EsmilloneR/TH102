<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class Admin extends Command
{
    protected $signature = 'make:twaynegarage-user';
    protected $description = 'Create a new Drive & Go user with a role';

    public function handle()
    {
        $name = $this->ask('Name');
        $email = $this->ask('Email address');

        if (User::where('email', $email)->exists()) {
            $this->error('This email address is already taken. Please use a different one.');
            return;
        }

        $password = $this->secret('Password');
        $password_confirmation = $this->secret('Confirm Password');

        while($password !== $password_confirmation){
            $this->error("Ehemm... Passwords do not match. Please try again.");
            $password = $this->secret('Password');
            $password_confirmation = $this->secret('Confirm Password');
        }


        $roleName = $this->choice('Role', ['admin', 'renter'], 0);

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => $roleName
        ]);

        if($user->role === 'admin' || $user->role === 'renter'){
            $this->info("Wow! User with Role" .  $roleName  . " created successfully! :>");
        }else{
            $this->info("Utroha!");
        }
    }
}
