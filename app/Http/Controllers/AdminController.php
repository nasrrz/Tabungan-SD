<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash; // 👈 Pastikan Hash ini di-import dengan benar di atas
use App\Imports\SiswaImport;
use Maatwebsite\Excel\Facades\Excel;

class AdminController extends Controller
{
    public function importSiswaMassal(Request $request)
    {
        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls|max:4096',
            'kelas_id'   => 'required|numeric', 
        ]);

        try {
            Excel::import(new SiswaImport($request->kelas_id), $request->file('file_excel'));
            return back()->with('success', 'Data siswa berhasil masuk ke kelas yang dipilih.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal membaca file Excel. Cek format kolomnya.');
        }
    }

    public function dashboard()
    {
        $totalGuru = DB::table('users')->where('role', 'guru')->count();
        $totalSiswa = DB::table('siswa')->count();
        $totalKelas = DB::table('kelas')->count();

        $totalSetor = DB::table('transaksi')->where('jenis', 'setor')->sum('jumlah');
        $totalTarik = DB::table('transaksi')->where('jenis', 'tarik')->sum('jumlah');
        $totalKasNasional = $totalSetor - $totalTarik;

        return view('dashboard.admin', compact('totalGuru', 'totalSiswa', 'totalKelas', 'totalKasNasional'));
    }

    // =========================================================================
    // MANAGEMENT DATA GURU
    // =========================================================================
    public function dataGuru()
    {
        $daftarGuru = DB::table('users')->where('role', 'guru')->get();
        return view('dashboard.admin_guru', compact('daftarGuru'));
    }

    public function formGuru()
    {
        return view('dashboard.admin_guru_form');
    }

    public function simpanGuru(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|min:4|unique:users,username',
            'password' => 'required|string|min:6',
            'jenis_kelamin' => 'required|in:L,P',
        ]);

        DB::table('users')->insert([
            'nama' => $request->nama,
            'username' => strtolower($request->username),
            'password' => Hash::make($request->password),
            'role' => 'guru',
            'jenis_kelamin' => $request->jenis_kelamin,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect('/admin/guru')->with('success', 'Akun Guru baru berhasil didaftarkan!');
    }

    public function editGuru($id)
    {
        $guru = DB::table('users')->where('id', $id)->where('role', 'guru')->first();
        if (!$guru) {
            return redirect('/admin/guru')->with('error', 'Data guru tidak ditemukan!');
        }
        return view('dashboard.admin_guru_edit', compact('guru'));
    }

    public function updateGuru(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'nama' => 'required|string|max:255',
            'username' => 'required|string|min:4|unique:users,username,' . $request->id,
            'jenis_kelamin' => 'required|in:L,P',
        ]);

        $updateData = [
            'nama' => $request->nama,
            'username' => strtolower($request->username),
            'jenis_kelamin' => $request->jenis_kelamin,
            'updated_at' => now(),
        ];

        if ($request->filled('password')) {
            $request->validate(['password' => 'min:6']);
            $updateData['password'] = Hash::make($request->password);
        }

        DB::table('users')->where('id', $request->id)->update($updateData);
        return redirect('/admin/guru')->with('success', 'Data akun guru berhasil diperbarui!');
    }

    public function hapusGuru($id)
    {
        DB::table('users')->where('id', $id)->where('role', 'guru')->delete();
        return redirect('/admin/guru')->with('success', 'Akun Guru berhasil dihapus!');
    }

    // =========================================================================
    // MANAGEMENT DATA SISWA
    // =========================================================================
    public function dataSiswa(Request $request)
    {
        $daftarKelas = DB::table('kelas')->get();
        $query = DB::table('siswa')
            ->leftJoin('kelas', 'siswa.kelas_id', '=', 'kelas.id')
            ->select('siswa.*', 'kelas.nama_kelas');

        if ($request->has('kelas_id') && $request->kelas_id != '') {
            $query->where('siswa.kelas_id', $request->kelas_id);
        }

        $daftarSiswa = $query->get();
        return view('dashboard.admin_siswa', compact('daftarSiswa', 'daftarKelas'));
    }

    public function formSiswa()
    {
        $daftarKelas = DB::table('kelas')->get();
        return view('dashboard.admin_siswa_form', compact('daftarKelas'));
    }

    public function simpanSiswa(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nisn' => 'required|numeric|unique:siswa,nisn',
            'kelas_id' => 'required'
        ]);

        DB::table('siswa')->insert([
            'nama' => $request->nama,
            'nisn' => $request->nisn,
            'kelas_id' => $request->kelas_id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect('/admin/siswa')->with('success', 'Siswa baru berhasil didaftarkan!');
    }

    public function hapusSiswa($id)
    {
        DB::table('siswa')->where('id', $id)->delete();
        return redirect('/admin/siswa')->with('success', 'Data siswa berhasil dihapus!');
    }

    // =========================================================================
    // MANAGEMENT DATA KELAS
    // =========================================================================
    public function dataKelas()
    {
        $daftarKelas = DB::table('kelas')
            ->leftJoin('users', 'kelas.guru_id', '=', 'users.id')
            ->select('kelas.*', 'users.nama as nama_guru', 'users.jenis_kelamin')
            ->get();
            
        return view('dashboard.admin_kelas', compact('daftarKelas'));
    }

    public function formKelas()
    {
        $daftarGuru = DB::table('users')->where('role', 'guru')->get();
        return view('dashboard.admin_kelas_form', compact('daftarGuru'));
    }

    public function simpanKelas(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:50',
            'guru_id' => 'nullable|unique:kelas,guru_id'
        ]);

        DB::table('kelas')->insert([
            'nama_kelas' => $request->nama_kelas,
            'guru_id' => $request->guru_id ?: null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect('/admin/kelas')->with('success', 'Ruang kelas baru berhasil dibuat!');
    }

    public function hapusKelas($id)
    {
        DB::table('kelas')->where('id', $id)->delete();
        return redirect('/admin/kelas')->with('success', 'Ruang kelas berhasil dihapus!');
    }

    // =========================================================================
    // SUNTIKAN BARU: MANAGEMENT DATA ORANG TUA (ROLE: ORANGTUA, USERNAME ONLY)
    // =========================================================================
    
    public function dataOrtu()
    {
        $daftarOrtu = DB::table('users')->where('role', 'orang_tua')->get();
        $daftarSiswa = DB::table('siswa')->whereNull('ortu_id')->orderBy('nama', 'ASC')->get();
        return view('dashboard.admin_ortu', compact('daftarOrtu', 'daftarSiswa'));
    }

    public function simpanOrtu(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'siswa_id' => 'required|numeric',
        ]);

        $cekUsername = DB::table('users')->where('username', trim($request->username))->first();
        if ($cekUsername) {
            return back()->with('error', 'Gagal! Username tersebut sudah digunakan oleh user lain.');
        }

        try {
            DB::beginTransaction();

            $ortuId = DB::table('users')->insertGetId([
                'nama'       => trim($request->nama),
                'username'   => trim($request->username),
                'role'       => 'orang_tua',
                'password'   => Hash::make('ortu123'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('siswa')->where('id', $request->siswa_id)->update([
                'ortu_id'    => $ortuId,
                'updated_at' => now(),
            ]);

            DB::commit();
            return back()->with('success', 'Akun Orang Tua berhasil dibuat dengan Username!');
        } catch (\Exception $e) {
            DB::beginTransaction(); // Reset transaction jika error
            return back()->with('error', 'Terjadi kesalahan sistem saat menyimpan data.');
        }
    }

    public function editOrtu($id)
    {
        $ortu = DB::table('users')->where('id', $id)->where('role', 'orangtua')->first();
        if (!$ortu) { abort(404); }

        $anakSekarang = DB::table('siswa')->where('ortu_id', $id)->first();
        $daftarSiswa = DB::table('siswa')->whereNull('ortu_id')
                        ->orWhere('ortu_id', $id)
                        ->orderBy('nama', 'ASC')->get();

        return view('dashboard.admin_ortu_edit', compact('ortu', 'anakSekarang', 'daftarSiswa'));
    }

    public function updateOrtu(Request $request, $id)
    {
        $request->validate([
            'nama'     => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'siswa_id' => 'required|numeric',
        ]);

        try {
            DB::beginTransaction();

            DB::table('users')->where('id', $id)->update([
                'nama'       => trim($request->nama),
                'username'   => trim($request->username),
                'updated_at' => now(),
            ]);

            DB::table('siswa')->where('ortu_id', $id)->update(['ortu_id' => null]);
            DB::table('siswa')->where('id', $request->siswa_id)->update([
                'ortu_id'    => $id,
                'updated_at' => now(),
            ]);

            DB::commit();
            return redirect('/admin/ortu')->with('success', 'Data Orang Tua berhasil diperbarui!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui data.');
        }
    }

    public function hapusOrtu($id)
    {
        try {
            DB::beginTransaction();
            DB::table('siswa')->where('ortu_id', $id)->update(['ortu_id' => null]);
            DB::table('users')->where('id', $id)->delete();
            DB::commit();
            return redirect('/admin/ortu')->with('success', 'Akun Orang Tua berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus data.');
        }
    }
}