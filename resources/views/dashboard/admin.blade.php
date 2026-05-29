@extends('dashboard.layout')

@section('title', 'Dashboard Admin Pusat')

@section('content')
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-8">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-slate-800 tracking-tight">Pusat Kendali Admin</h1>
            <p class="text-slate-500 text-sm mt-1 font-medium">Selamat datang kembali, {{ Auth::user()->nama }}! (Tata Usaha)</p>
        </div>
        <div class="self-start sm:self-auto inline-flex items-center gap-2 bg-white px-4 py-2 rounded-lg shadow-sm border border-slate-200 text-sm font-semibold text-slate-600">
            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
            <span class="uppercase tracking-wide text-xs">{{ Auth::user()->role }}</span>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
        <!-- Total Guru -->
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-lg bg-sky-50 flex items-center justify-center text-sky-600">
                    <i class="bi bi-person-badge text-xl"></i>
                </div>
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Ustadz / Ustadzah</span>
            </div>
            <p class="text-2xl font-bold text-slate-800">{{ $totalGuru }}</p>
        </div>

        <!-- Total Siswa -->
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600">
                    <i class="bi bi-people text-xl"></i>
                </div>
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Seluruh Siswa</span>
            </div>
            <p class="text-2xl font-bold text-slate-800">{{ $totalSiswa }} <span class="text-sm font-medium text-slate-500">Anak</span></p>
        </div>

        <!-- Jumlah Kelas -->
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-lg bg-amber-50 flex items-center justify-center text-amber-600">
                    <i class="bi bi-columns-gap text-xl"></i>
                </div>
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Jumlah Kelas</span>
            </div>
            <p class="text-2xl font-bold text-slate-800">{{ $totalKelas }} <span class="text-sm font-medium text-slate-500">Kelas</span></p>
        </div>

        <!-- Total Kas -->
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-lg bg-emerald-50 flex items-center justify-center text-emerald-600">
                    <i class="bi bi-bank text-xl"></i>
                </div>
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Kas Sekolah</span>
            </div>
            <p class="text-2xl font-bold text-emerald-600">Rp {{ number_format($totalKasNasional, 0, ',', '.') }}</p>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-dashed border-slate-300 p-8 text-center text-slate-500">
        <div class="w-12 h-12 mx-auto mb-3 rounded-full bg-slate-100 flex items-center justify-center text-slate-400">
            <i class="bi bi-grid-3x3-gap text-xl"></i>
        </div>
        <p class="font-medium">Modul Manajemen Data</p>
        <p class="text-sm text-slate-400 mt-1">CRUD Guru & Siswa akan tersedia di panel ini.</p>
    </div>
@endsection