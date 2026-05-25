<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Akun Guru (Budi)
        $guru = User::create([
            'nama' => 'Budi Utomo, S.Pd.',
            'username' => 'gurubudi',
            'password' => Hash::make('password123'),
            'jenis_kelamin' => 'L',
            'role' => 'guru',
        ]);

        // 2. Buat Akun Orang Tua (Slamet)
        $ortu = User::create([
            'nama' => 'Slamet (Orang Tua)',
            'username' => 'ortuslamet',
            'password' => Hash::make('password123'),
            'jenis_kelamin' => 'L',
            'role' => 'orang_tua', // Tetap pakai orang_tua sesuai DB asli kamu
        ]);

        // 3. Buat Data Kelas 6A (Wali Kelasnya Pak Budi)
        $kelasId = DB::table('kelas')->insertGetId([
            'nama_kelas' => 'Kelas 6A',
            'guru_id' => $guru->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 4. Buat Data Siswa Dummy (Anaknya Pak Slamet, Berada di Kelas 6A)
        DB::table('siswa')->insert([
            'nama' => 'Ahmad Fauzi',
            'nisn' => '0123456789',
            'kelas_id' => $kelasId,
            'ortu_id' => $ortu->id, // Tetap pakai ortu_id sesuai DB asli kamu
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // ====================================================================
        // AMUNISI TAMBAHAN SIMULASI MULTI-ANAK (PASTIKAN SYNC DENGAN DI ATAS)
        // ====================================================================

        // 5. Buat Akun Orang Tua Kedua (Pak Joko) - Role disamakan 'orang_tua'
        $ortuJokoId = DB::table('users')->insertGetId([
            'nama' => 'Joko Susanto (Wali Ahmad & Siti)',
            'username' => 'joko123',
            'password' => Hash::make('orangtua123'),
            'role' => 'orang_tua', // Disesuaikan pakai underscore
            'jenis_kelamin' => 'L',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 6. Hubungkan Ahmad Fauzi agar sekarang beralih wali ke Pak Joko
        DB::table('siswa')->where('nama', 'Ahmad Fauzi')->update([
            'ortu_id' => $ortuJokoId // Menggunakan nama kolom asli kamu: ortu_id
        ]);

        // 7. Buat data anak kedua Pak Joko (Siti Aminah) di kelas 6A
        DB::table('siswa')->insert([
            'nama' => 'Siti Aminah',
            'nisn' => '0123456788',
            'kelas_id' => $kelasId,
            'ortu_id' => $ortuJokoId, // Menggunakan nama kolom asli kamu: ortu_id
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}