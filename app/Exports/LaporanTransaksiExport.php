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
        
        $totalLokal = 0;
        $totalNusantara = 0;
        $totalMancanegara = 0;
        $totalBayarSemua = 0;

        foreach ($this->transaksi as $index => $item) {
            $sensusParts = explode(' / ', $item->sensus_rangkuman ?? '0 / 0 / 0');
            
            $lokal = (int) ($sensusParts[0] ?? 0);
            $nusantara = (int) ($sensusParts[1] ?? 0);
            $mancanegara = (int) ($sensusParts[2] ?? 0);
            $totalBayar = (float) ($item->total_bayar ?? 0);

            $totalLokal += $lokal;
            $totalNusantara += $nusantara;
            $totalMancanegara += $mancanegara;
            $totalBayarSemua += $totalBayar;

            $rows->push([
                'no' => $index + 1,
                'no_tiket' => $item->no_karcis ?? $item->no_tiket ?? '-',
                'waktu' => \Carbon\Carbon::parse($item->waktu)->format('d-m-Y H:i'),
                'kategori' => optional($item->tarif->kendaraan)->nama_kendaraan ?? 'Mobil/Motor',
                'lokal' => $lokal,
                'nusantara' => $nusantara,
                'mancanegara' => $mancanegara,
                'total_bayar' => $totalBayar,
                'petugas' => optional($item->user)->name ?? 'Petugas'
            ]);
        }

        // Baris Kosong Pemisah
        $rows->push([
            'no' => '', 'no_tiket' => '', 'waktu' => '', 'kategori' => '',
            'lokal' => '', 'nusantara' => '', 'mancanegara' => '', 'total_bayar' => '', 'petugas' => ''
        ]);

        // Baris Total Keseluruhan
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
        // Hitung total baris data agar format dinamis dan tidak terpaku angka 5000
        $totalRow = count($this->transaksi) + 4; // Header 2 baris + data + baris kosong + baris jumlah

        // Format angka jumlah orang (Kolom E, F, G)
        $sheet->getStyle('E3:G' . $totalRow)->getNumberFormat()->setFormatCode('#,##0');
        
        // Format angka total bayar Rupiah (Kolom H)
        $sheet->getStyle('H3:H' . $totalRow)->getNumberFormat()->setFormatCode('"Rp "#,##0');

        return [
            1 => ['font' => ['bold' => true, 'size' => 13]], 
            2 => [
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFF']], 
                'fill' => ['fillType' => 'solid', 'startColor' => ['argb' => '243733']]
            ],
            // Styling khusus untuk baris "JUMLAH" di paling bawah
            $totalRow => [
                'font' => ['bold' => true],
                'fill' => ['fillType' => 'solid', 'startColor' => ['argb' => 'E2E8F0']] // Warna abu-abu soft elegan
            ]
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $sheet->mergeCells('A1:I1');
                
                foreach (range('A', 'I') as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }
            },
        ];
    }
}