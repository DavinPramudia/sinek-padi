<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DashboardExport implements FromArray, WithStyles, WithEvents
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        $rows = [
            ['LAPORAN REKAPITULASI DASHBOARD SINEK-PADI'],
            ['Periode Laporan', $this->data['labelPeriode']],
            [''], 
            
            // 1. Ringkasan Utama
            ['-- RINGKASAN UTAMA --', '', '', '', '', '', ''],
            ['Total Pendapatan', 'Rp ' . number_format($this->data['totalPendapatan'], 0, ',', '.'), '', '', '', '', ''],
            ['Total Kendaraan', $this->data['totalKendaraan'] . ' Unit', '', '', '', '', ''],
            ['Total Wisatawan', $this->data['totalWisatawan'] . ' Orang', '', '', '', '', ''],
            [''],

            // 2. Sensus Wisatawan
            ['-- DETAIL SENSUS WISATAWAN --', '', '', '', '', '', ''],
            ['Wisatawan Lokal', $this->data['wisatawanLokal'] . ' Orang', '', '', '', '', ''],
            ['Wisatawan Nusantara', $this->data['wisatawanNusantara'] . ' Orang', '', '', '', '', ''],
            ['Wisatawan Mancanegara', $this->data['wisatawanMancanegara'] . ' Orang', '', '', '', '', ''],
            [''],

            // 3. Kategori Kendaraan
            ['-- KATEGORI KENDARAAN --', '', '', '', '', '', ''],
            ['Motor', $this->data['kendaraanMotor'] . ' Unit', '', '', '', '', ''],
            ['Mobil', $this->data['kendaraanMobil'] . ' Unit', '', '', '', '', ''],
            [''],
        ];

        // 4. Jika filter tahunan, tampilkan tabel rincian lengkap per bulan (7 Kolom)
        if (!empty($this->data['rincianBulanan'])) {
            $rows[] = ['-- RINCIAN SENSUS & KENDARAAN PER BULAN --', 'Motor', 'Mobil', 'Lokal', 'Nusantara', 'Mancanegara', 'Total Pendapatan'];
            
            foreach ($this->data['rincianBulanan'] as $item) {
                $rows[] = [
                    $item['bulan'], 
                    $item['motor'] . ' Unit', 
                    $item['mobil'] . ' Unit', 
                    $item['lokal'] . ' Orang', 
                    $item['nusantara'] . ' Orang', 
                    $item['mancanegara'] . ' Orang', 
                    'Rp ' . number_format($item['pendapatan'], 0, ',', '.')
                ];
            }
        } else {
            $rows[] = ['-- TREN KUNJUNGAN (' . strtoupper($this->data['satuanWaktu']) . ') --', 'Jumlah Pengunjung', '', '', '', '', ''];
            foreach ($this->data['labelsGrafik'] as $index => $label) {
                $jumlah = $this->data['trenKunjungan'][$index] ?? 0;
                $rows[] = [$label, $jumlah . ' Pengunjung', '', '', '', '', ''];
            }
        }

        return $rows;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 14]], 
            2 => ['font' => ['italic' => true]],            
            4 => ['font' => ['bold' => true, 'color' => ['argb' => 'FFFFFF']], 'fill' => ['fillType' => 'solid', 'startColor' => ['argb' => '243733']]],
            9 => ['font' => ['bold' => true, 'color' => ['argb' => 'FFFFFF']], 'fill' => ['fillType' => 'solid', 'startColor' => ['argb' => '243733']]],
            14 => ['font' => ['bold' => true, 'color' => ['argb' => 'FFFFFF']], 'fill' => ['fillType' => 'solid', 'startColor' => ['argb' => '243733']]],
            18 => ['font' => ['bold' => true, 'color' => ['argb' => 'FFFFFF']], 'fill' => ['fillType' => 'solid', 'startColor' => ['argb' => '243733']]],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                
                foreach (['A', 'B', 'C', 'D', 'E', 'F', 'G'] as $column) {
                    $sheet->getColumnDimension($column)->setAutoSize(true);
                }
            },
        ];
    }
}