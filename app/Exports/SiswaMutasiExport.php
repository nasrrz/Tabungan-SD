<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\Sheets\DetailSiswaSheet;

class SiswaMutasiExport implements WithMultipleSheets
{
    protected $siswa;
    protected $bulan;
    protected $tahun;

    public function __construct($siswa, $bulan, $tahun)
    {
        $this->siswa = $siswa;
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    /**
     * Hanya me-return 1 sheet saja khusus detail mutasi anak tersebut
     */
    public function sheets(): array
    {
        $sheets = [];
        $sheets[] = new DetailSiswaSheet($this->siswa, $this->bulan, $this->tahun);
        
        return $sheets;
    }
}