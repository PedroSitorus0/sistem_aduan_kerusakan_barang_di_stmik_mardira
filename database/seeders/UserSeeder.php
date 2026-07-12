<?php

namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            ['name' => 'Pedro Armando Sitorus', 'email' => 'pedrositorus0@gmail.com', 'role' => 'dev'],
            ['name' => 'Teknisi STMIK', 'email' => 'teknisi@stmik-mi.ac.id', 'role' => 'teknisi'],
            ['name' => 'Test User', 'email' => 'example@gmail.com', 'role'=> 'user'],

        ];
        $defaultPassword = Hash::make('admin123'); //ini passswordnya

        foreach($users as $user) {
            User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'role' => $user['role'],
                'password' => $defaultPassword,
                'nomor_identitas' => null,
                'phone' => null,
            ]);
        }
    }
}
