<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    
       public function run(): void {
    \App\Models\User::create([
        'name' => 'Super Admin',
        'email' => 'superadmin@.com',
        'password' => bcrypt('Super@2026'),
        'role' => 'super_admin',
        'matricule' => 'FB-SA-01',
        'profile_photo' => 'defaults/admin_profile.jpg',
        'is_verified' => true,
    ]);
}
    
}