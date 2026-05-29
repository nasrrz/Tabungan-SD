@extends('dashboard.layout')

@section('title', 'Edit Data Siswa')

@section('content')
    <div class="mb-6">
        <a href="/admin/siswa" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-700 hover:text-slate-800 bg-white px-4 py-2 rounded-lg border border-slate-200 shadow-sm transition-colors">
            <i class="bi bi-arrow-left"></i> Kembali ke Data Siswa
        </a>
    </div>

    <div class="w-full flex items-center justify-center p-2 md:p-6">
        <div class="w-full max-w-md bg-white p-6 md:p-8 rounded-xl border border-slate-200 shadow-sm">
            <h2 class="text-2xl font-bold text-slate-800 mb-1 tracking-tight">Edit Data Siswa</h2>
            <p class="text-slate-500 text-sm mb-6">Perbarui informasi murid yang sudah terdaftar</p>

            {{-- Error validasi --}}
            @if ($errors->any())
                <div class="mb-5 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm font-medium">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="/admin/siswa/update/{{ $siswa->id }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <!-- Nama Lengkap -->
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Nama Lengkap Murid</label>
                    <input
                        type="text"
                        name="nama"
                        required
                        value="{{ old('nama', $siswa->nama) }}"
                        placeholder="Masukkan nama lengkap"
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-300 bg-white text-slate-800 placeholder:text-slate-400
                               focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500
                               transition-colors text-sm font-medium"
                    >
                </div>

                <!-- NISN -->
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">NISN (10 Digit Angka)</label>
                    <input
                        type="number"
                        name="nisn"
                        required
                        value="{{ old('nisn', $siswa->nisn) }}"
                        placeholder="Masukkan NISN"
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-300 bg-white text-slate-800 placeholder:text-slate-400
                               focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500
                               transition-colors text-sm font-medium"
                    >
                </div>

                <!-- Kelas -->
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Plotting Ruang Kelas</label>
                    <select
                        name="kelas_id"
                        required
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-300 bg-white text-slate-800
                               focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500
                               transition-colors text-sm font-medium cursor-pointer"
                    >
                        <option value=""> Pilih Ruang Kelas </option>
                        @foreach($daftarKelas as $kls)
                            <option value="{{ $kls->id }}" {{ old('kelas_id', $siswa->kelas_id) == $kls->id ? 'selected' : '' }}>
                                {{ $kls->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Submit -->
                <button
                    type="submit"
                    class="w-full bg-sky-500 hover:bg-sky-600 text-white font-semibold py-3 rounded-lg shadow-sm
                           transition-colors duration-150 flex items-center justify-center gap-2 text-sm"
                >
                    <i class="bi bi-save"></i> Simpan Perubahan
                </button>
            </form>
        </div>
    </div>
</div>
@endsection