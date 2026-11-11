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
        $email = env('ADMIN_EMAIL', 'admin@tkj.lan');
        $password = env('ADMIN_PASSWORD');

        if (! $password) {
            $password = bin2hex(random_bytes(12));
        }

        User::updateOrCreate(
            ['email' => $email],
            [
                'name' => 'I Made Yuda Pramana (Admin TKJ)',
                'password' => Hash::make($password),
                'email_verified_at' => now(),
            ]
        );
    }
}
