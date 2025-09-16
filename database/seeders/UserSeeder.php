<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 建立管理員帳號
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password123'), // 建議改強一點
                'avatar' => 'avatars/admin.png', // 假設存在於 storage/app/public/avatars
            ]
        );

        // 建立一般使用者
        User::updateOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Test User',
                'password' => Hash::make('password123'),
                'avatar' => 'avatars/default.png',
            ]
        );

        // 產生隨機使用者
        User::factory(10)->create()->each(function ($user) {
            $user->avatar = 'https://i.pravatar.cc/200?u=' . $user->id;
            $user->save();
        });
    }
}
