<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'is_admin' => true,
            'password' => Hash::make('admin123'),
        ]);
        DB::table('users')->insert([
            'name' => 'User',
            'email' => 'user@example.com',
            'is_admin' => false,
            'password' => Hash::make('user@123'),
        ]);
    }
}
