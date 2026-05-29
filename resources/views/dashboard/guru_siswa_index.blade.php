@extends('dashboard.layout')

@section('title', 'Detail Tabungan Kelas')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl md:text-3xl font-bold text-slate-800 tracking-tight">Monitoring Tabungan Kelas</h1>
        @if($kelas)
            <p class="text-slate-500 text-sm mt-1">
                Menampilkan seluruh data tabungan siswa binaan di 
                <span class="inline-flex items-center gap-1 bg-sky-50 text-sky-700 font-medium px-2.5 py-0.5 rounded-md text-xs">
                    <i class="bi bi-door-open-fill"></i> {{ $kelas->nama_kelas }}
                </span>
            </p>
        @endif
    </div>

    @if(isset($error))
        <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm font-medium flex items-center gap-3">
            <i class="bi bi-exclamation-triangle-fill text-base"></i>
            <span>{{ $error }}</span>
        </div>
    @endif

    {{-- Filter & Download --}}
    <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm mb-6 flex flex-wrap items-center justify-between gap-4">
        <form action="/guru/rekap/download" method="GET" class="flex items-center gap-3 w-full sm:w-auto">
            <select name="bulan" class="px-3 py-2 rounded-lg border border-slate-300 bg-white text-sm font-medium text-slate-700 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 cursor-pointer">
                @for($m=1; $m<=12; $m++)
                    <option value="{{ sprintf('%02d', $m) }}" {{ request('bulan', date('m')) == sprintf('%02d', $m) ? 'selected' : '' }}>
                        {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                    </option>
                @endfor
            </select>
            <select name="tahun" class="px-3 py-2 rounded-lg border border-slate-300 bg-white text-sm font-medium text-slate-700 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 cursor-pointer">
                @for($y=date('Y')-2; $y<=date('Y'); $y++)
                    <option value="{{ $y }}" {{ request('tahun', date('Y')) == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>
            <button type="submit" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg text-sm font-semibold shadow-sm transition-colors">
                <i class="bi bi-file-earmark-excel-fill"></i> Download Excel (.xlsx)
            </button>
        </form>
    </div>

    {{-- Tabel Siswa --}}
    @if($kelas)
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
                            <a href="/guru/siswa/{{ $siswa->id }}" class="inline-flex items-center gap-1.5 bg-sky-50 text-sky-700 hover:bg-sky-500 hover:text-white px-3 py-1.5 rounded-lg text-xs font-medium transition-colors">
                                <i class="bi bi-eye-fill"></i> Lihat Buku Tabungan
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-8 text-center text-slate-400 font-medium">
                            Belum ada data siswa di dalam kelas {{ $kelas->nama_kelas }}.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endif
@endsection