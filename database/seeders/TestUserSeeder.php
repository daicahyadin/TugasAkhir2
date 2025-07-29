<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TestUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Super Admin Test User (sudah diverifikasi)
        $superAdmin = User::firstOrCreate([
            'email' => 'superadmin@test.com',
        ], [
            'name' => 'Super Admin Test',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
            'is_verified' => true,
        ]);
        $superAdmin->assignRole('superadmin');

        // Admin Test User (sudah diverifikasi)
        $admin = User::firstOrCreate([
            'email' => 'admin@test.com',
        ], [
            'name' => 'Admin Test',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
            'is_verified' => true,
        ]);
        $admin->assignRole('admin');

        // Customer Test User (sudah diverifikasi)
        $customer = User::firstOrCreate([
            'email' => 'customer@test.com',
        ], [
            'name' => 'Customer Test',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
            'is_verified' => true,
        ]);
        $customer->assignRole('customer');

        $this->command->info('Test users created successfully!');
        $this->command->info('Super Admin: superadmin@test.com / password123');
        $this->command->info('Admin: admin@test.com / password123');
        $this->command->info('Customer: customer@test.com / password123');
    }
} 