<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Enums\UserRole;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(config('admin.admin_email')) {
            User::firstOrCreate(
                [
                    'email' => config('admin.admin_email'),
                    'role' => UserRole::ADMINISTRATOR,
                    'password' => bcrypt(config('admin.admin_password')),
                ]
            );
        }
    }
}
