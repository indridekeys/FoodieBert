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
        'email' => 'sarahazimpey@gmail.com',
        'password' => bcrypt('AdmiN@2003'),
        'role' => 'super_admin',
        'matricule' => 'FB_ADMIN_001',
        'profile_photo' => 'uploads/admin_profile.jpg',
        'is_verified' => true,
    ]);
}
    
}