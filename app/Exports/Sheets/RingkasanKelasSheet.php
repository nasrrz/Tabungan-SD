<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping; // PERBAIKAN 1: Import concern WithMapping
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Facades\DB;

// PERBAIKAN 2: Daftarkan WithMapping di bawah ini agar fungsi map() aktif dijalankan sistem
class RingkasanKelasSheet implements FromCollection, WithTitle, WithHeadings, WithStyles, ShouldAutoSize, WithColumnFormatting, WithMapping
{
    protected $kelasId;
    protected $bulan;
    protected $tahun;
    protected $daftarSiswa;
    private $rowNumber = 0;

    public function __construct($kelasId, $bulan, $tahun, $daftarSiswa)
    {
        $this->kelasId = $kelasId;
        $this->bulan = $bulan;
        $this->tahun = $tahun;
        $this->daftarSiswa = $daftarSiswa;
    }

    public function collection()
    {
        if ($this->daftarSiswa->isEmpty()) {
            return collect([
                (object)['id' => 1, 'nisn' => '0123456789', 'nama' => 'Ahmad Fauzi (Dummy)'],
                (object)['id' => 2, 'nisn' => '0123456788', 'nama' => 'Siti Aminah (Dummy)'],
            ]);
        }
        return $this->daftarSiswa;
    }

    public function title(): string
    {
        return 'Ringkasan Kelas';
    }

    /**
     * HEADINGS PAS 6 KOLOM
     */
    public function headings(): array
    {
        return [
            'No Absen',
            'NISN',
            'Nama Siswa',
            'Total Setoran Bulan Ini',
            'Total Penarikan Bulan Ini',
            'Saldo Akhir Murid'
        ];
    }

    public function columnFormats(): array
    {
        return [
            'D' => '"Rp "#,##0',
            'E' => '"Rp "#,##0',
            'F' => '"Rp "#,##0',
        ];
    }

    /**
     * MAP HARUS PAS RETURNING 6 ELEMEN DATA
     */
    public function map($siswa): array
    {
        $this->rowNumber++;

        // 1. Hitung total uang masuk bulanan per anak
        $totalMasuk = DB::table('transaksi')
            ->where('siswa_id', $siswa->id)
            ->where('jenis', 'setor')
            ->whereMonth('created_at', $this->bulan)
            ->whereYear('created_at', $this->tahun)
            ->sum('jumlah') ?? 0;

        // 2. Hitung total uang keluar bulanan per anak
        $totalKeluar = DB::table('transaksi')
            ->where('siswa_id', $siswa->id)
            ->where('jenis', 'tarik')
            ->whereMonth('created_at', $this->bulan)
            ->whereYear('created_at', $this->tahun)
            ->sum('jumlah') ?? 0;

        // Simulasi pengisi nilai jika data di DB kosong (data dummy)
        if ($totalMasuk == 0 && $totalKeluar == 0 && $this->daftarSiswa->isEmpty()) {
            $totalMasuk = $siswa->id == 1 ? 500000 : 350000;
            $totalKeluar = $siswa->id == 1 ? 150000 : 50000;
        }

        // Return tepat 6 kolom lurus ke kanan
        return [
            $this->rowNumber,                               // Kolom A: No Absen
            $siswa->nisn,                                   // Kolom B: NISN
            $siswa->nama,                                   // Kolom C: Nama Siswa
            (int)$totalMasuk,                               // Kolom D: Total Setoran
            (int)$totalKeluar,                              // Kolom E: Total Penarikan
            (int)($totalMasuk - $totalKeluar)               // Kolom F: Saldo Bersih Tiap Siswa
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Warnai Header Utama Atas (Baris 1) menjadi Navy Blue profesional
        $sheet->getStyle('A1:F1')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '1E3A8A']
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ]
        ]);

        $highestRow = $sheet->getHighestRow();

        // Atur posisi perataan teks biar rapi dibaca mata
        $sheet->getStyle("A2:B{$highestRow}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("D2:F{$highestRow}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

        // Kunci garis tepi border kotak tipis ke seluruh baris data siswa yang ada
        $sheet->getStyle("A1:F{$highestRow}")->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    }
}