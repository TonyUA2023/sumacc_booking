<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminsTableSeeder extends Seeder
{
    public function run()
    {
        // Cambia estos datos por algo que recuerdes:
        $username = 'Admin';
        $email    = 'admin@sumacccarwash.com';
        $password = 'Sumacc2025@'; // ¡En un entorno real, pon uno más seguro!

        Admin::firstOrCreate(
            ['email' => $email],
            [
                'username'      => $username,
                'password_hash' => Hash::make($password),
                'first_name'    => 'Victor',
                'last_name'     => 'Merino',
            ]
        );
    }
}