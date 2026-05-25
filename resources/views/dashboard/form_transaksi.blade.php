@extends('dashboard.layout')

@section('title', 'Pencatatan Tabungan')

@section('content')
    <div class="mb-4">
        <a href="/guru/dashboard" class="inline-flex items-center gap-2 text-sm font-bold text-blue-700 hover:text-blue-800 transition bg-white px-4 py-2 rounded-xl border border-slate-200 shadow-sm">
            <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>

    @if(session('error'))
    <div class="mb-4 max-w-md mx-auto p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl text-sm font-semibold flex items-center gap-2 shadow-sm">
        <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
    </div>
    @endif

    <div class="w-full flex items-center justify-center p-2 md:p-6">
        <div class="w-full max-w-md bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-slate-200/60 transition-all">
            <h2 class="text-2xl font-black text-slate-800 mb-1 tracking-tight">Pencatatan Tabungan</h2>
            <p class="text-slate-500 text-sm font-medium mb-6">Siswa: <span class="font-bold text-slate-700">{{ $siswa->nama }}</span></p>

            <form action="/guru/transaksi" method="POST" id="form-transaksi" class="space-y-5">
                @csrf
                <input type="hidden" name="siswa_id" value="{{ $siswa->id }}">

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Jenis Transaksi</label>
                    <select name="jenis" required class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition font-medium text-slate-800 cursor-pointer">
                        <option value="setor">💰 Setor Tunai (Menabung)</option>
                        <option value="tarik">💸 Tarik Tunai (Pengambilan)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nominal (Rp)</label>
                    <input type="number" name="jumlah" required min="1000" placeholder="Contoh: 50000"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition font-bold text-slate-800">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Keterangan (Opsional)</label>
                    <textarea name="keterangan" rows="3" placeholder="Contoh: Setoran minggu pertama"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition font-medium text-slate-700"></textarea>
                </div>

                <button type="submit" id="btn-submit" class="w-full bg-sky-500 hover:bg-sky-600 text-white font-bold py-3.5 rounded-xl shadow-md shadow-sky-500/10 transition active:scale-[0.99] cursor-pointer flex items-center justify-center gap-2">
                    <i class="bi bi-check-circle-fill"></i> Simpan Transaksi
                </button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('form-transaksi').addEventListener('submit', function (e) {
            const btn = document.getElementById('btn-submit');
            
            // Matikan tombol secara instan dan ubah teksnya saat validasi HTML lolos
            btn.disabled = true;
            btn.innerHTML = `<span class="animate-spin inline-block w-4 h-4 border-2 border-current border-t-transparent text-white rounded-full mr-2"></span> Memproses Data...`;
        });
    </script>
@endsection