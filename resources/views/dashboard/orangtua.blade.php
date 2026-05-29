@extends('dashboard.layout')

@section('title', 'Tabungan Anak - Wali Murid')

@section('content')
    <div class="mb-8">
        <h1 class="text-2xl md:text-3xl font-bold text-slate-800 tracking-tight">Monitoring Tabungan Anak</h1>
        <p class="text-slate-500 text-sm mt-1">
            Ayah/Bunda: <span class="font-semibold text-slate-700">{{ Auth::user()->nama ?? Auth::user()->name }}</span>
        </p>
    </div>

    <div class="space-y-8">
        @foreach($dataTabunganAnak as $item)
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                
                {{-- Header: Identitas + Saldo + Download --}}
                <div class="p-5 md:p-6 border-b border-slate-100">
                    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-5">
                        
                        {{-- Identitas Anak --}}
                        <div class="flex items-start gap-4 flex-1">
                            <div class="w-12 h-12 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center flex-shrink-0">
                                <i class="bi bi-person-fill text-xl"></i>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-slate-800">{{ $item['identitas']->nama }}</h2>
                                <p class="text-sm text-slate-500 mt-0.5">
                                    NISN: <span class="font-mono font-medium text-slate-700">{{ $item['identitas']->nisn }}</span>
                                    <span class="mx-2 text-slate-300">|</span>
                                    Kelas: <span class="font-semibold text-slate-700">{{ $item['identitas']->nama_kelas }}</span>
                                </p>
                                
                                {{-- Download Excel --}}
                                <form action="" method="GET" class="flex items-center gap-2 mt-3" onsubmit="return handleDownloadOrtu(this, {{ $item['identitas']->id }})">
                                    <select class="select-bulan px-2 py-1.5 text-xs font-medium rounded-lg border border-slate-300 bg-white text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 cursor-pointer">
                                        @for($m=1; $m<=12; $m++)
                                            <option value="{{ sprintf('%02d', $m) }}" {{ date('m') == $m ? 'selected' : '' }}>
                                                {{ date('F', mktime(0, 0, 0, $m, 10)) }}
                                            </option>
                                        @endfor
                                    </select>
                                    <select class="select-tahun px-2 py-1.5 text-xs font-medium rounded-lg border border-slate-300 bg-white text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 cursor-pointer">
                                        <option value="2026" selected>2026</option>
                                        <option value="2027">2027</option>
                                    </select>
                                    <button type="submit" class="inline-flex items-center gap-1 bg-emerald-600 hover:bg-emerald-700 text-white px-3 py-1.5 rounded-lg text-xs font-semibold shadow-sm transition-colors">
                                        <i class="bi bi-file-earmark-excel-fill"></i> Unduh Excel
                                    </button>
                                </form>
                            </div>
                        </div>

                        {{-- Saldo --}}
                        <div class="bg-emerald-500 px-5 py-3 rounded-xl text-white shadow-sm flex-shrink-0">
                            <span class="text-xs font-semibold text-emerald-100 uppercase tracking-wider block">Total Saldo</span>
                            <span class="text-xl font-bold">Rp {{ number_format($item['saldo'], 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                {{-- Body: Rekap & Riwayat --}}
                <div class="p-5 md:p-6 grid grid-cols-1 lg:grid-cols-3 gap-6">
                    
                    {{-- Rekap Bulanan --}}
                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-200">
                        <h3 class="text-xs font-semibold text-slate-600 uppercase tracking-wider mb-3 flex items-center gap-2">
                            <span class="w-6 h-6 rounded-md bg-amber-50 text-amber-600 flex items-center justify-center"><i class="bi bi-calendar-check text-sm"></i></span>
                            Rekap Bulanan
                        </h3>
                        <div class="space-y-2">
                            @forelse($item['rekap'] as $rkp)
                                <div class="bg-white p-3 rounded-lg border border-slate-200 shadow-sm flex items-center justify-between">
                                    <div>
                                        <p class="font-semibold text-slate-800 text-sm">{{ date('F', mktime(0, 0, 0, $rkp->bulan, 10)) }} {{ $rkp->tahun }}</p>
                                    </div>
                                    <div class="text-right text-xs font-medium space-y-0.5">
                                        <p class="text-emerald-600">+Rp {{ number_format($rkp->total_setor, 0, ',', '.') }}</p>
                                        <p class="text-rose-600">-Rp {{ number_format($rkp->total_tarik, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-xs text-slate-400 italic">Belum ada rekap bulanan.</p>
                            @endforelse
                        </div>
                    </div>

                    {{-- Jurnal Transaksi --}}
                    <div class="lg:col-span-2">
                        <h3 class="text-xs font-semibold text-slate-600 uppercase tracking-wider mb-3 flex items-center gap-2">
                            <span class="w-6 h-6 rounded-md bg-sky-50 text-sky-600 flex items-center justify-center"><i class="bi bi-clock-history text-sm"></i></span>
                            Jurnal Transaksi
                        </h3>
                        <div class="border border-slate-200 rounded-lg overflow-hidden max-h-[300px] overflow-y-auto bg-white">
                            <table class="w-full text-left border-collapse">
                                <thead class="bg-slate-50 text-slate-500 text-xs font-semibold uppercase tracking-wider sticky top-0">
                                    <tr>
                                        <th class="p-3 pl-4">Tanggal</th>
                                        <th class="p-3">Aksi</th>
                                        <th class="p-3">Nominal</th>
                                        <th class="p-3">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody class="text-sm divide-y divide-slate-100 text-slate-700">
                                    @forelse($item['riwayat'] as $trx)
                                        <tr class="hover:bg-slate-50/50 transition-colors">
                                            <td class="p-3 pl-4 font-mono text-xs text-slate-500">{{ date('d M Y | H:i', strtotime($trx->created_at)) }}</td>
                                            <td class="p-3">
                                                <span class="inline-block px-2 py-0.5 rounded-md font-medium text-xs {{ $trx->jenis == 'setor' ? 'bg-emerald-50 text-emerald-700' : 'bg-rose-50 text-rose-700' }}">
                                                    {{ strtoupper($trx->jenis) }}
                                                </span>
                                            </td>
                                            <td class="p-3 font-semibold {{ $trx->jenis == 'setor' ? 'text-emerald-600' : 'text-rose-600' }}">
                                                Rp {{ number_format($trx->jumlah, 0, ',', '.') }}
                                            </td>
                                            <td class="p-3 text-slate-500 italic">{{ $trx->keterangan ?? '-' }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="p-6 text-center text-slate-400 font-medium">Belum ada riwayat menabung.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        @endforeach
    </div>

    <script>
        function handleDownloadOrtu(form, siswaId) {
            const bulan = form.querySelector('.select-bulan').value;
            const tahun = form.querySelector('.select-tahun').value;
            form.action = `/orang-tua/rekap/download/${siswaId}/${bulan}/${tahun}`;
            return true;
        }
    </script>
@endsection