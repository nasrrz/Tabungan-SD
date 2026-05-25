@extends('dashboard.layout')

@section('title', 'Pilih Siswa - Transaksi')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-black text-slate-800 tracking-tight">Pencatatan Tabungan</h1>
        <p class="text-slate-500 text-sm font-medium">Silakan pilih atau cari nama anak binaan di <span class="text-blue-700 font-bold">Kelas {{ $kelas->nama_kelas ?? '' }}</span></p>
    </div>

    <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-200/60 mb-6">
        <form action="/guru/transaksi" method="GET" class="flex gap-2 w-full max-w-md">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik nama siswa..." class="w-full px-4 py-2 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-sky-500/20 text-sm font-medium">
            <button type="submit" class="bg-sky-500 hover:bg-sky-600 text-white px-4 py-2 rounded-xl text-sm font-bold shadow-sm transition cursor-pointer">Cari</button>
        </form>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 text-slate-500 text-xs font-bold uppercase tracking-wider border-b border-slate-200/60">
                    <tr>
                        <th class="p-4 pl-6 w-16">No</th>
                        <th class="p-4">Nama Siswa</th>
                        <th class="p-4">NISN</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-slate-100">
                    @forelse($daftarSiswa as $index => $siswa)
                    <tr class="hover:bg-slate-50/60 transition">
                        <td class="p-4 pl-6 font-semibold text-slate-400">{{ $index + 1 }}</td>
                        <td class="p-4 font-bold text-slate-800">{{ $siswa->nama }}</td>
                        <td class="p-4 font-mono text-slate-500 text-xs">{{ $siswa->nisn }}</td>
                        <td class="p-4 text-center">
                            <a href="/guru/transaksi/{{ $siswa->id }}" class="inline-flex items-center gap-1.5 bg-sky-500 text-white px-3.5 py-1.5 rounded-xl text-xs font-bold hover:bg-sky-600 transition shadow-sm">
                                <i class="bi bi-wallet2"></i> Pilih & Catat Uang
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-8 text-center text-slate-400 font-medium">Nama siswa tidak ditemukan di kelas ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection