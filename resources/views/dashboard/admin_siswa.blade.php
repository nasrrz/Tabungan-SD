@extends('dashboard.layout')

@section('title', 'Manajemen Data Siswa')

@section('content')
    @if(session('success'))
    <div class="mb-5 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-lg text-sm font-medium flex items-center gap-2">
        <i class="bi bi-check-circle-fill text-base"></i> {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="mb-5 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm font-medium flex items-center gap-2">
        <i class="bi bi-exclamation-triangle-fill text-base"></i> {{ session('error') }}
    </div>
    @endif

    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-slate-800 tracking-tight">Master Data Siswa</h1>
            <p class="text-slate-500 text-sm mt-1">Data seluruh murid terdaftar di sekolah</p>
        </div>
        <a href="/admin/siswa/tambah" class="inline-flex items-center gap-2 bg-sky-600 hover:bg-sky-700 text-white px-5 py-2.5 rounded-lg text-sm font-semibold shadow-sm transition-colors">
            <i class="bi bi-plus-circle-fill"></i> Daftarkan Siswa Baru
        </a>
    </div>

    <!-- Import Massal -->
    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm mb-6">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-9 h-9 rounded-lg bg-sky-50 flex items-center justify-center text-sky-600">
                <i class="bi bi-lightning-charge-fill text-lg"></i>
            </div>
            <h3 class="text-sm font-semibold text-slate-700 uppercase tracking-wider">Import Data Siswa via Excel</h3>
        </div>
        <p class="text-xs text-slate-500 mb-4 pl-12">Pilih target kelas, lalu upload file Excel dengan kolom <span class="font-mono text-slate-700 font-bold">nisn</span> dan <span class="font-mono text-slate-700 font-bold">nama</span>.</p>
        
        <form action="/admin/siswa/import-massal" method="POST" enctype="multipart/form-data" class="space-y-4 pl-12">
            @csrf
            <div class="max-w-xs">
                <label class="block text-xs font-semibold text-slate-600 mb-1.5">Target Kelas Penerima</label>
                <select name="kelas_id" required class="w-full text-sm bg-white border border-slate-300 p-2.5 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 font-medium text-slate-700">
                    <option value="">Pilih Kelas</option>
                    @foreach(\DB::table('kelas')->get() as $k)
                        <option value="{{ $k->id }}">{{ $k->nama_kelas ?? $k->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <div class="flex-1 min-w-[280px]">
                    <input type="file" name="file_excel" required class="w-full text-sm text-slate-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-sky-50 file:text-sky-700 hover:file:bg-sky-100 border border-slate-300 p-1.5 rounded-lg bg-white cursor-pointer">
                </div>
                <button type="submit" class="inline-flex items-center gap-1.5 bg-sky-600 hover:bg-sky-700 text-white text-sm font-semibold px-5 py-2.5 rounded-lg shadow-sm transition-colors">
                    <i class="bi bi-cloud-arrow-up-fill"></i> Eksekusi Impor
                </button>
            </div>
        </form>
    </div>

    <!-- Filter Kelas -->
    <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <form action="/admin/siswa" method="GET" class="flex items-center gap-3 w-full sm:w-auto">
            <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider whitespace-nowrap">Group By Kelas</label>
            <select name="kelas_id" onchange="this.form.submit()" class="px-3 py-2 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 font-medium text-slate-700 text-sm bg-white cursor-pointer">
                <option value=""> Semua Kelas </option>
                @foreach($daftarKelas as $kls)
                    <option value="{{ $kls->id }}" {{ request('kelas_id') == $kls->id ? 'selected' : '' }}>
                        {{ $kls->nama_kelas }}
                    </option>
                @endforeach
            </select>
        </form>
        @if(request('kelas_id'))
            <div class="text-xs font-medium text-slate-500">
                Menampilkan: <span class="text-slate-600 font-bold">{{ $daftarSiswa->count() }} Murid</span>
            </div>
        @endif
    </div>

    <!-- Tabel Siswa -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[600px]">
                <thead class="bg-slate-50 text-slate-500 text-xs font-semibold uppercase tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="p-4 pl-6 w-16">No</th>
                        <th class="p-4">Nama Siswa</th>
                        <th class="p-4">NISN</th>
                        <th class="p-4">Kelas</th>
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
                            <span class="inline-block bg-sky-50 text-slate-700 font-medium px-2.5 py-1 rounded-md text-xs">
                                {{ $siswa->nama_kelas ?? 'Belum Diplot' }}
                            </span>
                        </td>
                        <td class="p-4">
                            <div class="flex justify-center gap-2">
                                <a href="/admin/siswa/edit/{{ $siswa->id }}" class="text-amber-600 bg-amber-50 hover:bg-amber-500 hover:text-white p-2 rounded-lg transition-all shadow-sm" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="/admin/siswa/hapus/{{ $siswa->id }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus siswa ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose-600 bg-rose-50 hover:bg-rose-500 hover:text-white p-2 rounded-lg transition-all shadow-sm cursor-pointer" title="Hapus">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-slate-400 font-medium">Belum ada data murid terdaftar untuk filter ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection