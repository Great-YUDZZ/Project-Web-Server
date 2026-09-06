<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@tkj.lan'],
            [
                'name' => 'Yuda Pratama (Admin TKJ)',
                'password' => Hash::make('AdminTKJ2026!'),
                'email_verified_at' => now(),
            ]
        );
    }
}
