@extends('dashboard.layout')

@section('title', 'Manajemen Data Orang Tua')

@section('content')
    @if(session('success'))
    <div class="mb-4 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-sm font-semibold flex items-center gap-2 shadow-sm">
        <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="mb-4 p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl text-sm font-semibold flex items-center gap-2 shadow-sm">
        <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
    </div>
    @endif

    <div class="mb-6">
        <h1 class="text-2xl md:text-3xl font-bold text-slate-800 tracking-tight">Data Wali / Orang Tua Murid</h1>
        <p class="text-slate-500 text-sm mt-1 font-medium">Kelola username login orang tua untuk memonitoring tabungan anak</p>
    </div>

    <div class="bg-white p-5 md:p-6 rounded-2xl shadow-sm border border-slate-200/80 mb-6">
        <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-4"><i class="bi bi-person-plus-fill text-sky-500"></i> Buat Akses Akun Orang Tua</h3>
        
        <form action="/admin/ortu/simpan" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Nama Lengkap Orang Tua:</label>
                <input type="text" name="nama" required placeholder="" class="w-full text-sm bg-slate-50 border border-slate-200 p-2.5 rounded-xl focus:outline-none focus:border-sky-500 font-medium text-slate-700">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Username Login:</label>
                <input type="text" name="username" required placeholder="" class="w-full text-sm bg-slate-50 border border-slate-200 p-2.5 rounded-xl focus:outline-none focus:border-sky-500 font-medium text-slate-700">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Orang Tua dari:</label>
                <select name="siswa_id" required class="w-full text-sm bg-slate-50 border border-slate-200 p-2.5 rounded-xl focus:outline-none focus:border-sky-500 font-semibold text-slate-700 cursor-pointer">
                    <option value="">Pilih Nama Siswa</option>
                    @foreach($daftarSiswa as $s)
                        <option value="{{ $s->id }}">{{ $s->nama }} (NISN: {{ $s->nisn }})</option>
                    @endforeach
                </select>
            </div>
            <div class="md:col-span-3 flex justify-end mt-2">
                <button type="submit" class="bg-sky-500 hover:bg-sky-600 text-white text-xs font-bold px-5 py-3 rounded-xl shadow-md transition-all flex items-center gap-1 cursor-pointer">
                    <i class="bi bi-shield-lock-fill"></i> Daftarkan Akun 
                </button>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[600px]">
                <thead class="bg-slate-50/80 text-slate-500 text-xs font-bold uppercase tracking-wider border-b border-slate-200/60">
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
                    <tr class="hover:bg-slate-50/60 transition-all">
                        <td class="p-4 pl-6 font-semibold text-slate-400">{{ $index + 1 }}</td>
                        <td class="p-4 font-bold text-slate-800">{{ $ortu->nama }}</td>
                        <td class="p-4 font-mono text-slate-600 font-bold bg-slate-50/50 rounded px-1.5 py-0.5 text-xs w-fit">{{ $ortu->username }}</td>
                        <td class="p-4">
                            @php
                                $anak = DB::table('siswa')->where('ortu_id', $ortu->id)->first();
                            @endphp
                            @if($anak)
                                <span class="bg-emerald-50 text-emerald-700 font-bold px-2.5 py-1 rounded-lg text-xs flex items-center gap-1 w-fit">
                                    <i class="bi bi-person-fill"></i> {{ $anak->nama }}
                                </span>
                            @else
                                <span class="bg-slate-100 text-slate-400 font-medium px-2.5 py-1 rounded-lg text-xs">Belum di-plot</span>
                            @endif
                        </td>
                        <td class="p-4">
                            <div class="flex justify-center gap-2">
                                <a href="/admin/ortu/edit/{{ $ortu->id }}" class="text-amber-600 bg-amber-50 hover:bg-amber-500 hover:text-white p-2 rounded-xl transition shadow-sm">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="/admin/ortu/hapus/{{ $ortu->id }}" method="POST" onsubmit="return confirm('Hapus akses login orang tua ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose-600 bg-rose-50 hover:bg-rose-500 hover:text-white p-2 rounded-xl transition shadow-sm cursor-pointer">
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