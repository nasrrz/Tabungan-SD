@extends('dashboard.layout')

@section('title', 'Manajemen Ruang Kelas')

@section('content')
    @if(session('success'))
    <div class="mb-5 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-lg text-sm font-medium flex items-center gap-2">
        <i class="bi bi-check-circle-fill text-base"></i> {{ session('success') }}
    </div>
    @endif

    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-slate-800 tracking-tight">Manajemen Ruang Kelas</h1>
            <p class="text-slate-500 text-sm mt-1">Atur ruangan kelas dan wali kelas</p>
        </div>
        <a href="/admin/kelas/tambah" class="inline-flex items-center gap-2 bg-sky-500 hover:bg-sky-600 text-white px-5 py-2.5 rounded-lg text-sm font-semibold shadow-sm transition-colors">
            <i class="bi bi-plus-circle-fill"></i> Buat Kelas Baru
        </a>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[500px]">
                <thead class="bg-slate-50 text-slate-500 text-xs font-semibold uppercase tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="p-4 pl-6 w-16">No</th>
                        <th class="p-4">Nama Kelas</th>
                        <th class="p-4">Wali Kelas</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-slate-700 divide-y divide-slate-100">
                    @forelse($daftarKelas as $index => $kelas)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="p-4 pl-6 font-medium text-slate-500">{{ $index + 1 }}</td>
                        <td class="p-4 font-semibold text-slate-800">{{ $kelas->nama_kelas }}</td>
                        <td class="p-4">
                            @if($kelas->nama_guru)
                                @if(($kelas->jenis_kelamin ?? 'L') == 'L')
                                    <span class="inline-flex items-center gap-1.5 bg-sky-50 text-sky-700 font-medium px-2.5 py-1 rounded-md text-xs">
                                        <i class="bi bi-person-circle"></i> Ustadz {{ $kelas->nama_guru }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 bg-rose-50 text-rose-700 font-medium px-2.5 py-1 rounded-md text-xs">
                                        <i class="bi bi-person-circle"></i> Ustadzah {{ $kelas->nama_guru }}
                                    </span>
                                @endif
                            @else
                                <span class="inline-flex items-center gap-1.5 bg-rose-50 text-rose-600 font-medium px-2.5 py-1 rounded-md text-xs">
                                    <i class="bi bi-exclamation-triangle-fill"></i> Belum Ada Wali Kelas
                                </span>
                            @endif
                        </td>
                        <td class="p-4">
                            <div class="flex justify-center gap-2">
                                <a href="/admin/kelas/edit/{{ $kelas->id }}" class="text-amber-600 bg-amber-50 hover:bg-amber-500 hover:text-white p-2 rounded-lg transition-colors shadow-sm" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="/admin/kelas/hapus/{{ $kelas->id }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kelas ini? Semua data relasi plotting akan dikosongkan.')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose-600 bg-rose-50 hover:bg-rose-500 hover:text-white p-2 rounded-lg transition-colors shadow-sm cursor-pointer" title="Hapus">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-8 text-center text-slate-400 font-medium">Belum ada ruangan kelas yang dibuat.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection