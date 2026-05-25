@extends('dashboard.layout')

@section('title', 'Manajemen Data Guru')

@section('content')
    @if(session('success'))
    <div class="mb-4 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-sm font-semibold flex items-center gap-2">
        <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
    </div>
    @endif

    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-8">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-slate-800 tracking-tight">Data Guru Pengajar</h1>
            <p class="text-slate-500 text-sm mt-1 font-medium">Kelola akun Ustadz/Ustadzah wali kelas</p>
        </div>
        <a href="/admin/guru/tambah" class="bg-sky-500 hover:bg-sky-600 text-white px-4 py-2.5 rounded-xl text-sm font-bold shadow-md shadow-sky-500/10 transition flex items-center gap-2 cursor-pointer w-fit">
            <i class="bi bi-plus-circle-fill"></i> Tambah Guru Baru
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[500px]">
                <thead class="bg-slate-50/80 text-slate-500 text-xs font-bold uppercase tracking-wider border-b border-slate-200/60">
                    <tr>
                        <th class="p-4 pl-6 w-16">No</th>
                        <th class="p-4">Nama Lengkap</th>
                        <th class="p-4">Username</th>
                        <th class="p-4 text-center">Ustadz/Ustadzah</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-slate-700 divide-y divide-slate-100">
                    @forelse($daftarGuru as $index => $guru)
                    <tr class="hover:bg-slate-50/60 transition-all">
                        <td class="p-4 pl-6 font-semibold text-slate-400">{{ $index + 1 }}</td>
                        <td class="p-4 font-bold text-slate-800">{{ $guru->nama }}</td>
                        <td class="p-4 font-mono text-slate-500">{{ $guru->username }}</td>
                        
                        <td class="p-4 text-center">
                            @if($guru->jenis_kelamin == 'L')
                                <span class="inline-block px-2.5 py-1 bg-blue-100 text-blue-700 text-[10px] font-black uppercase rounded-md tracking-wide">Ustadz</span>
                            @else
                                <span class="inline-block px-2.5 py-1 bg-rose-100 text-rose-700 text-[10px] font-black uppercase rounded-md tracking-wide">Ustadzah</span>
                            @endif
                        </td>

                        <td class="p-4">
                            <div class="flex justify-center gap-2">
                                <a href="/admin/guru/edit/{{ $guru->id }}" class="text-amber-600 bg-amber-50 hover:bg-amber-500 hover:text-white p-2 rounded-xl transition shadow-sm inline-block">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                
                                <form action="/admin/guru/hapus/{{ $guru->id }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun guru ini?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose-600 bg-rose-50 hover:bg-rose-500 hover:text-white p-2 rounded-xl transition shadow-sm cursor-pointer">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-slate-400 font-medium">Belum ada data guru terdaftar.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection