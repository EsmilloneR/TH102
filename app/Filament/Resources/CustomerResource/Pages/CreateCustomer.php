<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use App\Filament\Resources\CustomerResource;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Hash;

class CreateCustomer extends CreateRecord
{
    protected static string $resource = CustomerResource::class;

        protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Create user with role "user"
        $user = User::create([
            'name' => $data['first_name'].' '.$data['last_name'],
            'email' => $data['email'],
            'password' => Hash::make('password123'),
            'role' => 'user',
        ]);

        // Link customer to that user
        $data['user_id'] = $user->id;

        return $data;
    }
}
