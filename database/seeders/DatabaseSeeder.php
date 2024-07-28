<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        User::create([
            'nama' => 'Admin',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
            'password' => Hash::make('12345678')
        ]);
        
        User::create([
            'nama' => 'Pemilik',
            'email' => 'pemilik@gmail.com',
            'role' => 'pemilik',
            'password' => Hash::make('12345678')
        ]);

        User::create([
            'nama' => 'Logistik',
            'email' => 'logistik@gmail.com',
            'role' => 'logistik',
            'password' => Hash::make('12345678')
        ]);
    }
}
