@extends('dashboard.layout')

@section('title', 'Pencatatan Tabungan')

@section('content')
    <div class="mb-6">
        <a href="/guru/dashboard" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-700 hover:text-slate-800 bg-white px-4 py-2 rounded-lg border border-slate-200 shadow-sm transition-colors">
            <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>

    @if(session('error'))
    <div class="mb-5 max-w-md mx-auto p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm font-medium flex items-center gap-2">
        <i class="bi bi-exclamation-triangle-fill text-base"></i> {{ session('error') }}
    </div>
    @endif

    <div class="w-full flex items-center justify-center p-2 md:p-6">
        <div class="w-full max-w-md bg-white p-6 md:p-8 rounded-xl border border-slate-200 shadow-sm">
            <h2 class="text-2xl font-bold text-slate-800 mb-1 tracking-tight">Pencatatan Tabungan</h2>
            <p class="text-slate-500 text-sm mb-6">
                Siswa: <span class="font-semibold text-slate-800">{{ $siswa->nama }}</span>
            </p>

            <form action="/guru/transaksi" method="POST" id="form-transaksi" class="space-y-5">
                @csrf
                <input type="hidden" name="siswa_id" value="{{ $siswa->id }}">

                {{-- Jenis Transaksi --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Jenis Transaksi</label>
                    <select
                        name="jenis"
                        required
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-300 bg-white text-slate-800
                               focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500
                               transition-colors text-sm font-medium cursor-pointer"
                    >
                        <option value="setor">💰 Setor Tunai (Menabung)</option>
                        <option value="tarik">💸 Tarik Tunai (Pengambilan)</option>
                    </select>
                </div>

                {{-- Nominal --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Nominal (Rp)</label>
                    <input
                        type="number"
                        name="jumlah"
                        required
                        min="1000"
                        placeholder=""
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-300 bg-white text-slate-800 placeholder:text-slate-400
                               focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500
                               transition-colors text-sm font-medium"
                    >
                </div>

                {{-- Keterangan --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Keterangan (Opsional)</label>
                    <textarea
                        name="keterangan"
                        rows="3"
                        placeholder=""
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-300 bg-white text-slate-800 placeholder:text-slate-400
                               focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500
                               transition-colors text-sm font-medium resize-none"
                    ></textarea>
                </div>

                {{-- Tombol Submit --}}
                <button
                    type="submit"
                    id="btn-submit"
                    class="w-full bg-sky-500 hover:bg-sky-600 text-white font-semibold py-3 rounded-lg shadow-sm
                           transition-colors duration-150 flex items-center justify-center gap-2 text-sm"
                >
                    <i class="bi bi-check-circle-fill"></i> Simpan Transaksi
                </button>
            </form>
        </div>
    </div>

    {{-- Script anti double‑click tetap sama --}}
    <script>
        document.getElementById('form-transaksi').addEventListener('submit', function () {
            const btn = document.getElementById('btn-submit');
            btn.disabled = true;
            btn.innerHTML = `<span class="animate-spin inline-block w-4 h-4 border-2 border-current border-t-transparent text-white rounded-full mr-2"></span> Memproses Data...`;
        });
    </script>
@endsection