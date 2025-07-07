<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        // Create admin user if not exists
        if (!User::where('email', 'admin@ekraf.com')->exists()) {
            User::create([
                'name' => 'Admin EKRAF',
                'email' => 'admin@ekraf.com',
                'password' => Hash::make('password'),
                'level_id' => 1, // Superadmin
                'email_verified_at' => now(),
            ]);
        }

        // Create regular admin user if not exists
        if (!User::where('email', 'admin2@ekraf.com')->exists()) {
            User::create([
                'name' => 'Admin EKRAF 2',
                'email' => 'admin2@ekraf.com', 
                'password' => Hash::make('password'),
                'level_id' => 2, // Admin
                'email_verified_at' => now(),
            ]);
        }
    }
}
