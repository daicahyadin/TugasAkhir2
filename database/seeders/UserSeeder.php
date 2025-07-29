<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Super Admin
        $superAdmin = User::firstOrCreate([
            'email' => 'superadmin@mrm.com',
        ], [
            'name' => 'Super Admin MRM',
            'password' => Hash::make('superadmin123'),
            'email_verified_at' => now(),
        ]);
        $superAdmin->assignRole('superadmin');

        // Admin
        $admin = User::firstOrCreate([
            'email' => 'daicahyadin2002@gmail.com',
        ], [
            'name' => 'Admin MRM',
            'password' => Hash::make('Cahyadin14'),
            'email_verified_at' => now(),
        ]);
        $admin->assignRole('admin');

        // Sample Customer
        $customer = User::firstOrCreate([
            'email' => 'customer@example.com',
        ], [
            'name' => 'Sample Customer',
            'password' => Hash::make('customer123'),
            'email_verified_at' => now(),
        ]);
        $customer->assignRole('customer');
    }
}
