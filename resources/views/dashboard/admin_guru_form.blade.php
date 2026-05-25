@extends('dashboard.layout')

@section('title', 'Pendaftaran Guru Baru')

@section('content')
    <div class="mb-4">
        <a href="/admin/guru" class="inline-flex items-center gap-2 text-sm font-bold text-blue-700 hover:text-blue-800 transition bg-white px-4 py-2 rounded-xl border border-slate-200 shadow-sm">
            <i class="bi bi-arrow-left"></i> Kembali ke Data Guru
        </a>
    </div>

    <div class="w-full flex items-center justify-center p-2 md:p-6">
        <div class="w-full max-w-md bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-slate-200/60 transition-all">
            <h2 class="text-2xl font-black text-slate-800 mb-1 tracking-tight">Tambah Guru Baru</h2>
            <p class="text-slate-500 text-sm font-medium mb-6">Buat akun akses pendaftaran untuk wali kelas baru</p>

            @if ($errors->any())
                <div class="mb-4 p-3 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl text-xs font-semibold">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="/admin/guru/simpan" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Lengkap & Gelar</label>
                    <input type="text" name="nama" required placeholder="" value="{{ old('nama') }}"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition font-bold text-slate-800">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Username Kustom (Untuk Login)</label>
                    <input type="text" name="username" required placeholder="" value="{{ old('username') }}"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition font-mono font-bold text-slate-800">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Jenis Kelamin</label>
                    <div class="grid grid-cols-2 gap-4">
                        <label class="relative flex items-center justify-between p-3 border border-slate-200 rounded-xl cursor-pointer bg-slate-50/50 hover:bg-white transition group has-[:checked]:border-sky-500 has-[:checked]:bg-sky-50/30">
                            <span class="text-sm font-bold text-slate-700">Laki-laki (Ustadz)</span>
                            <input type="radio" name="jenis_kelamin" value="L" required class="w-4 h-4 text-sky-500 focus:ring-sky-500">
                        </label>
                        
                        <label class="relative flex items-center justify-between p-3 border border-slate-200 rounded-xl cursor-pointer bg-slate-50/50 hover:bg-white transition group has-[:checked]:border-rose-500 has-[:checked]:bg-rose-50/30">
                            <span class="text-sm font-bold text-slate-700">Perempuan (Ustadzah)</span>
                            <input type="radio" name="jenis_kelamin" value="P" required class="w-4 h-4 text-rose-500 focus:ring-rose-500">
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Password Akses Awal</label>
                    <input type="text" name="password" required placeholder="Minimal 6 karakter"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition font-bold text-slate-800">
                    <p class="text-[10px] text-slate-400 mt-1 font-medium">*Berikan password ini kepada guru bersangkutan agar bisa login.</p>
                </div>

                <button type="submit" class="w-full bg-sky-500 hover:bg-sky-600 text-white font-bold py-3.5 rounded-xl shadow-md shadow-sky-500/10 transition active:scale-[0.99] cursor-pointer flex items-center justify-center gap-2">
                    <i class="bi bi-person-plus-fill"></i> Daftarkan Guru Baru
                </button>
            </form>
        </div>
    </div>
@endsection