@extends('dashboard.layout')

@section('title', 'Detail Tabungan Siswa')

@section('content')
    <div class="mb-6">
        <a href="/guru/dashboard" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-700 hover:text-slate-800 bg-white px-4 py-2 rounded-lg border border-slate-200 shadow-sm transition-colors">
            <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>

    {{-- Info Siswa & Saldo --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
        <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm md:col-span-2 flex flex-col justify-center">
            @php
                $siswaSingle = is_iterable($siswa) ? collect($siswa)->first() : $siswa;
            @endphp

            <h2 class="text-2xl font-bold text-slate-800 tracking-tight">{{ data_get($siswaSingle, 'nama_siswa') ?? data_get($siswaSingle, 'nama') }}</h2>
            <p class="text-slate-500 mt-1.5 text-sm font-medium">
                NISN: <span class="font-mono font-semibold text-slate-700">{{ data_get($siswaSingle, 'nisn') }}</span>
                <span class="mx-2 text-slate-300">|</span>
                Kelas: <span class="font-semibold text-slate-700">{{ data_get($siswaSingle, 'nama_kelas') }}</span>
            </p>
        </div>
        <div class="bg-emerald-500 p-6 rounded-xl shadow-sm text-white flex flex-col justify-center">
            <p class="text-xs font-semibold text-emerald-100 uppercase tracking-wider mb-1">Saldo Tabungan</p>
            <p class="text-2xl md:text-3xl font-bold">Rp {{ number_format($saldo, 0, ',', '.') }}</p>
        </div>
    </div>

    {{-- Riwayat Transaksi --}}
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-5 md:p-6 border-b border-slate-100 bg-slate-50">
            <h3 class="text-base font-semibold text-slate-800">Riwayat Transaksi</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[600px]">
                <thead class="bg-slate-50 text-slate-500 text-xs font-semibold uppercase tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="p-4 pl-6">Tanggal</th>
                        <th class="p-4">Jenis</th>
                        <th class="p-4">Nominal</th>
                        <th class="p-4">Keterangan</th>
                        <th class="p-4">Petugas (Guru)</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-slate-700 divide-y divide-slate-100">
                    @forelse($riwayat as $trx)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="p-4 pl-6 text-slate-500 font-medium text-xs">
                            {{ date('d M Y | H:i', strtotime(data_get($trx, 'created_at'))) }} WIB
                        </td>
                        <td class="p-4">
                            @if(data_get($trx, 'jenis') == 'setor')
                                <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-700 px-2.5 py-1 rounded-md text-xs font-medium">
                                    <i class="bi bi-box-arrow-in-down text-sm"></i> Setor
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 bg-rose-50 text-rose-700 px-2.5 py-1 rounded-md text-xs font-medium">
                                    <i class="bi bi-box-arrow-up text-sm"></i> Tarik
                                </span>
                            @endif
                        </td>
                        <td class="p-4 font-semibold {{ data_get($trx, 'jenis') == 'setor' ? 'text-emerald-600' : 'text-rose-600' }}">
                            {{ data_get($trx, 'jenis') == 'setor' ? '+' : '-' }} Rp {{ number_format(data_get($trx, 'jumlah'), 0, ',', '.') }}
                        </td>
                        <td class="p-4 text-slate-500 italic">{{ data_get($trx, 'keterangan') ?? '-' }}</td>
                        <td class="p-4 text-slate-600 font-medium">{{ data_get($trx, 'nama_guru') ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-slate-400 font-medium">Belum ada riwayat transaksi untuk siswa ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection