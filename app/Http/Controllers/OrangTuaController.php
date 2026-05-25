<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Exports\SiswaMutasiExport;
use Maatwebsite\Excel\Facades\Excel;

class OrangTuaController extends Controller
{
    // =========================================================================
    // FITUR AKSES USER ORANG TUA (DASHBOARD & MONITORING TABUNGAN ANAK)
    // =========================================================================

    public function dashboard()
    {
        $ortuId = Auth::user()->id;

        // Ambil semua anak berdasarkan kolom ORTU_ID (Bukan orangtua_id)
        $anakSiswa = DB::table('siswa')
            ->leftJoin('kelas', 'siswa.kelas_id', '=', 'kelas.id')
            ->where('siswa.ortu_id', $ortuId)
            ->select('siswa.*', 'kelas.nama_kelas')
            ->get();

        // Jika orang tua belum punya data anak yang di-plot oleh admin
        if ($anakSiswa->isEmpty()) {
            return view('dashboard.orangtua', ['dataTabunganAnak' => [], 'error' => 'Belum ada data anak terhubung. Silakan hubungi bagian Admin/TU.']);
        }

        // Loop untuk menghitung saldo dan riwayat masing-masing anak
        $dataTabunganAnak = [];
        foreach ($anakSiswa as $siswa) {
            // Hitung Saldo Real-time
            $setor = DB::table('transaksi')->where('siswa_id', $siswa->id)->where('jenis', 'setor')->sum('jumlah');
            $tarik = DB::table('transaksi')->where('siswa_id', $siswa->id)->where('jenis', 'tarik')->sum('jumlah');
            $saldo = $setor - $tarik;

            // Ambil Riwayat Transaksi dari Awal Nabung (Urut paling baru di atas)
            $riwayat = DB::table('transaksi')
                ->where('siswa_id', $siswa->id)
                ->orderBy('created_at', 'desc')
                ->get();

            // REKAP BULANAN (TKJ DATA MINING OPTIMIZATION)
            $rekapBulanan = DB::table('transaksi')
                ->where('siswa_id', $siswa->id)
                ->select(
                    DB::raw('YEAR(created_at) as tahun'),
                    DB::raw('MONTH(created_at) as bulan'),
                    DB::raw('SUM(CASE WHEN jenis = "setor" THEN jumlah ELSE 0 END) as total_setor'),
                    DB::raw('SUM(CASE WHEN jenis = "tarik" THEN jumlah ELSE 0 END) as total_tarik')
                )
                ->groupBy('tahun', 'bulan')
                ->orderBy('tahun', 'desc')
                ->orderBy('bulan', 'desc')
                ->get();

            // Bungkus semua data ke dalam satu array rapi
            $dataTabunganAnak[] = [
                'identitas' => $siswa,
                'saldo' => $saldo,
                'riwayat' => $riwayat,
                'rekap' => $rekapBulanan
            ];
        }

        return view('dashboard.orangtua', compact('dataTabunganAnak'));
    }

    public function downloadExcel($siswa_id, $bulan, $tahun)
    {
        $ortuId = Auth::user()->id;

        // 🛡️ SECURITY CHECK (Khas Anak TKJ): Pastikan siswa tersebut beneran anak dari ortu yang login
        $siswa = DB::table('siswa')
            ->where('id', $siswa_id)
            ->where('ortu_id', $ortuId)
            ->first();

        if (!$siswa) {
            abort(403, 'Akses Ditolak! Anda tidak berhak mendownload data anak ini.');
        }

        // Buat nama file rapi tanpa spasi
        $namaFile = 'Rekap_Tabungan_' . str_replace(' ', '_', $siswa->nama) . '_' . $bulan . '_' . $tahun . '.xlsx';

        // Eksekusi download memanggil class tunggal SiswaMutasiExport
        return Excel::download(new SiswaMutasiExport($siswa, $bulan, $tahun), $namaFile);
    }
}