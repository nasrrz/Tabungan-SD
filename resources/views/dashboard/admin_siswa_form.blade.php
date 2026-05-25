@extends('dashboard.layout')

@section('title', 'Pendaftaran Murid Baru')

@section('content')
    <div class="mb-4">
        <a href="/admin/siswa" class="inline-flex items-center gap-2 text-sm font-bold text-blue-700 hover:text-blue-800 transition bg-white px-4 py-2 rounded-xl border border-slate-200 shadow-sm">
            <i class="bi bi-arrow-left"></i> Kembali ke Data Siswa
        </a>
    </div>

    <div class="w-full flex items-center justify-center p-2 md:p-6">
        <div class="w-full max-w-md bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-slate-200/60 transition-all">
            <h2 class="text-2xl font-black text-slate-800 mb-1 tracking-tight">Pendaftaran Siswa</h2>
            <p class="text-slate-500 text-sm font-medium mb-6">Tambahkan identitas murid baru ke sistem pusat</p>

            <form action="/admin/siswa/simpan" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Lengkap Murid</label>
                    <input type="text" name="nama" required placeholder=""
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition font-bold text-slate-800">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">NISN (10 Digit Angka)</label>
                    <input type="number" name="nisn" required placeholder=""
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition font-bold text-slate-800">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Plotting Ruang Kelas</label>
                    <select name="kelas_id" required class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition font-medium text-slate-800 cursor-pointer">
                        <option value=""> Pilih Ruang Kelas </option>
                        @foreach($daftarKelas as $kls)
                            <option value="{{ $kls->id }}">{{ $kls->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="w-full bg-sky-500 hover:bg-sky-600 text-white font-bold py-3.5 rounded-xl shadow-md shadow-sky-500/10 transition active:scale-[0.99] cursor-pointer flex items-center justify-center gap-2">
                    <i class="bi bi-person-plus-fill"></i> Daftarkan Sekarang
                </button>
            </form>
        </div>
    </div>
@endsection