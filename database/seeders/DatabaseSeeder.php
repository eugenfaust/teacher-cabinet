<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $adminPassword = env("DEFAULT_ADMIN_PASSWORD", "12345");
        $adminEmail = env("DEFAULT_ADMIN_EMAIL", "admin@admin.com");
        User::factory()->create([
            'name' => 'Administrator',
            'email' => $adminEmail,
            'password' => Hash::make($adminPassword),
            'is_admin' => true,
        ]);
    }
}
