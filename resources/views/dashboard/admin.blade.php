@extends('dashboard.layout')

@section('title', 'Dashboard Admin Pusat')

@section('content')
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-8">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-slate-800 tracking-tight">Pusat Kendali Admin</h1>
            <p class="text-slate-500 text-sm mt-1 font-medium">Selamat datang kembali, {{ Auth::user()->nama }}! (Tata Usaha)</p>
        </div>
        <div class="self-start sm:self-auto bg-white px-3 py-1.5 rounded-xl shadow-sm border border-slate-200 text-xs font-bold text-slate-600 flex items-center space-x-1.5">
            <span class="w-2 h-2 rounded-full bg-blue-600 inline-block animate-pulse"></span>
            <span>Role: <span class="text-blue-700 uppercase">{{ Auth::user()->role }}</span></span>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 md:gap-6 mb-8">        
        
        <div class="bg-white p-5 md:p-6 rounded-2xl shadow-sm border border-slate-200/60 relative overflow-hidden group hover:shadow-md transition">
            <div class="absolute right-4 top-4 text-slate-100 text-5xl font-bold select-none group-hover:text-sky-50 transition"><i class="bi bi-person-badge"></i></div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider relative z-10">Total Ustadz dan Ustadzah</p>
            <p class="text-2xl md:text-3xl font-black text-slate-800 mt-1 relative z-10">{{ $totalGuru }}</p>
        </div>

        <div class="bg-white p-5 md:p-6 rounded-2xl shadow-sm border border-slate-200/60 relative overflow-hidden group hover:shadow-md transition">
            <div class="absolute right-4 top-4 text-slate-100 text-5xl font-bold select-none group-hover:text-blue-50 transition"><i class="bi bi-people"></i></div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider relative z-10">Total Seluruh Siswa</p>
            <p class="text-2xl md:text-3xl font-black text-slate-800 mt-1 relative z-10">{{ $totalSiswa }} <span class="text-sm font-semibold text-slate-500">Anak</span></p>
        </div>
        
        <div class="bg-white p-5 md:p-6 rounded-2xl shadow-sm border border-slate-200/60 relative overflow-hidden group hover:shadow-md transition">
            <div class="absolute right-4 top-4 text-slate-100 text-5xl font-bold select-none group-hover:text-amber-50 transition"><i class="bi bi-columns-gap"></i></div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider relative z-10">Jumlah Kelas</p>
            <p class="text-2xl md:text-3xl font-black text-slate-800 mt-1 relative z-10">{{ $totalKelas }} <span class="text-sm font-semibold text-slate-500">Kelas</span></p>
        </div>

        <div class="bg-white p-5 md:p-6 rounded-2xl shadow-sm border border-slate-200/60 relative overflow-hidden group hover:shadow-md transition border-l-4 border-l-sky-500">
            <div class="absolute right-4 top-4 text-slate-100 text-5xl font-bold select-none group-hover:text-sky-50 transition"><i class="bi bi-bank"></i></div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider relative z-10">Total Kas Sekolah</p>
            <p class="text-2xl md:text-3xl font-black text-sky-600 mt-1 relative z-10">Rp {{ number_format($totalKasNasional, 0, ',', '.') }}</p>
        </div>
        
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6 text-center text-slate-400 font-medium">
        <i class="bi bi-arrow-left-right text-2xl block mb-2 text-slate-300"></i>
        Siap dikoneksikan dengan CRUD Data Guru & Siswa, Bro!
    </div>
@endsection