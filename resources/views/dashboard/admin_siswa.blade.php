@extends('dashboard.layout')

@section('title', 'Manajemen Data Siswa')

@section('content')
    @if(session('success'))
    <div class="mb-4 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-sm font-semibold flex items-center gap-2 shadow-sm animate-fade-in">
        <i class="bi bi-check-circle-fill text-base"></i> {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="mb-4 p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl text-sm font-semibold flex items-center gap-2 shadow-sm">
        <i class="bi bi-exclamation-triangle-fill text-base"></i> {{ session('error') }}
    </div>
    @endif

    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-slate-800 tracking-tight">Master Data Siswa</h1>
            <p class="text-slate-500 text-sm mt-1 font-medium">Data seluruh murid terdaftar di sekolah</p>
        </div>
        <a href="/admin/siswa/tambah" class="bg-sky-500 hover:bg-sky-600 text-white px-4 py-2.5 rounded-xl text-sm font-bold shadow-md shadow-sky-500/10 transition-all flex items-center gap-2 cursor-pointer w-fit">
            <i class="bi bi-plus-circle-fill"></i> Daftarkan Siswa Baru
        </a>
    </div>

    <div class="bg-white p-5 md:p-6 rounded-2xl shadow-sm border border-slate-200/80 mb-6">
        <div class="flex items-center gap-2 mb-3">
            <div class="w-7 h-7 bg-purple-50 text-purple-600 rounded-lg flex items-center justify-center text-xs font-bold">
                <i class="bi bi-lightning-charge-fill"></i>
            </div>
            <h3 class="text-sm font-bold text-slate-700 uppercase tracking-wider">Import Massal via Excel</h3>
        </div>
        <p class="text-xs text-slate-400 mb-4">Pilih target kelas terlebih dahulu, kemudian upload file Excel yang berisi kolom <span class="font-mono bg-slate-100 text-rose-600 px-1 rounded font-bold">nisn</span> dan <span class="font-mono bg-slate-100 text-rose-600 px-1 rounded font-bold">nama</span>.</p>
        
        <form action="/admin/siswa/import-massal" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            
            <div class="max-w-xs">
                <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Target Kelas Penerima:</label>
                <select name="kelas_id" required class="w-full text-sm bg-slate-50 border border-slate-200 p-2.5 rounded-xl focus:outline-none focus:border-purple-500 font-semibold text-slate-700 cursor-pointer">
                    <option value="">Pilih Kelas</option>
                    @foreach(\DB::table('kelas')->get() as $k)
                        <option value="{{ $k->id }}">{{ $k->nama_kelas ?? $k->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <div class="flex-1 min-w-[280px]">
                    <input type="file" name="file_excel" required class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100 border border-slate-200 p-1.5 rounded-xl bg-slate-50 cursor-pointer">
                </div>
                <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white text-xs font-bold px-5 py-3 rounded-xl shadow-md shadow-purple-600/10 transition-all flex items-center gap-1 cursor-pointer">
                    <i class="bi bi-cloud-arrow-up-fill"></i> Eksekusi Impor
                </button>
            </div>
        </form> </div>

    <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-200/60 mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <form action="/admin/siswa" method="GET" class="flex items-center gap-2 w-full sm:w-auto">
            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider whitespace-nowrap">Group By Kelas:</label>
            <select name="kelas_id" onchange="this.form.submit()" class="px-3 py-1.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-sky-500/20 font-semibold text-slate-700 text-sm cursor-pointer bg-slate-50">
                <option value=""> Semua Kelas </option>
                @foreach($daftarKelas as $kls)
                    <option value="{{ $kls->id }}" {{ request('kelas_id') == $kls->id ? 'selected' : '' }}>
                        {{ $kls->nama_kelas }}
                    </option>
                @endforeach
            </select>
        </form>
        @if(request('kelas_id'))
            <div class="text-xs font-bold text-slate-400">
                Menampilkan: <span class="text-sky-600">{{ $daftarSiswa->count() }} Murid</span>
            </div>
        @endif
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[600px]">
                <thead class="bg-slate-50/80 text-slate-500 text-xs font-bold uppercase tracking-wider border-b border-slate-200/60">
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
                    <tr class="hover:bg-slate-50/60 transition-all">
                        <td class="p-4 pl-6 font-semibold text-slate-400">{{ $index + 1 }}</td>
                        <td class="p-4 font-bold text-slate-800">{{ $siswa->nama }}</td>
                        <td class="p-4 font-mono text-slate-500 tracking-wide">{{ $siswa->nisn }}</td>
                        <td class="p-4">
                            <span class="bg-blue-50 text-blue-700 font-bold px-2.5 py-1 rounded-lg text-xs">
                                {{ $siswa->nama_kelas ?? 'Belum Diplot' }}
                            </span>
                        </td>
                        <td class="p-4">
                            <div class="flex justify-center gap-2">
                                <a href="/admin/siswa/edit/{{ $siswa->id }}" class="text-amber-600 bg-amber-50 hover:bg-amber-500 hover:text-white p-2 rounded-xl transition-all shadow-sm">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                
                                <form action="/admin/siswa/hapus/{{ $siswa->id }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus siswa ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose-600 bg-rose-50 hover:bg-rose-500 hover:text-white p-2 rounded-xl transition-all shadow-sm cursor-pointer">
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