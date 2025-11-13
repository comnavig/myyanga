<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@myyanga.com',
            'mobile' => '08012345678',
            'password' => Hash::make('password'),
            'avatar' => 'default-avatar.png',
            'status' => 'active',
            'type' => 'ADMIN',
            'email_verified_at' => now(),
        ]);

        // Create regular users
        User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'mobile' => '08023456789',
            'password' => Hash::make('password'),
            'avatar' => 'default-avatar.png',
            'status' => 'active',
            'type' => 'USER',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'mobile' => '08034567890',
            'password' => Hash::make('password'),
            'avatar' => 'default-avatar.png',
            'status' => 'active',
            'type' => 'USER',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Business Owner',
            'email' => 'business@example.com',
            'mobile' => '08045678901',
            'password' => Hash::make('password'),
            'avatar' => 'default-avatar.png',
            'status' => 'active',
            'type' => 'BUSINESS',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Vendor Account',
            'email' => 'vendor@example.com',
            'mobile' => '08056789012',
            'password' => Hash::make('password'),
            'avatar' => 'default-avatar.png',
            'status' => 'active',
            'type' => 'BUSINESS',
            'email_verified_at' => now(),
        ]);
    }
}
