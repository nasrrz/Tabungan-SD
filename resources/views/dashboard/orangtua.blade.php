@extends('dashboard.layout')

@section('title', 'Tabungan Anak - Wali Murid')

@section('content')
    <div class="mb-8">
        <h1 class="text-2xl md:text-3xl font-bold text-slate-800 tracking-tight">Monitoring Tabungan Anak</h1>
        <p class="text-slate-500 text-sm mt-1 font-medium">Ayah/Bunda: <span class="font-bold text-slate-700">{{ Auth::user()->nama }}</span></p>
    </div>

    <div class="space-y-12">
        @foreach($dataTabunganAnak as $item)
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200/60">
                
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-slate-100 pb-6 mb-6">
                    <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                        <div class="w-12 h-12 bg-sky-50 text-sky-600 rounded-2xl flex items-center justify-center text-xl font-bold border border-sky-100 flex-shrink-0">
                            <i class="bi bi-person-fill"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-black text-slate-800">{{ $item['identitas']->nama }}</h2>
                            <p class="text-xs text-slate-400 font-medium mt-0.5">NISN: {{ $item['identitas']->nisn }} | Kelas: <span class="text-blue-600 font-bold">{{ $item['identitas']->nama_kelas }}</span></p>
                            
                            <form action="" method="GET" class="flex items-center gap-2 mt-3" onsubmit="return handleDownloadOrtu(this, {{ $item['identitas']->id }})">
                                <select class="select-bulan px-2 py-1 text-xs font-bold rounded-lg border border-slate-200 bg-slate-50 text-slate-700 focus:outline-none focus:ring-2 focus:ring-sky-500/20 cursor-pointer">
                                    @for($m=1; $m<=12; $m++)
                                        <option value="{{ sprintf('%02d', $m) }}" {{ date('m') == $m ? 'selected' : '' }}>
                                            {{ date('F', mktime(0, 0, 0, $m, 10)) }}
                                        </option>
                                    @endfor
                                </select>
                                <select class="select-tahun px-2 py-1 text-xs font-bold rounded-lg border border-slate-200 bg-slate-50 text-slate-700 focus:outline-none focus:ring-2 focus:ring-sky-500/20 cursor-pointer">
                                    <option value="2026" selected>2026</option>
                                    <option value="2027">2027</option>
                                </select>
                                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-3 py-1 rounded-lg text-xs font-bold shadow-sm shadow-emerald-600/10 transition flex items-center gap-1 cursor-pointer">
                                    <i class="bi bi-file-earmark-excel-fill"></i> Unduh Excel
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="bg-gradient-to-br from-sky-500 to-sky-600 px-6 py-3 rounded-2xl text-white shadow-md shadow-sky-500/10 h-fit">
                        <span class="text-[10px] uppercase font-bold tracking-wider text-emerald-100 block">Total Saldo Anak</span>
                        <span class="text-xl font-black">Rp {{ number_format($item['saldo'], 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    
                    <div class="bg-slate-50/70 p-4 rounded-2xl border border-slate-200/40">
                        <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3"><i class="bi bi-calendar-check text-amber-500"></i> Rekap Mutasi Bulanan</h3>
                        <div class="space-y-2.5">
                            @forelse($item['rekap'] as $rkp)
                                <div class="bg-white p-3 rounded-xl border border-slate-200/60 shadow-sm flex items-center justify-between">
                                    <div>
                                        <p class="font-bold text-slate-800 text-sm">Bulan {{ date('F', mktime(0, 0, 0, $rkp->bulan, 10)) }} {{ $rkp->tahun }}</p>
                                    </div>
                                    <div class="text-right text-xs font-bold space-y-0.5">
                                        <p class="text-emerald-600">▲ +Rp {{ number_format($rkp->total_setor, 0, ',', '.') }}</p>
                                        <p class="text-rose-600">▼ -Rp {{ number_format($rkp->total_tarik, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-xs text-slate-400 italic">Belum ada rekap bulanan.</p>
                            @endforelse
                        </div>
                    </div>

                    <div class="lg:col-span-2">
                        <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3"><i class="bi bi-clock-history text-sky-500"></i> Jurnal Transaksi Dari Awal</h3>
                        <div class="overflow-hidden border border-slate-100 rounded-xl bg-white max-h-[300px] overflow-y-auto custom-scrollbar">
                            <table class="w-full text-left border-collapse">
                                <thead class="bg-slate-50 text-slate-400 text-[10px] font-bold uppercase tracking-wider sticky top-0">
                                    <tr>
                                        <th class="p-3 pl-4">Tanggal</th>
                                        <th class="p-3">Aksi</th>
                                        <th class="p-3">Nominal</th>
                                        <th class="p-3">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody class="text-xs divide-y divide-slate-100 text-slate-600">
                                    @forelse($item['riwayat'] as $trx)
                                        <tr class="hover:bg-slate-50/50">
                                            <td class="p-3 pl-4 font-mono text-slate-400">{{ date('d M Y | H:i', strtotime($trx->created_at)) }}</td>
                                            <td class="p-3">
                                                <span class="px-2 py-0.5 rounded-md font-bold text-[10px] {{ $trx->jenis == 'setor' ? 'bg-emerald-50 text-emerald-700' : 'bg-rose-50 text-rose-700' }}">
                                                    {{ strtoupper($trx->jenis) }}
                                                </span>
                                            </td>
                                            <td class="p-3 font-bold {{ $trx->jenis == 'setor' ? 'text-emerald-600' : 'text-rose-600' }}">
                                                Rp {{ number_format($trx->jumlah, 0, ',', '.') }}
                                            </td>
                                            <td class="p-3 text-slate-400 italic font-medium">{{ $trx->keterangan ?? '-' }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="p-6 text-center text-slate-400 italic">Belum ada riwayat menabung.</td>
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
            
            // Set URL action secara dinamis mengarah ke rute download orang tua
            form.action = `/orang-tua/rekap/download/${siswaId}/${bulan}/${tahun}`;
            return true;
        }
    </script>
@endsection