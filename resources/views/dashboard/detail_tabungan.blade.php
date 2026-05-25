@extends('dashboard.layout')

@section('title', 'Detail Tabungan Siswa')

@section('content')
    <div class="mb-6">
        <a href="/guru/dashboard" class="inline-flex items-center gap-2 text-sm font-bold text-blue-700 hover:text-blue-800 transition bg-white px-4 py-2 rounded-xl border border-slate-200 shadow-sm">
            <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6 mb-8">
        <div class="bg-white p-5 md:p-6 rounded-2xl shadow-sm border border-slate-200 md:col-span-2 flex flex-col justify-center">
            @php
                // FORCE FIX (TKJ BARRIER): Paksa konversi ke objek tunggal jika data yang dikirim bertipe collection
                $siswaSingle = is_iterable($siswa) ? collect($siswa)->first() : $siswa;
            @endphp

            <h2 class="text-2xl font-black text-slate-800">{{ data_get($siswaSingle, 'nama_siswa') ?? data_get($siswaSingle, 'nama') }}</h2>
            <p class="text-slate-500 mt-1 font-medium text-sm">
                NISN: <span class="font-mono font-bold text-slate-700">{{ data_get($siswaSingle, 'nisn') }}</span> | 
                Kelas: <span class="font-bold text-blue-700">{{ data_get($siswaSingle, 'nama_kelas') }}</span>
            </p>
        </div>
        <div class="bg-sky-500 p-6 rounded-2xl shadow-lg shadow-sky-500/20 text-white flex flex-col justify-center relative overflow-hidden group">
            <div class="absolute right-4 top-4 text-sky-400/30 text-5xl font-bold select-none"><i class="bi bi-cash-coin"></i></div>
            <p class="text-xs font-bold text-sky-100 uppercase tracking-wider relative z-10">Saldo Tabungan</p>
            <p class="text-2xl md:text-3xl font-black mt-1 relative z-10">Rp {{ number_format($saldo, 0, ',', '.') }}</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="p-5 md:p-6 border-b border-slate-100 bg-slate-50/50">
            <h3 class="text-base md:text-lg font-bold text-blue-950">Riwayat Transaksi</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[600px]">
                <thead class="bg-slate-50/80 text-slate-500 text-xs font-bold uppercase tracking-wider border-b border-slate-200/60">
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
                    <tr class="hover:bg-slate-50/60 transition">
                        <td class="p-4 pl-6 text-slate-500 font-medium text-xs">
                            {{ date('d M Y | H:i', strtotime(data_get($trx, 'created_at'))) }} WIB
                        </td>
                        <td class="p-4">
                            @if(data_get($trx, 'jenis') == 'setor')
                                <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-700 px-2.5 py-1 rounded-xl text-xs font-bold">
                                    <i class="bi bi-box-arrow-in-down text-sm"></i> Setor
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 bg-rose-50 text-rose-700 px-2.5 py-1 rounded-xl text-xs font-bold">
                                    <i class="bi bi-box-arrow-up text-sm"></i> Tarik
                                </span>
                            @endif
                        </td>
                        <td class="p-4 font-black {{ data_get($trx, 'jenis') == 'setor' ? 'text-emerald-600' : 'text-rose-600' }}">
                            {{ data_get($trx, 'jenis') == 'setor' ? '+' : '-' }} Rp {{ number_format(data_get($trx, 'jumlah'), 0, ',', '.') }}
                        </td>
                        <td class="p-4 text-slate-500 italic font-medium">{{ data_get($trx, 'keterangan') ?? '-' }}</td>
                        <td class="p-4 text-slate-600 font-bold">{{ data_get($trx, 'nama_guru') ?? '-' }}</td>
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