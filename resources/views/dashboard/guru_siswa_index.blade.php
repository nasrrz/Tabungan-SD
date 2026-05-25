@extends('dashboard.layout')

@section('title', 'Detail Tabungan Kelas')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-black text-slate-800 tracking-tight">Monitoring Tabungan Kelas</h1>
        @if($kelas)
            <p class="text-slate-500 text-sm font-medium mt-1">
                Menampilkan seluruh data tabungan siswa binaan di 
                <span class="inline-flex items-center gap-1 bg-blue-50 text-blue-700 font-bold px-2.5 py-0.5 rounded-lg border border-blue-100 text-xs">
                    <i class="bi bi-door-open-fill"></i> {{ $kelas->nama_kelas }}
                </span>
            </p>
        @endif
    </div>

    @if(isset($error))
        <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-2xl text-sm font-semibold flex items-center gap-3 shadow-sm">
            <i class="bi bi-exclamation-triangle-fill text-xl text-rose-500"></i>
            <div>{{ $error }}</div>
        </div>
    @endif
    
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200/60 mb-6 flex flex-wrap items-center justify-between gap-4">
        <form action="/guru/rekap/download" method="GET" class="flex items-center gap-3 w-full sm:w-auto">
            <div>
                <select name="bulan" class="px-3 py-2 rounded-xl border border-slate-200 focus:outline-none text-sm font-semibold text-slate-700 bg-slate-50 cursor-pointer">
                    @for($m=1; $m<=12; $m++)
                        <option value="{{ sprintf('%02d', $m) }}" {{ request('bulan', date('m')) == sprintf('%02d', $m) ? 'selected' : '' }}>
                            {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                        </option>
                    @endfor
                </select>
            </div>
            <div>
                <select name="tahun" class="px-3 py-2 rounded-xl border border-slate-200 focus:outline-none text-sm font-semibold text-slate-700 bg-slate-50 cursor-pointer">
                    @for($y=date('Y')-2; $y<=date('Y'); $y++)
                        <option value="{{ $y }}" {{ request('tahun', date('Y')) == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>
            
            <button type="submit" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-xl text-sm font-bold shadow-sm shadow-emerald-600/10 transition cursor-pointer">
                <i class="bi bi-file-earmark-excel-fill"></i> Download Excel (.xlsx)
            </button>
        </form>
    </div>

    @if($kelas)
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
                            <a href="/guru/siswa/{{ $siswa->id }}" class="...">
                                <i class="bi bi-eye-fill"></i> Lihat Buku Tabungan
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-8 text-center text-slate-400 font-medium italic">
                            Belum ada data siswa yang dimasukkan ke dalam {{ $kelas->nama_kelas }} ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endif
@endsection