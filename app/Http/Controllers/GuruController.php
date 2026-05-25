<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Exports\RekapTabunganExport;
use Maatwebsite\Excel\Facades\Excel;

class GuruController extends Controller
{
    // Fungsi eksekusi download spreadsheet
public function downloadExcel(Request $request)
{
    $guruId = Auth::user()->id;
    
    // Cari kelas binaan guru yang aktif
    $kelas = DB::table('kelas')->where('guru_id', $guruId)->first();
    
    if (!$kelas) {
        return back()->with('error', 'Akses ditolak. Anda bukan Wali Kelas.');
    }

    // Ambil input filter bulan & tahun dari form. Jika kosong, default ke bulan sekarang
    $bulan = $request->input('bulan', date('m'));
    $tahun = $request->input('tahun', date('Y'));

    $namaFile = 'Rekap_Tabungan_Kelas_' . $kelas->nama_kelas . '_' . $bulan . '_' . $tahun . '.xlsx';

    // Eksekusi download via package Maatwebsite
    return Excel::download(new RekapTabunganExport($kelas->id, $bulan, $tahun), $namaFile);
}
    public function dashboard()
    {
        $guruId = Auth::id();

        // 1. Ambil data kelas yang dipegang oleh guru yang sedang login
        $kelas = DB::table('kelas')->where('guru_id', $guruId)->first();

        $totalSiswa = 0;
        $daftarSiswa = [];
        $kasKelas = 0;
        $transaksiHariIni = 0;

        if ($kelas) {
            // 2. Hitung total siswa di kelas tersebut
            $totalSiswa = DB::table('siswa')->where('kelas_id', $kelas->id)->count();

            // 3. Ambil daftar nama siswa untuk ditampilkan di tabel
            $daftarSiswa = DB::table('siswa')->where('kelas_id', $kelas->id)->get();

            // --- AMUNISI BARU (OPSI A) ---
            // Ambil semua ID siswa di kelas ini untuk filter transaksi [1, 2, 3, ...]
            $siswaIds = DB::table('siswa')->where('kelas_id', $kelas->id)->pluck('id');

            if ($siswaIds->isNotEmpty()) {
                // A. Hitung Matematika Kas Kelas (Total Setor - Total Tarik)
                $totalSetor = DB::table('transaksi')->whereIn('siswa_id', $siswaIds)->where('jenis', 'setor')->sum('jumlah');
                $totalTarik = DB::table('transaksi')->whereIn('siswa_id', $siswaIds)->where('jenis', 'tarik')->sum('jumlah');
                $kasKelas = $totalSetor - $totalTarik;

                // B. Hitung Transaksi Hari Ini (Menggunakan filter tanggal sekarang harian)
                $transaksiHariIni = DB::table('transaksi')
                    ->whereIn('siswa_id', $siswaIds)
                    ->whereDate('created_at', date('Y-m-d'))
                    ->count();
            }
        }

            // 4. Kirim data nyata hasil hitungan ke view dashboard/guru.blade.php
            return view('dashboard.guru', compact('totalSiswa', 'daftarSiswa', 'kelas', 'kasKelas', 'transaksiHariIni'));
        }

        // 1. Menampilkan halaman form transaksi
        public function formTransaksi($id)
        {
            // Ambil data siswa berdasarkan ID yang diklik
            $siswa = DB::table('siswa')->where('id', $id)->first();

            if (!$siswa) {
                abort(404, 'Siswa tidak ditemukan!');
            }

            return view('dashboard.form_transaksi', compact('siswa'));
        }

        // 2. Menyimpan data transaksi ke database
        public function simpanTransaksi(Request $request)
        {
            // Validasi input
            $request->validate([
                'siswa_id' => 'required',
                'jenis' => 'required|in:setor,tarik',
                'jumlah' => 'required|numeric|min:1000', // Minimal setor/tarik Rp 1.000
                'keterangan' => 'nullable|string',
            ]);

            // Simpan ke tabel transaksi
            DB::table('transaksi')->insert([
                'siswa_id' => $request->siswa_id,
                'guru_id' => Auth::id(), // Siapa guru yang menginput
                'jumlah' => $request->jumlah,
                'jenis' => $request->jenis,
                'keterangan' => $request->keterangan,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Kembali ke dashboard dengan pesan sukses
            return redirect('/guru/dashboard')->with('success', 'Transaksi berhasil dicatat!');
        }
            
        public function detailTabungan($id)
        {
            // 1. Ambil data siswa
            $siswa = DB::table('siswa')
                ->join('kelas', 'siswa.kelas_id', '=', 'kelas.id')
                ->where('siswa.id', $id)
                ->select('siswa.*', 'kelas.nama_kelas')
                ->first();

            if (!$siswa) {
                abort(404, 'Siswa tidak ditemukan!');
            }

            // 2. Ambil semua riwayat transaksi siswa ini (urutkan dari yang terbaru)
            $riwayat = DB::table('transaksi')
                ->join('users', 'transaksi.guru_id', '=', 'users.id')
                ->where('transaksi.siswa_id', $id)
                ->select('transaksi.*', 'users.nama as nama_guru')
                ->orderBy('transaksi.created_at', 'desc')
                ->get();

            // 3. Hitung Saldo Akhir secara Real-Time
            $totalSetor = DB::table('transaksi')->where('siswa_id', $id)->where('jenis', 'setor')->sum('jumlah');
            $totalTarik = DB::table('transaksi')->where('siswa_id', $id)->where('jenis', 'tarik')->sum('jumlah');
            $saldo = $totalSetor - $totalTarik;

            return view('dashboard.detail_tabungan', compact('siswa', 'riwayat', 'saldo'));
        }
        // 1. Halaman Utama Menu Transaksi: Cari Siswa Binaan
    public function indexTransaksi(Request $request)
    {
        $guruId = Auth::user()->id;
        
        // Ambil info kelas yang dipegang guru ini
        $kelas = DB::table('kelas')->where('guru_id', $guruId)->first();

        if (!$kelas) {
            return view('dashboard.guru_transaksi_index', ['daftarSiswa' => [], 'kelas' => null]);
        }

        // Query ambil siswa di kelas tersebut, dengan fitur live search nama jika diisi
        $query = DB::table('siswa')->where('kelas_id', $kelas->id);
        if ($request->has('search') && $request->search != '') {
            $query->where('nama', 'LIKE', '%' . $request->search . '%');
        }
        
        $daftarSiswa = $query->get();
        return view('dashboard.guru_transaksi_index', compact('daftarSiswa', 'kelas'));
    }

    // 2. Halaman Utama Menu Detail Tabungan: Filter/Group By Kelas Global
    public function indexSiswa()
    {
        $guruId = Auth::user()->id;
        
        // 1. Cari tahu dulu, guru yang login ini wali kelas di kelas mana
        $kelas = DB::table('kelas')->where('guru_id', $guruId)->first();

        // Antisipasi jika akun guru ini di database belum di-plot sebagai wali kelas oleh Admin
        if (!$kelas) {
            return view('dashboard.guru_siswa_index', [
                'daftarSiswa' => [], 
                'kelas' => null, 
                'error' => 'Akun Anda belum terdaftar sebagai Wali Kelas di sistem. Silakan hubungi bagian Admin/TU.'
            ]);
        }

        // 2. Langsung ambil seluruh siswa yang 'kelas_id'-nya COCOK dengan kelas sang guru
        $daftarSiswa = DB::table('siswa')
            ->where('kelas_id', $kelas->id)
            ->get();

        return view('dashboard.guru_siswa_index', compact('daftarSiswa', 'kelas'));
    }
}