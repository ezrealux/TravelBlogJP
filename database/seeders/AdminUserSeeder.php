<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'wilsonliao1226@gmail.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('Wilsonliao1226'),
                'is_admin' => 1,
                'email_verified_at' => now(),
            ]
        );
    }
}

