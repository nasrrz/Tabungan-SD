<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class RekapTabunganExport implements WithMultipleSheets
{
    protected $kelasId;
    protected $bulan;
    protected $tahun;

    public function __construct($kelasId, $bulan, $tahun)
    {
        $this->kelasId = $kelasId;
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    /**
     * Mengatur sheet apa saja yang akan dibuat di dalam satu file Excel
     */
    public function sheets(): array
    {
        $sheets = [];

        // 1. Ambil semua siswa di kelas ini, URUTKAN BERDASARKAN NAMA (Absen 1 - Akhir)
        $daftarSiswa = DB::table('siswa')
            ->where('kelas_id', $this->kelasId)
            ->orderBy('nama', 'ASC') // <-- Kunci pengurutan absen di sini, Bro!
            ->get();

        // 2. Sheet Pertama: Ringkasan Global Satu Kelas
        $sheets[] = new \App\Exports\Sheets\RingkasanKelasSheet($this->kelasId, $this->bulan, $this->tahun, $daftarSiswa);

        // 3. Sheet Berikutnya: Detail Mutasi Per Siswa untuk Orang Tua
        foreach ($daftarSiswa as $siswa) {
            $sheets[] = new \App\Exports\Sheets\DetailSiswaSheet($siswa, $this->bulan, $this->tahun);
        }

        return $sheets;
    }
}