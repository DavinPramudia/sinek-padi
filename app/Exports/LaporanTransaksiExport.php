<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Collection;

class LaporanTransaksiExport implements FromCollection, WithHeadings, WithStyles, WithEvents
{
    protected $transaksi;
    protected $labelPeriode;

    public function __construct($transaksi, $labelPeriode)
    {
        $this->transaksi = $transaksi;
        $this->labelPeriode = $labelPeriode;
    }

    public function collection()
    {
        $rows = new Collection();
        
        // 1. Variabel untuk menampung total
        $totalLokal = 0;
        $totalNusantara = 0;
        $totalMancanegara = 0;
        $totalBayarSemua = 0;

        // 2. Masukkan data transaksi satu per satu
        foreach ($this->transaksi as $index => $item) {
            $sensusParts = explode(' / ', $item->sensus_rangkuman ?? '0 / 0 / 0');
            
            $lokal = (int) ($sensusParts[0] ?? 0);
            $nusantara = (int) ($sensusParts[1] ?? 0);
            $mancanegara = (int) ($sensusParts[2] ?? 0);
            $totalBayar = (float) ($item->total_bayar ?? 0);

            // Akumulasi total
            $totalLokal += $lokal;
            $totalNusantara += $nusantara;
            $totalMancanegara += $mancanegara;
            $totalBayarSemua += $totalBayar;

            $rows->push([
                'no' => $index + 1,
                'no_tiket' => $item->no_karcis ?? $item->no_tiket ?? '-',
                'waktu' => \Carbon\Carbon::parse($item->waktu)->format('d-m-Y H:i'),
                'kategori' => $item->kategori_kendaraan ?? 'Mobil/Motor',
                'lokal' => $lokal,
                'nusantara' => $nusantara,
                'mancanegara' => $mancanegara,
                'total_bayar' => $totalBayar,
                'petugas' => optional($item->user)->name ?? 'Petugas'
            ]);
        }

        // 3. Tambahkan 1 baris kosong sebagai jarak
        $rows->push([
            'no' => '', 'no_tiket' => '', 'waktu' => '', 'kategori' => '',
            'lokal' => '', 'nusantara' => '', 'mancanegara' => '', 'total_bayar' => '', 'petugas' => ''
        ]);

        // 4. Tambahkan baris JUMLAH di bawahnya
        $rows->push([
            'no' => 'JUMLAH', 
            'no_tiket' => '', 
            'waktu' => '', 
            'kategori' => '',
            'lokal' => $totalLokal,
            'nusantara' => $totalNusantara,
            'mancanegara' => $totalMancanegara,
            'total_bayar' => $totalBayarSemua,
            'petugas' => ''
        ]);

        return $rows;
    }

    public function headings(): array
    {
        return [
            ['Laporan Transaksi - ' . $this->labelPeriode], 
            ['No', 'No Tiket', 'Waktu', 'Kategori', 'Lokal', 'Nusantara', 'Mancanegara', 'Total Bayar', 'Petugas']
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Format angka "0" untuk kolom Lokal, Nusantara, Mancanegara
        $sheet->getStyle('E3:G5000')->getNumberFormat()->setFormatCode('0');

        return [
            1 => ['font' => ['bold' => true]], 
            2 => [
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFF']], 
                'fill' => ['fillType' => 'solid', 'startColor' => ['argb' => '243733']]
            ]
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                
                // Merge baris judul utama
                $sheet->mergeCells('A1:I1');
                
                // Auto-fit kolom
                foreach (range('A', 'I') as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }
            },
        ];
    }
}