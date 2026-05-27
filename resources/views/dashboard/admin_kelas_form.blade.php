@extends('dashboard.layout')

@section('title', 'Pembuatan Kelas Baru')

@section('content')
    <div class="mb-4">
        <a href="/admin/kelas" class="inline-flex items-center gap-2 text-sm font-bold text-blue-700 hover:text-blue-800 transition bg-white px-4 py-2 rounded-xl border border-slate-200 shadow-sm">
            <i class="bi bi-arrow-left"></i> Kembali ke Data Kelas
        </a>
    </div>

    <div class="w-full flex items-center justify-center p-2 md:p-6">
        <div class="w-full max-w-md bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-slate-200/60 transition-all">
            <h2 class="text-2xl font-black text-slate-800 mb-1 tracking-tight">Buat Kelas Baru</h2>
            <p class="text-slate-500 text-sm font-medium mb-6">Tambahkan Kelas baru dan tentukan Ustadz/Ustdzah pengampunya</p>

            @if ($errors->any())
                <div class="mb-4 p-3 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl text-xs font-semibold">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>Guru terpilih sudah menjadi wali kelas di tempat lain!</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="/admin/kelas/simpan" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Ruang Kelas</label>
                    <input type="text" name="nama_kelas" required placeholder="" value="{{ old('nama_kelas') }}"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition font-bold text-slate-800">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Pilih Wali Kelas</label>
                    <select name="guru_id" class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition font-medium text-slate-800 cursor-pointer">
                        <option value=""> Biarkan Kosong Terlebih Dahulu </option>
                        @foreach($daftarGuru as $guru)
                            <option value="{{ $guru->id }}">
                        @if($guru->jenis_kelamin == 'L')
                            Ustadz {{ $guru->nama }}
                        @else
                            Ustadzah {{ $guru->nama }}
                        @endif
                    </option>
                        @endforeach
                    </select>
                    <p class="text-[10px] text-slate-400 mt-1 font-medium">*Satu guru hanya bisa menjadi wali kelas untuk satu ruang kelas saja.</p>
                </div>

                <button type="submit" class="w-full bg-sky-500 hover:bg-sky-600 text-white font-bold py-3.5 rounded-xl shadow-md shadow-sky-500/10 transition active:scale-[0.99] cursor-pointer flex items-center justify-center gap-2">
                    <i class="bi bi-building-plus"></i> Simpan & Buat Kelas
                </button>
            </form>
        </div>
    </div>
@endsection
