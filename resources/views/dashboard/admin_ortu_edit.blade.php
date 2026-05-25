@extends('dashboard.layout')

@section('title', 'Edit Data Orang Tua')

@section('content')
<div class="mb-6">
    <a href="/admin/ortu" class="text-sm font-bold text-slate-400 hover:text-slate-600 transition flex items-center gap-2">
        <i class="bi bi-arrow-left"></i> Kembali ke Daftar
    </a>
</div>

<div class="max-w-2xl bg-white p-6 md:p-8 rounded-3xl shadow-sm border border-slate-200">
    <h2 class="text-2xl font-black text-slate-800 mb-6">Edit Akses Orang Tua</h2>

    <form action="/admin/ortu/update/{{ $ortu->id }}" method="POST" class="space-y-5">
        @csrf
        <div>
            <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Nama Lengkap Orang Tua</label>
            <input type="text" name="nama" value="{{ $ortu->name }}" required class="w-full bg-slate-50 border border-slate-200 p-3 rounded-xl focus:outline-none focus:border-sky-500 font-bold text-slate-700">
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Username Login</label>
            <input type="text" name="username" value="{{ $ortu->username }}" required class="w-full bg-slate-50 border border-slate-200 p-3 rounded-xl focus:outline-none focus:border-sky-500 font-bold text-slate-700">
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Hubungkan ke Siswa (Anak)</label>
            <select name="siswa_id" required class="w-full bg-slate-50 border border-slate-200 p-3 rounded-xl focus:outline-none focus:border-sky-500 font-bold text-slate-700 cursor-pointer">
                @foreach($daftarSiswa as $s)
                    <option value="{{ $s->id }}" {{ ($anakSekarang && $anakSekarang->id == $s->id) ? 'selected' : '' }}>
                        {{ $s->nama }} (NISN: {{ $s->nisn }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="pt-4">
            <button type="submit" class="w-full bg-slate-800 hover:bg-black text-white font-black py-4 rounded-2xl shadow-lg transition-all cursor-pointer">
                Simpan Perubahan Data
            </button>
        </div>
    </form>
</div>
@endsection