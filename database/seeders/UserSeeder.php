<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::where('name', 'admin')->first();
        $supervisorRole = Role::where('name', 'supervisor')->first();
        $driverRole = Role::where('name', 'driver')->first();

        User::create([
            'name' => 'Admin User',
            'username' => 'admin',
            'email' => 'admin@pt.com',
            'password' => Hash::make('12345678'),
            'role_id' => $adminRole->id,
        ]);

        User::create([
            'name' => 'Supervisor User',
            'username' => 'supervisor',
            'email' => 'supervisor@pt.com',
            'password' => Hash::make('12345678'),
            'role_id' => $supervisorRole->id,
        ]);

        User::create([
            'name' => 'Driver User',
            'username' => 'driver',
            'email' => 'driver@pt.com',
            'password' => Hash::make('12345678'),
            'role_id' => $driverRole->id,
        ]);
    }
}
