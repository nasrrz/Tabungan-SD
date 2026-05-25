<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping; 
use Maatwebsite\Excel\Events\BeforeSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Facades\DB;

class DetailSiswaSheet implements FromCollection, WithTitle, WithHeadings, WithStyles, ShouldAutoSize, WithColumnFormatting, WithEvents, WithMapping
{
    protected $siswa;
    protected $bulan;
    protected $tahun;
    private $rowNumber = 0;
    private $isDataEmpty = false;

    // 🚀 VARIABEL BARU: Untuk menampung total hitungan PHP
    private $totalSetorPHP = 0;
    private $totalTarikPHP = 0;

    public function __construct($siswa, $bulan, $tahun)
    {
        $this->siswa = $siswa;
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    public function collection()
    {
        $dataAsli = DB::table('transaksi')
            ->where('siswa_id', $this->siswa->id)
            ->whereMonth('created_at', $this->bulan)
            ->whereYear('created_at', $this->tahun)
            ->orderBy('created_at', 'ASC')
            ->get();

        if ($dataAsli->isEmpty()) {
            $this->isDataEmpty = true;
            return collect([]);
        }

        return $dataAsli;
    }

    public function title(): string
    {
        return substr($this->siswa->nama, 0, 20);
    }

    public function headings(): array
    {
        return [
            'No', 
            'Hari', 
            'Tanggal Transaksi', 
            'Keterangan Mutasi', 
            'Jumlah Nabung (Setor)', 
            'Jumlah Pengeluaran (Tarik)'
        ];
    }

    public function columnFormats(): array
    {
        return [
            'C' => '@', 
            'E' => '"Rp "#,##0',
            'F' => '"Rp "#,##0',
        ];
    }

    public function map($transaksi): array
    {
        $this->rowNumber++;
        
        $hariInggris = date('l', strtotime($transaksi->created_at));
        $daftarHari = [
            'Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'
        ];
        $hariIndo = $daftarHari[$hariInggris] ?? $hariInggris;

        // Ambil nominal angka
        $nominal = (int)$transaksi->jumlah;

        // 🚀 HITUNG MANUAL DI PHP: Sambil looping berjalan, nominal langsung kita akumulasikan
        if ($transaksi->jenis == 'setor') {
            $this->totalSetorPHP += $nominal;
            $setorCetak = $nominal;
            $tarikCetak = 0;
        } else {
            $this->totalTarikPHP += $nominal;
            $setorCetak = 0;
            $tarikCetak = $nominal;
        }

        return [
            $this->rowNumber, 
            $hariIndo, 
            date('d-m-Y H:i', strtotime($transaksi->created_at)), 
            strtoupper($transaksi->jenis == 'setor' ? 'SETOR TABUNGAN' : 'TARIK TABUNGAN'), 
            $setorCetak, 
            $tarikCetak, 
        ];
    }

    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function(BeforeSheet $event) {
                $sheet = $event->sheet->getDelegate();
                
                $sheet->setCellValue('A1', 'LAPORAN MUTASI TABUNGAN HARIAN SISWA');
                $sheet->mergeCells('A1:F1');

                $sheet->setCellValue('A2', 'Nama Siswa : ' . $this->siswa->nama);
                $sheet->mergeCells('A2:F2');
                
                $sheet->setCellValue('A3', 'NISN             : ' . $this->siswa->nisn);
                $sheet->mergeCells('A3:F3');
                
                $sheet->setCellValue('A4', '');
            },
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1')->getFont()->setSize(14)->setBold(true);
        $sheet->getStyle('A2:A3')->getFont()->setSize(11)->setBold(true);

        $sheet->getStyle('A5:F5')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '0284C7'] 
            ],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]
        ]);

        $highestRow = $sheet->getHighestRow();
        
        if ($this->isDataEmpty) {
            $sheet->setCellValue('A6', 'Belum ada data transaksi pada bulan ini.');
            $sheet->mergeCells('A6:F6');
            $sheet->getStyle('A6')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A6')->getFont()->setItalic(true);

            $totalRow = 7;
            $sheet->mergeCells("A{$totalRow}:D{$totalRow}");
            $sheet->setCellValue("A{$totalRow}", "TOTAL MUTASI BULANAN ANAK");
            
            $sheet->setCellValue("E{$totalRow}", 0);
            $sheet->setCellValue("F{$totalRow}", 0);
            
            $highestRow = 6; 
        } else {
            // 🚀 BYPASS RUMUS: Jika ada datanya, kita langsung cetak hasil hitungan variabel PHP tadi!
            $totalRow = $highestRow + 1;
            $sheet->mergeCells("A{$totalRow}:D{$totalRow}");
            $sheet->setCellValue("A{$totalRow}", "TOTAL MUTASI BULANAN ANAK");
            
            // Masukkan hasil hitungan variabel PHP secara mutlak
            $sheet->setCellValue("E{$totalRow}", $this->totalSetorPHP);
            $sheet->setCellValue("F{$totalRow}", $this->totalTarikPHP);
        }

        // Style Baris Total Bawah
        $sheet->getStyle("A{$totalRow}:F{$totalRow}")->applyFromArray([
            'font' => ['bold' => true],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'F0FDF4'] 
            ]
        ]);
        
        $sheet->getStyle("A{$totalRow}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("E{$totalRow}:F{$totalRow}")->getNumberFormat()->setFormatCode('"Rp "#,##0');

        $sheet->getStyle("A6:C{$totalRow}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        
        if (!$this->isDataEmpty) {
            $sheet->getStyle("D6:D{$highestRow}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        }
        
        $sheet->getStyle("A5:F{$totalRow}")->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    }
}