<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Menyuntikkan user Admin Utama (Tata Usaha) ke dalam tabel users
        DB::table('users')->insert([
            'nama' => 'Admin',
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'jenis_kelamin' => 'L',
            'role' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
    
}