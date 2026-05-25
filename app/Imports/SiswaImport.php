<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;

class SiswaImport implements ToCollection, WithHeadingRow
{
    protected $kelasId;

    // Menangkap ID kelas yang dipilih admin di form web
    public function __construct($kelasId)
    {
        $this->kelasId = $kelasId;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Skip jika baris nisn atau nama di Excel kosong melompong
            if (empty($row['nisn']) || empty($row['nama'])) {
                continue;
            }

            // Cek Duplikasi NISN agar tidak ganda di DB
            $cekSiswa = DB::table('siswa')->where('nisn', trim($row['nisn']))->first();
            if ($cekSiswa) {
                continue; 
            }

            // Langsung colok ke database, dijamin 100% masuk karena ID Kelas sudah valid dari dropdown!
            DB::table('siswa')->insert([
                'nisn'       => trim($row['nisn']),
                'nama'       => trim($row['nama']),
                'kelas_id'   => $this->kelasId, // 👈 Diambil langsung dari dropdown form web!
                'ortu_id'    => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}