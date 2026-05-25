<?php

namespace App\Http\Controllers\OrangTua;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exports\SiswaMutasiExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Auth;

class TabunganController extends Controller
{
    public function index()
    {
        // Ambil data orang tua yang sedang login beserta anak-anaknya
        $ortu = Auth::guard('orangtua')->user();
        
        // Misal relasi di model OrangTua ke Siswa adalah data anak-anaknya
        $daftarAnak = DB::table('siswa')->where('orangtua_id', $ortu->id)->get();

        return view('orangtua.tabungan.index', compact('daftarAnak'));
    }

    public function downloadExcel($siswa_id, $bulan, $tahun)
    {
        $ortu = Auth::guard('orangtua')->user();

        // 🛡️ SECURITY CHECK: Pastikan siswa yang mau didownload beneran anak dari ortu tersebut
        $siswa = DB::table('siswa')
            ->where('id', $siswa_id)
            ->where('orangtua_id', $ortu->id)
            ->first();

        if (!$siswa) {
            abort(403, 'Akses Ditolak! Ini bukan data anak Anda.');
        }

        // Format nama file agar rapi saat didownload ortu
        $namaFile = 'Rekap_Tabungan_' . str_replace(' ', '_', $siswa->nama) . '_' . $bulan . '_' . $tahun . '.xlsx';

        // Eksekusi download menggunakan class export single sheet kita tadi
        return Excel::download(new SiswaMutasiExport($siswa, $bulan, $tahun), $namaFile);
    }
}