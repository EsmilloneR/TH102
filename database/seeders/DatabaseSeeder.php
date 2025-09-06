<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(1)->create();

        User::factory()->create([
            'name' => 'Yasha',
            'email' => 'admin@gmail.com',
            'phone_number' => '09276676984',
            'role' => 'admin',
            'password' => Hash::make('admin123')
        ]);
    }
}
