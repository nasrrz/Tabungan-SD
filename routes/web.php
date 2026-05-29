<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// 1. Jalur Utama: Jika diakses tanpa login, langsung oper ke form login
Route::get('/', [AuthController::class, 'showLogin']);

// 2. Jalur Autentikasi (Hapus middleware guest untuk sementara agar tidak bentrok)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 3. Jalur Proteksi Dashboard berdasarkan Role
Route::middleware(['auth'])->group(function () {
    
    // Grup Admin
        Route::middleware(['role:admin'])->group(function () {
            Route::get('/admin/dashboard', [\App\Http\Controllers\AdminController::class, 'dashboard']);

            // RUTE IMPORT DATA SISWA SAKTI OLEH ADMIN
            Route::post('/admin/siswa/import-massal', [\App\Http\Controllers\AdminController::class, 'importSiswaMassal']);

            // Rute CRUD Guru
            Route::get('/admin/guru', [\App\Http\Controllers\AdminController::class, 'dataGuru']);
            Route::get('/admin/guru/tambah', [\App\Http\Controllers\AdminController::class, 'formGuru']);
            Route::post('/admin/guru/simpan', [\App\Http\Controllers\AdminController::class, 'simpanGuru']);
            Route::delete('/admin/guru/hapus/{id}', [\App\Http\Controllers\AdminController::class, 'hapusGuru']);
            Route::get('/admin/guru/edit/{id}', [\App\Http\Controllers\AdminController::class, 'editGuru']);
            Route::post('/admin/guru/update', [\App\Http\Controllers\AdminController::class, 'updateGuru']);

            // Rute CRUD Kelas
            Route::get('/admin/kelas', [\App\Http\Controllers\AdminController::class, 'dataKelas']);
            Route::get('/admin/kelas/tambah', [\App\Http\Controllers\AdminController::class, 'formKelas']);
            Route::post('/admin/kelas/simpan', [\App\Http\Controllers\AdminController::class, 'simpanKelas']);
            Route::delete('/admin/kelas/hapus/{id}', [\App\Http\Controllers\AdminController::class, 'hapusKelas']);

            // Rute Siswa & Kelas
            Route::get('/admin/siswa', [\App\Http\Controllers\AdminController::class, 'dataSiswa']);
            Route::get('/admin/siswa/tambah', [\App\Http\Controllers\AdminController::class, 'formSiswa']);
            Route::post('/admin/siswa/simpan', [\App\Http\Controllers\AdminController::class, 'simpanSiswa']);
            Route::delete('/admin/siswa/hapus/{id}', [\App\Http\Controllers\AdminController::class, 'hapusSiswa']);
            Route::get('/admin/kelas', [\App\Http\Controllers\AdminController::class, 'dataKelas']);
            Route::get('/admin/siswa/edit/{id}', [\App\Http\Controllers\AdminController::class, 'editSiswa']);
            Route::put('/admin/siswa/update/{id}', [\App\Http\Controllers\AdminController::class, 'updateSiswa']);
            Route::get('/admin/kelas/edit/{id}', [\App\Http\Controllers\AdminController::class, 'editKelas']);
            Route::put('/admin/kelas/update/{id}', [\App\Http\Controllers\AdminController::class, 'updateKelas']);
            // RUTE MANAJEMEN ORANG TUA
            Route::get('/admin/ortu', [\App\Http\Controllers\AdminController::class, 'dataOrtu']);
            Route::post('/admin/ortu/simpan', [\App\Http\Controllers\AdminController::class, 'simpanOrtu']);
            Route::delete('/admin/ortu/hapus/{id}', [\App\Http\Controllers\AdminController::class, 'hapusOrtu']);
            Route::get('/admin/ortu/edit/{id}', [\App\Http\Controllers\AdminController::class, 'editOrtu']);
            Route::put('/admin/ortu/update/{id}', [\App\Http\Controllers\AdminController::class, 'updateOrtu']);
        });
    });

    // Grup Guru / Wali Kelas
    Route::middleware(['role:guru'])->group(function () {
        Route::get('/guru/dashboard', [\App\Http\Controllers\GuruController::class, 'dashboard']);

        // 💰 AMUNISI FORM TRANSAKSI
        Route::get('/guru/transaksi', [\App\Http\Controllers\GuruController::class, 'indexTransaksi']); // Halaman Cari Siswa untuk Transaksi
        Route::get('/guru/transaksi/{id}', [\App\Http\Controllers\GuruController::class, 'formTransaksi']); // Form Input Uangnya
        Route::post('/guru/transaksi', [\App\Http\Controllers\GuruController::class, 'simpanTransaksi']);

        // 👁️ AMUNISI DETAIL TABUNGAN
        Route::get('/guru/siswa', [\App\Http\Controllers\GuruController::class, 'indexSiswa']); // Halaman Cari Siswa untuk Detail (Group By/Filter Kelas)
        Route::get('/guru/siswa/{id}', [\App\Http\Controllers\GuruController::class, 'detailTabungan']); // Tampilan Tabel Mutasi Historisnya
        
        // RUTE DOWNLOAD EXCEL BARU
        Route::get('/guru/rekap/download', [\App\Http\Controllers\GuruController::class, 'downloadExcel']);
        
    });

    // Grup Orang Tua
    Route::middleware(['role:orang_tua'])->group(function () {
        Route::get('/orang-tua/dashboard', [\App\Http\Controllers\OrangTuaController::class, 'dashboard']);
       // AMUNISI UTAMA: Daftarkan rute download dengan parameter lengkap di sini
        Route::get('/orang-tua/rekap/download/{siswa_id}/{bulan}/{tahun}', [\App\Http\Controllers\OrangTuaController::class, 'downloadExcel']);
    });
