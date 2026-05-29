@extends('dashboard.layout')

@section('title', 'Dashboard Guru')

@section('content')
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-8">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-slate-800 tracking-tight">Dashboard Wali Kelas</h1>
            <p class="text-slate-500 text-sm mt-1 font-medium">Wali: {{ Auth::user()->nama }} ({{ $kelas->nama_kelas ?? 'Belum ada kelas' }})</p>
        </div>
        <div class="self-start sm:self-auto inline-flex items-center gap-2 bg-white px-4 py-2 rounded-lg shadow-sm border border-slate-200 text-sm font-semibold text-slate-600">
            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
            <span class="uppercase tracking-wide text-xs">{{ Auth::user()->role }}</span>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 mb-8">
        <!-- Total Siswa Binaan -->
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600">
                    <i class="bi bi-people text-xl"></i>
                </div>
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Siswa Binaan</span>
            </div>
            <p class="text-2xl font-bold text-slate-800">{{ $totalSiswa }} <span class="text-sm font-medium text-slate-500">Siswa</span></p>
        </div>

        <!-- Kas Tabungan Kelas -->
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-lg bg-emerald-50 flex items-center justify-center text-emerald-600">
                    <i class="bi bi-wallet2 text-xl"></i>
                </div>
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Kas Tabungan Kelas</span>
            </div>
            <p class="text-2xl font-bold text-emerald-600">Rp {{ number_format($kasKelas, 0, ',', '.') }}</p>
        </div>

        <!-- Transaksi Hari Ini -->
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-lg bg-amber-50 flex items-center justify-center text-amber-600">
                    <i class="bi bi-arrow-left-right text-xl"></i>
                </div>
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Transaksi Hari Ini</span>
            </div>
            <p class="text-2xl font-bold text-amber-600">{{ $transaksiHariIni }} <span class="text-sm font-medium text-slate-500">Transaksi</span></p>
        </div>
    </div>

    <!-- Daftar Siswa -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-5 md:p-6 border-b border-slate-100 bg-slate-50">
            <h3 class="text-base font-semibold text-slate-800">Daftar Siswa {{ $kelas->nama_kelas ?? '' }}</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[500px]">
                <thead class="bg-slate-50 text-slate-500 text-xs font-semibold uppercase tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="p-4 pl-6 w-16">No</th>
                        <th class="p-4">Nama Siswa</th>
                        <th class="p-4">NISN</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-slate-700 divide-y divide-slate-100">
                    @forelse($daftarSiswa as $index => $siswa)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="p-4 pl-6 font-medium text-slate-500">{{ $index + 1 }}</td>
                        <td class="p-4 font-semibold text-slate-800">{{ $siswa->nama }}</td>
                        <td class="p-4 font-mono text-slate-600 tracking-wide">{{ $siswa->nisn }}</td>
                        <td class="p-4">
                            <div class="flex justify-center gap-2">
                                <a href="/guru/transaksi/{{ $siswa->id }}" class="inline-flex items-center gap-1.5 bg-sky-50 text-sky-700 hover:bg-sky-500 hover:text-white px-3 py-1.5 rounded-lg text-xs font-medium transition-colors">
                                    <i class="bi bi-wallet2 text-sm"></i> Setor/Tarik
                                </a>
                                <a href="/guru/siswa/{{ $siswa->id }}" class="inline-flex items-center gap-1.5 bg-slate-100 text-slate-600 hover:bg-slate-200 px-3 py-1.5 rounded-lg text-xs font-medium transition-colors">
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