@extends('dashboard.layout')

@section('title', 'Manajemen Data Orang Tua')

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

    <div class="mb-6">
        <h1 class="text-2xl md:text-3xl font-bold text-slate-800 tracking-tight">Data Wali / Orang Tua Murid</h1>
        <p class="text-slate-500 text-sm mt-1">Kelola username login orang tua untuk memonitoring tabungan anak</p>
    </div>

    <!-- Form Tambah Orang Tua -->
    <div class="bg-white p-5 md:p-6 rounded-xl border border-slate-200 shadow-sm mb-6">
        <h3 class="text-sm font-semibold text-slate-700 mb-4 flex items-center gap-2">
            <span class="w-8 h-8 rounded-lg bg-sky-50 flex items-center justify-center text-sky-600"><i class="bi bi-person-plus-fill text-lg"></i></span>
            Buat Akses Akun Orang Tua
        </h3>
        
        <form action="/admin/ortu/simpan" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1.5">Nama Lengkap Orang Tua</label>
                <input type="text" name="nama" required placeholder="Nama orang tua" class="w-full text-sm bg-white border border-slate-300 p-2.5 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 font-medium text-slate-700">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1.5">Username Login</label>
                <input type="text" name="username" required placeholder="Username unik" class="w-full text-sm bg-white border border-slate-300 p-2.5 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 font-medium text-slate-700">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1.5">Orang Tua dari</label>
                <select name="siswa_id" required class="w-full text-sm bg-white border border-slate-300 p-2.5 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 font-medium text-slate-700 cursor-pointer">
                    <option value="">Pilih Nama Siswa</option>
                    @foreach($daftarSiswa as $s)
                        <option value="{{ $s->id }}">{{ $s->nama }} (NISN: {{ $s->nisn }})</option>
                    @endforeach
                </select>
            </div>
            <div class="md:col-span-3 flex justify-end mt-2">
                <button type="submit" class="inline-flex items-center gap-1.5 bg-sky-500 hover:bg-sky-600 text-white text-sm font-semibold px-5 py-2.5 rounded-lg shadow-sm transition-colors">
                    <i class="bi bi-shield-lock-fill"></i> Daftarkan Akun
                </button>
            </div>
        </form>
    </div>

    <!-- Tabel Daftar Orang Tua -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[600px]">
                <thead class="bg-slate-50 text-slate-500 text-xs font-semibold uppercase tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="p-4 pl-6 w-16">No</th>
                        <th class="p-4">Nama Orang Tua</th>
                        <th class="p-4">Username Login</th>
                        <th class="p-4">Anak Binaan</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-slate-700 divide-y divide-slate-100">
                    @forelse($daftarOrtu as $index => $ortu)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="p-4 pl-6 font-medium text-slate-500">{{ $index + 1 }}</td>
                        <td class="p-4 font-semibold text-slate-800">{{ $ortu->nama }}</td>
                        <td class="p-4 font-mono text-slate-600 font-medium">{{ $ortu->username }}</td>
                        <td class="p-4">
                            @php
                                $anak = DB::table('siswa')->where('ortu_id', $ortu->id)->first();
                            @endphp
                            @if($anak)
                                <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-700 font-medium px-2.5 py-1 rounded-md text-xs">
                                    <i class="bi bi-person-fill"></i> {{ $anak->nama }}
                                </span>
                            @else
                                <span class="inline-block bg-slate-100 text-slate-500 font-medium px-2.5 py-1 rounded-md text-xs">Belum di-plot</span>
                            @endif
                        </td>
                        <td class="p-4">
                            <div class="flex justify-center gap-2">
                                <a href="/admin/ortu/edit/{{ $ortu->id }}" class="text-amber-600 bg-amber-50 hover:bg-amber-500 hover:text-white p-2 rounded-lg transition-colors shadow-sm" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="/admin/ortu/hapus/{{ $ortu->id }}" method="POST" onsubmit="return confirm('Hapus akses login orang tua ini?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose-600 bg-rose-50 hover:bg-rose-500 hover:text-white p-2 rounded-lg transition-colors shadow-sm cursor-pointer" title="Hapus">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-slate-400 font-medium">Belum ada akun akses orang tua murid yang terdaftar.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection