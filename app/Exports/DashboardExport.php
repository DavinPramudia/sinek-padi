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
        $filterType = $this->data['filterType'] ?? 'harian';

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

        // 4. Rincian Data Berdasarkan Filter Type
        if (!empty($this->data['rincianBulanan'])) {
            
            // Tentukan Judul Tabel Dinamis Berdasarkan Filter
            if ($filterType === 'mingguan') {
                $judulRincian = '-- ANALISIS RITME KUNJUNGAN PER HARI (MINGGU INI) --';
                // Header khusus mingguan yang memuat info Jam Terramai, Normal, Tersepi
                $rows[] = [$judulRincian, 'Motor', 'Mobil', 'Lokal', 'Nusantara', 'Manca', 'Jam Terramai', 'Jam Normal', 'Jam Tersepi', 'Pendapatan'];
                
                foreach ($this->data['rincianBulanan'] as $item) {
                    $rows[] = [
                        $item['bulan'], // Hari (Cth: Sen, 05 Okt)
                        ($item['motor'] ?? 0) . ' Unit', 
                        ($item['mobil'] ?? 0) . ' Unit', 
                        ($item['lokal'] ?? 0) . ' Orang', 
                        ($item['nusantara'] ?? 0) . ' Orang', 
                        ($item['mancanegara'] ?? 0) . ' Orang', 
                        $item['jam_terramai'] ?? '-',
                        $item['jam_normal'] ?? '-',
                        $item['jam_tersepi'] ?? '-',
                        'Rp ' . number_format($item['pendapatan'] ?? 0, 0, ',', '.')
                    ];
                }
            } else {
                // Format untuk Bulanan, Triwulanan, Tahunan
                if ($filterType === 'triwulanan') {
                    $judulRincian = '-- RINCIAN SENSUS & KENDARAAN PERIODE TRIWULAN --';
                } elseif ($filterType === 'tahunan') {
                    $judulRincian = '-- RINCIAN SENSUS & KENDARAAN PERIODE TAHUNAN --';
                } else {
                    $judulRincian = '-- RINCIAN SENSUS & KENDARAAN HARIAN (BULANAN) --';
                }

                $rows[] = [$judulRincian, 'Motor', 'Mobil', 'Lokal', 'Nusantara', 'Mancanegara', 'Total Pendapatan'];
                
                foreach ($this->data['rincianBulanan'] as $item) {
                    $rows[] = [
                        $item['bulan'], 
                        ($item['motor'] ?? 0) . ' Unit', 
                        ($item['mobil'] ?? 0) . ' Unit', 
                        ($item['lokal'] ?? 0) . ' Orang', 
                        ($item['nusantara'] ?? 0) . ' Orang', 
                        ($item['mancanegara'] ?? 0) . ' Orang', 
                        'Rp ' . number_format($item['pendapatan'] ?? 0, 0, ',', '.')
                    ];
                }
            }
        } else {
            // Fallback cadangan jika data rincian kosong
            $rows[] = ['-- TREN KUNJUNGAN (' . strtoupper($this->data['satuanWaktu'] ?? 'WAKTU') . ') --', 'Jumlah Pengunjung', '', '', '', '', ''];
            if (!empty($this->data['labelsGrafik'])) {
                foreach ($this->data['labelsGrafik'] as $index => $label) {
                    $jumlah = $this->data['trenKunjungan'][$index] ?? 0;
                    $rows[] = [$label, $jumlah . ' Pengunjung', '', '', '', '', ''];
                }
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
                
                // Lebarkan rentang kolom agar muat sampai kolom J jika mode mingguan aktif
                foreach (['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'] as $column) {
                    $sheet->getColumnDimension($column)->setAutoSize(true);
                }
            },
        ];
    }
}