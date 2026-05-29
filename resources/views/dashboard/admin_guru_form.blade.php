@extends('dashboard.layout')

@section('title', 'Pendaftaran Guru Baru')

@section('content')
    <div class="mb-6">
        <a href="/admin/guru" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-700 hover:text-slate-800 bg-white px-4 py-2 rounded-lg border border-slate-200 shadow-sm transition-colors">
            <i class="bi bi-arrow-left"></i> Kembali ke Data Guru
        </a>
    </div>

    <div class="w-full flex items-center justify-center p-2 md:p-6">
        <div class="w-full max-w-md bg-white p-6 md:p-8 rounded-xl border border-slate-200 shadow-sm">
            <h2 class="text-2xl font-bold text-slate-800 mb-1 tracking-tight">Tambah Guru Baru</h2>
            <p class="text-slate-500 text-sm mb-6">Buat akun akses pendaftaran untuk wali kelas baru</p>

            @if ($errors->any())
                <div class="mb-5 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm font-medium">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="/admin/guru/simpan" method="POST" class="space-y-5">
                @csrf

                <!-- Nama Lengkap -->
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Nama Lengkap & Gelar</label>
                    <input
                        type="text"
                        name="nama"
                        required
                        value="{{ old('nama') }}"
                        placeholder="Masukkan nama lengkap dan gelar"
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-300 bg-white text-slate-800 placeholder:text-slate-400
                               focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500
                               transition-colors text-sm font-medium"
                    >
                </div>

                <!-- Username -->
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Username Kustom (Untuk Login)</label>
                    <input
                        type="text"
                        name="username"
                        required
                        value="{{ old('username') }}"
                        placeholder="Masukkan username unik"
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-300 bg-white text-slate-800 placeholder:text-slate-400
                               focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500
                               transition-colors text-sm font-medium font-mono"
                    >
                </div>

                <!-- Jenis Kelamin -->
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Jenis Kelamin</label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="relative flex items-center justify-between p-3 border border-slate-300 rounded-lg cursor-pointer bg-white hover:bg-sky-50/30 transition has-[:checked]:border-sky-500 has-[:checked]:bg-sky-50">
                            <span class="text-sm font-medium text-slate-700">Laki-laki (Ustadz)</span>
                            <input type="radio" name="jenis_kelamin" value="L" required class="w-4 h-4 text-sky-500 focus:ring-sky-500">
                        </label>
                        <label class="relative flex items-center justify-between p-3 border border-slate-300 rounded-lg cursor-pointer bg-white hover:bg-rose-50/30 transition has-[:checked]:border-rose-500 has-[:checked]:bg-rose-50">
                            <span class="text-sm font-medium text-slate-700">Perempuan (Ustadzah)</span>
                            <input type="radio" name="jenis_kelamin" value="P" required class="w-4 h-4 text-rose-500 focus:ring-rose-500">
                        </label>
                    </div>
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Password Akses Awal</label>
                    <input
                        type="text"
                        name="password"
                        required
                        placeholder="Minimal 6 karakter"
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-300 bg-white text-slate-800 placeholder:text-slate-400
                               focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500
                               transition-colors text-sm font-medium"
                    >
                    <p class="text-xs text-slate-400 mt-1.5">*Berikan password ini kepada guru yang bersangkutan untuk login.</p>
                </div>

                <!-- Submit -->
                <button
                    type="submit"
                    class="w-full bg-sky-500 hover:bg-sky-600 text-white font-semibold py-3 rounded-lg shadow-sm
                           transition-colors duration-150 flex items-center justify-center gap-2 text-sm"
                >
                    <i class="bi bi-person-plus-fill"></i> Daftarkan Guru Baru
                </button>
            </form>
        </div>
    </div>
@endsection