<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'FoodieBert Master',
            'email' => 'sarahazimpey@gmail.com', // Change to your email
            'password' => Hash::make('SaraH@2003'), // Change to your password
            'role' => 'super_admin',
            'profile_photo' => null, // You can upload this later via the dashboard
        ]);
    }
}