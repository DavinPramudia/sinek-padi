<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class LaporanTransaksiExport implements FromArray, WithStyles, WithEvents
{
    protected $transaksi;
    protected $labelPeriode;
    protected $filterType;
    protected $headerRows = [];

    public function __construct($transaksi, $labelPeriode, $filterType = 'harian')
    {
        $this->transaksi = $transaksi;
        $this->labelPeriode = $labelPeriode;
        $this->filterType = $filterType;
    }

    public function array(): array
    {
        $rows = [
            ['LAPORAN REKAPITULASI TRANSAKSI SINEK-PADI', '', '', '', '', '', '', '', ''],
            ['Periode Laporan', ': ' . strtoupper($this->labelPeriode), '', '', '', '', '', '', ''],
            ['Tanggal Cetak', ': ' . date('d F Y H:i') . ' WIB', '', '', '', '', '', '', ''],
            ['', '', '', '', '', '', '', '', ''], 
        ];

        // Jika filter mingguan aktif, kita tambahkan tabel ringkasan ritme harian di bagian atas
        if ($this->filterType === 'mingguan') {
            $this->headerRows[] = count($rows) + 1;
            $rows[] = ['RINGKASAN ANALISIS RITME JAM PER HARI (MINGGU INI)', '', '', '', '', '', '', '', ''];
            
            $this->headerRows[] = count($rows) + 1;
            $rows[] = ['Hari / Tanggal', 'Total Transaksi', 'Jam Terramai (Peak)', 'Jam Normal', 'Jam Tersepi', '', '', '', ''];

            $groupedByDay = $this->transaksi->groupBy(function($item) {
                return \Carbon\Carbon::parse($item->waktu)->translatedFormat('D, d M Y');
            });

            foreach ($groupedByDay as $hariLabel => $itemsHari) {
                $distribusiJam = $itemsHari->groupBy(function($item) {
                    return \Carbon\Carbon::parse($item->waktu)->format('H');
                });

                $jamTerramai = '-';
                $jamNormal = '-';
                $jamTersepi = '-';

                if ($distribusiJam->isNotEmpty()) {
                    $sorted = $distribusiJam->sortByDesc(fn($g) => $g->count());
                    $terramaiObj = $sorted->keys()->first();
                    $jamTerramai = $terramaiObj !== null ? $terramaiObj . ':00 - ' . str_pad((int)$terramaiObj + 1, 2, '0', STR_PAD_LEFT) . ':00' : '-';

                    $tersepiObj = $sorted->keys()->last();
                    $jamTersepi = $tersepiObj !== null ? $tersepiObj . ':00 - ' . str_pad((int)$tersepiObj + 1, 2, '0', STR_PAD_LEFT) . ':00' : '-';

                    $keys = $sorted->keys()->values()->all();
                    $midKey = count($keys) >= 2 ? $keys[floor(count($keys) / 2)] : $terramaiObj;
                    $jamNormal = $midKey !== null ? $midKey . ':00 - ' . str_pad((int)$midKey + 1, 2, '0', STR_PAD_LEFT) . ':00' : '-';
                }

                $rows[] = [
                    $hariLabel,
                    $itemsHari->count() . ' Transaksi',
                    $jamTerramai,
                    $jamNormal,
                    $jamTersepi,
                    '', '', '', ''
                ];
            }

            $rows[] = ['', '', '', '', '', '', '', '', ''];
            $rows[] = ['', '', '', '', '', '', '', '', ''];
        }

        // Judul untuk Tabel Detail Transaksi Utama
        $this->headerRows[] = count($rows) + 1;
        $rows[] = ['DETAIL RINCIAN SELURUH TRANSAKSI', '', '', '', '', '', '', '', ''];

        $this->headerRows[] = count($rows) + 1;
        $rows[] = ['No', 'No Tiket', 'Waktu', 'Kategori Kendaraan', 'Lokal', 'Nusantara', 'Mancanegara', 'Total Bayar', 'Petugas'];

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

            $rows[] = [
                $index + 1,
                $item->no_karcis ?? $item->no_tiket ?? '-',
                \Carbon\Carbon::parse($item->waktu)->format('d-m-Y H:i'),
                optional($item->tarif->kendaraan)->nama_kendaraan ?? 'Mobil/Motor',
                $lokal,
                $nusantara,
                $mancanegara,
                $totalBayar,
                optional($item->user)->name ?? 'Petugas'
            ];
        }

        // Baris Kosong Pemisah
        $rows[] = ['', '', '', '', '', '', '', '', ''];

        // Baris Total Keseluruhan
        $rows[] = [
            'JUMLAH KESELURUHAN', '', '', '',
            $totalLokal,
            $totalNusantara,
            $totalMancanegara,
            $totalBayarSemua,
            ''
        ];

        return $rows;
    }

    public function styles(Worksheet $sheet)
    {
        $styles = [
            1 => ['font' => ['bold' => true, 'size' => 14, 'color' => ['argb' => '243733']]], 
            2 => ['font' => ['bold' => true]],            
            3 => ['font' => ['italic' => true, 'color' => ['argb' => '555555']]],            
        ];

        // Terapkan warna hijau gelap SINEK-PADI secara presisi ke semua baris header yang dicatat
        foreach ($this->headerRows as $row) {
            $styles[$row] = [
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => 'solid', 
                    'startColor' => ['argb' => '243733']
                ]
            ];
        }

        return $styles;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                
                // 1. Tampilkan garis gridlines
                $sheet->setShowGridlines(true);

                // 2. Set Landscape & Fit to 1 page wide (Pas 1 lembar saat diprint)
                $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
                $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
                $sheet->getPageSetup()->setFitToWidth(1);
                $sheet->getPageSetup()->setFitToHeight(0);
                $sheet->getPageSetup()->setFitToPage(true);

                // 3. Beri Border Tipis ke seluruh sel data
                $highestRow = $sheet->getHighestRow();
                $sheet->getStyle("A1:I{$highestRow}")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => 'CCCCCC'],
                        ],
                    ],
                ]);

                // 4. Lebar kolom proporsional agar rapi
                $columnWidths = [
                    'A' => 18,  // No / Hari
                    'B' => 18,  // No Tiket / Total Transaksi
                    'C' => 18,  // Waktu / Jam Terramai
                    'D' => 22,  // Kategori / Jam Normal
                    'E' => 14,  // Lokal / Jam Tersepi
                    'F' => 14,  // Nusantara
                    'G' => 14,  // Mancanegara
                    'H' => 20,  // Total Bayar
                    'I' => 18,  // Petugas
                ];

                foreach ($columnWidths as $col => $width) {
                    $sheet->getColumnDimension($col)->setWidth($width);
                }
            },
        ];
    }
}