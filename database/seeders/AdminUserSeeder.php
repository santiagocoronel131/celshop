<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'lau',
            'email' => 'lau@gmail.com',
            'password' => Hash::make('lau69'), // Cambia 'password' por una contraseña segura
            'role' => 'admin',
        ]);
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
}
