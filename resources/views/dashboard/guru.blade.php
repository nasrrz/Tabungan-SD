@extends('dashboard.layout')

@section('title', 'Dashboard Guru')

@section('content')
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-8">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-slate-800 tracking-tight">Dashboard Wali Kelas</h1>
            <p class="text-slate-500 text-sm mt-1 font-medium">Wali: {{ Auth::user()->nama }} ({{ $kelas->nama_kelas ?? 'Belum ada kelas' }})</p>
        </div>
        <div class="self-start sm:self-auto bg-white px-3 py-1.5 rounded-xl shadow-sm border border-slate-200 text-xs font-bold text-slate-600 flex items-center space-x-1.5">
            <span class="w-2 h-2 rounded-full bg-emerald-500 inline-block animate-pulse"></span>
            <span>Role: <span class="text-blue-700 uppercase">{{ Auth::user()->role }}</span></span>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6 mb-8">        
        <div class="bg-white p-5 md:p-6 rounded-2xl shadow-sm border border-slate-200/60 relative overflow-hidden group hover:shadow-md transition">
            <div class="absolute right-4 top-4 text-slate-100 text-5xl font-bold select-none group-hover:text-blue-50 transition"><i class="bi bi-people"></i></div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider relative z-10">Total Siswa Binaan</p>
            <p class="text-2xl md:text-3xl font-black text-slate-800 mt-1 relative z-10">{{ $totalSiswa }} <span class="text-sm font-semibold text-slate-500">Siswa</span></p>
        </div>
        
        <div class="bg-white p-5 md:p-6 rounded-2xl shadow-sm border border-slate-200/60 relative overflow-hidden group hover:shadow-md transition border-l-4 border-l-emerald-500">
            <div class="absolute right-4 top-4 text-slate-100 text-5xl font-bold select-none group-hover:text-emerald-50 transition"><i class="bi bi-wallet2"></i></div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider relative z-10">Kas Tabungan Kelas</p>
            <p class="text-2xl md:text-3xl font-black text-emerald-600 mt-1 relative z-10">Rp {{ number_format($kasKelas, 0, ',', '.') }}</p>
        </div>
        
        <div class="bg-white p-5 md:p-6 rounded-2xl shadow-sm border border-slate-200/60 relative overflow-hidden group hover:shadow-md transition border-l-4 border-l-amber-500">
            <div class="absolute right-4 top-4 text-slate-100 text-5xl font-bold select-none group-hover:text-amber-50 transition"><i class="bi bi-arrow-left-right"></i></div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider relative z-10">Transaksi Hari Ini</p>
            <p class="text-2xl md:text-3xl font-black text-amber-600 mt-1 relative z-10">{{ $transaksiHariIni }} <span class="text-sm font-semibold text-slate-500">Ops</span></p>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">
        <div class="p-5 md:p-6 border-b border-slate-100 bg-slate-50/50">
            <h3 class="text-base md:text-lg font-bold text-blue-950">Daftar Siswa {{ $kelas->nama_kelas ?? '' }}</h3>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[500px]">
                <thead class="bg-slate-50/80 text-slate-500 text-xs font-bold uppercase tracking-wider border-b border-slate-200/60">
                    <tr>
                        <th class="p-4 pl-6 w-16">No</th>
                        <th class="p-4">Nama Siswa</th>
                        <th class="p-4">NISN</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-slate-700 divide-y divide-slate-100">
                    @forelse($daftarSiswa as $index => $siswa)
                    <tr class="hover:bg-slate-50/60 transition-all">
                        <td class="p-4 pl-6 font-semibold text-slate-400">{{ $index + 1 }}</td>
                        <td class="p-4 font-bold text-slate-800">{{ $siswa->nama }}</td>
                        <td class="p-4 font-mono text-slate-500 tracking-wide">{{ $siswa->nisn }}</td>
                        <td class="p-4">
                            <div class="flex justify-center gap-2">
                                <a href="/guru/transaksi/{{ $siswa->id }}" class="flex items-center gap-1.5 bg-blue-50 text-blue-700 px-3.5 py-2 rounded-xl text-xs font-bold hover:bg-blue-700 hover:text-white transition-all shadow-sm">
                                    <i class="bi bi-wallet2 text-sm"></i> Setor/Tarik
                                </a>
                                <a href="/guru/siswa/{{ $siswa->id }}" class="flex items-center gap-1.5 bg-slate-100 text-slate-600 px-3.5 py-2 rounded-xl text-xs font-bold hover:bg-slate-800 hover:text-white transition-all shadow-sm">
                                    <i class="bi bi-eye-fill text-sm"></i> Detail
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-8 text-center text-slate-400 font-medium">Belum ada data siswa di kelas ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection