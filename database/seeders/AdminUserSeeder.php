<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = \App\Models\User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Administrador',
                'password' => bcrypt('123456'),
                'email_verified_at' => now(),
            ]
        );
        if (!$user->hasRole('super-admin')) {
            try {
                $user->assignRole('super-admin');
            } catch (\Exception $e) {
                // ignore if role not present
            }
        }
    }
}
