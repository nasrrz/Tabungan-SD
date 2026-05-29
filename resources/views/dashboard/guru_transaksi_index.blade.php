@extends('dashboard.layout')

@section('title', 'Pilih Siswa - Transaksi')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl md:text-3xl font-bold text-slate-800 tracking-tight">Pencatatan Tabungan</h1>
        <p class="text-slate-500 text-sm mt-1">
            Silakan pilih atau cari nama anak binaan di 
            <span class="inline-flex items-center gap-1 bg-sky-50 text-sky-700 font-medium px-2.5 py-0.5 rounded-md text-xs">
                <i class="bi bi-door-open-fill"></i>{{ $kelas->nama_kelas ?? '' }}
            </span>
        </p>
    </div>

    {{-- Form Pencarian --}}
    <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm mb-6">
        <form action="/guru/transaksi" method="GET" class="flex gap-2 w-full max-w-md">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Ketik nama siswa..."
                class="w-full px-4 py-2 rounded-lg border border-slate-300 bg-white text-slate-800 placeholder:text-slate-400
                       focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500
                       text-sm font-medium transition-colors"
            >
            <button type="submit" class="bg-sky-500 hover:bg-sky-600 text-white px-4 py-2 rounded-lg text-sm font-semibold shadow-sm transition-colors">
                Cari
            </button>
        </form>
    </div>

    {{-- Tabel Siswa --}}
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 text-slate-500 text-xs font-semibold uppercase tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="p-4 pl-6 w-16">No</th>
                        <th class="p-4">Nama Siswa</th>
                        <th class="p-4">NISN</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-slate-100">
                    @forelse($daftarSiswa as $index => $siswa)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="p-4 pl-6 font-medium text-slate-500">{{ $index + 1 }}</td>
                        <td class="p-4 font-semibold text-slate-800">{{ $siswa->nama }}</td>
                        <td class="p-4 font-mono text-slate-600 text-xs">{{ $siswa->nisn }}</td>
                        <td class="p-4 text-center">
                            <a href="/guru/transaksi/{{ $siswa->id }}" class="inline-flex items-center gap-1.5 bg-sky-50 text-sky-700 hover:bg-sky-500 hover:text-white px-3 py-1.5 rounded-lg text-xs font-medium transition-colors">
                                <i class="bi bi-wallet2"></i> Pilih & Catat Uang
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-8 text-center text-slate-400 font-medium">
                            Nama siswa tidak ditemukan di kelas ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection