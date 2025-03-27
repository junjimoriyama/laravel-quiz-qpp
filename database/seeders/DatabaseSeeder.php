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
        // 管理者ユーザー
        User::updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'j',
                'password' => Hash::make('123'),
                'is_admin' => true,
            ]
        );

        // 一般ユーザー
        User::updateOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'jj',
                'password' => Hash::make('111'),
                'is_admin' => false,
                ]
        );
    }
}

// public function run(): void
// {
//     // 管理者ユーザー
//     $admin = User::firstOrNew(['email' => 'test@example.com']);
//     $admin->forceFill([
//         'name' => 'j',
//         'password' => Hash::make('123'),
//         'is_admin' => true,
//     ])->save();

//     // 一般ユーザー
//     $user = User::firstOrNew(['email' => 'user@example.com']);
//     $user->forceFill([
//         'name' => 'jj',
//         'password' => Hash::make('111'),
//         'is_admin' => false,
//     ])->save();
// }
