@extends('dashboard.layout')

@section('title', 'Buat Kelas Baru')

@section('content')
    <div class="mb-6">
        <a href="/admin/kelas" class="inline-flex items-center gap-2 text-sm font-semibold text-sky-700 hover:text-sky-800 bg-white px-4 py-2 rounded-lg border border-slate-200 shadow-sm transition-colors">
            <i class="bi bi-arrow-left"></i> Kembali ke Data Kelas
        </a>
    </div>

    <div class="w-full flex items-center justify-center p-2 md:p-6">
        <div class="w-full max-w-md bg-white p-6 md:p-8 rounded-xl border border-slate-200 shadow-sm">
            <h2 class="text-2xl font-bold text-slate-800 mb-1 tracking-tight">Buat Kelas Baru</h2>
            <p class="text-slate-500 text-sm mb-6">Tambahkan kelas dan tentukan wali kelas pengampunya</p>

            @if ($errors->any())
                <div class="mb-5 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm font-medium">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="/admin/kelas/simpan" method="POST" class="space-y-5">
                @csrf

                <!-- Nama Kelas -->
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Nama Ruang Kelas</label>
                    <input
                        type="text"
                        name="nama_kelas"
                        required
                        value="{{ old('nama_kelas') }}"
                        placeholder="Masukkan nama kelas"
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-300 bg-white text-slate-800 placeholder:text-slate-400
                               focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500
                               transition-colors text-sm font-medium"
                    >
                </div>

                <!-- Wali Kelas -->
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Pilih Wali Kelas</label>
                    <select
                        name="guru_id"
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-300 bg-white text-slate-800
                               focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500
                               transition-colors text-sm font-medium cursor-pointer"
                    >
                        <option value=""> Biarkan kosong terlebih dahulu </option>
                        @foreach($daftarGuru as $guru)
                            <option value="{{ $guru->id }}" {{ old('guru_id') == $guru->id ? 'selected' : '' }}>
                                @if($guru->jenis_kelamin == 'L')
                                    Ustadz {{ $guru->nama }}
                                @else
                                    Ustadzah {{ $guru->nama }}
                                @endif
                            </option>
                        @endforeach
                    </select>
<<<<<<< HEAD
                    <p class="text-xs text-slate-400 mt-1.5">*Satu guru hanya dapat menjadi wali kelas 1 ruang kelas.</p>
=======
                    <p class="text-[10px] text-slate-400 mt-1 font-medium">*Satu guru hanya bisa menjadi wali kelas untuk satu ruang kelas saja.</p>
>>>>>>> 4a322da1abc015338aa192da8bc785f07d2a3d97
                </div>

                <!-- Submit -->
                <button
                    type="submit"
                    class="w-full bg-sky-500 hover:bg-sky-600 text-white font-semibold py-3 rounded-lg shadow-sm
                           transition-colors duration-150 flex items-center justify-center gap-2 text-sm"
                >
                    <i class="bi bi-building-plus"></i> Simpan & Buat Kelas
                </button>
            </form>
        </div>
    </div>
<<<<<<< HEAD
</div>
@endsection
=======
@endsection
>>>>>>> 4a322da1abc015338aa192da8bc785f07d2a3d97
