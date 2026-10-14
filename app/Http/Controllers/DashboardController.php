<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DashboardExport;

class DashboardController extends Controller
{
    private function getDashboardData(Request $request)
    {
        $filterType = $request->input('filter_type', 'harian');

        $transaksiQuery = Transaksi::with(['details.kategoriWisatawan', 'tarif.kendaraan'])
                                   ->filter($request);

        // Ambil semua data transaksi yang sesuai filter
        $transaksiList = $transaksiQuery->get();

        // Data Statistik Atas
        $totalPendapatan = $transaksiList->sum('total_bayar');
        $totalKendaraan = $transaksiList->count();

        // Sensus Wisatawan & Kendaraan
        $totalWisatawan = 0;
        $wisatawanLokal = 0;
        $wisatawanNusantara = 0;
        $wisatawanMancanegara = 0;

        $kendaraanMotor = 0;
        $kendaraanMobil = 0;

        foreach ($transaksiList as $item) {
            $sensusParts = explode(' / ', $item->sensus_rangkuman ?? '0 / 0 / 0');
            $l = (int) ($sensusParts[0] ?? 0);
            $n = (int) ($sensusParts[1] ?? 0);
            $m = (int) ($sensusParts[2] ?? 0);

            $wisatawanLokal += $l;
            $wisatawanNusantara += $n;
            $wisatawanMancanegara += $m;
            $totalWisatawan += ($l + $n + $m);

            $namaKendaraan = strtolower(optional($item->tarif->kendaraan)->nama_kendaraan ?? '');
            if (str_contains($namaKendaraan, 'motor')) {
                $kendaraanMotor++;
            } elseif (str_contains($namaKendaraan, 'mobil')) {
                $kendaraanMobil++;
            }
        }

        // Data Tren Kunjungan & Rincian Periode
        $trenKunjungan = [];
        $labelsGrafik = [];
        $rincianBulanan = [];

        if ($filterType == 'bulanan' && $request->filled('bulan')) {
            $tahunBulan = explode('-', $request->bulan);
            $jumlahHari = Carbon::create($tahunBulan[0], $tahunBulan[1])->daysInMonth;
            
            $groupedByDate = $transaksiList->groupBy(function($item) {
                return Carbon::parse($item->waktu)->format('Y-m-d');
            });

            for ($hari = 1; $hari <= $jumlahHari; $hari++) {
                $tanggalLengkap = $request->bulan . '-' . str_pad($hari, 2, '0', STR_PAD_LEFT);
                $transaksiHariList = $groupedByDate->get($tanggalLengkap, collect());
                
                $totalPendapatanHari = $transaksiHariList->sum('total_bayar');
                $jumlahTransaksiHari = $transaksiHariList->count();

                $lokalHari = 0; $nusantaraHari = 0; $mancanegaraHari = 0;
                $motorHari = 0; $mobilHari = 0;

                foreach ($transaksiHariList as $item) {
                    $sensusParts = explode(' / ', $item->sensus_rangkuman ?? '0 / 0 / 0');
                    $lokalHari += (int) ($sensusParts[0] ?? 0);
                    $nusantaraHari += (int) ($sensusParts[1] ?? 0);
                    $mancanegaraHari += (int) ($sensusParts[2] ?? 0);

                    $namaKendaraan = strtolower(optional($item->tarif->kendaraan)->nama_kendaraan ?? '');
                    if (str_contains($namaKendaraan, 'motor')) {
                        $motorHari++;
                    } elseif (str_contains($namaKendaraan, 'mobil')) {
                        $mobilHari++;
                    }
                }

                $formatTanggalLabel = Carbon::create($tahunBulan[0], $tahunBulan[1], $hari)->translatedFormat('d M Y');

                $trenKunjungan[] = $jumlahTransaksiHari;
                $labelsGrafik[] = (string) $hari;

                $rincianBulanan[] = [
                    'bulan' => $formatTanggalLabel,
                    'motor' => $motorHari,
                    'mobil' => $mobilHari,
                    'lokal' => $lokalHari,
                    'nusantara' => $nusantaraHari,
                    'mancanegara' => $mancanegaraHari,
                    'pendapatan' => $totalPendapatanHari
                ];
            }
        } 
        elseif ($filterType == 'mingguan') {
            $inputMinggu = $request->input('minggu', date('Y-\WW'));
            if (str_contains($inputMinggu, '-W')) {
                [$tahunMinggu, $weekNumber] = explode('-W', $inputMinggu);
            } else {
                $tahunMinggu = date('Y');
                $weekNumber = date('W');
            }

            $startOfWeek = Carbon::now()->setISODate($tahunMinggu, $weekNumber)->startOfWeek();
            $endOfWeek = Carbon::now()->setISODate($tahunMinggu, $weekNumber)->endOfWeek();

            $groupedByDate = $transaksiList->groupBy(function($item) {
                return Carbon::parse($item->waktu)->format('Y-m-d');
            });

            $currentDate = $startOfWeek->copy();
            while ($currentDate <= $endOfWeek) {
                $tanggalStr = $currentDate->format('Y-m-d');
                $transaksiHariList = $groupedByDate->get($tanggalStr, collect());
                
                $totalPendapatanHari = $transaksiHariList->sum('total_bayar');
                $jumlahTransaksiHari = $transaksiHariList->count();

                $lokalHari = 0; $nusantaraHari = 0; $mancanegaraHari = 0;
                $motorHari = 0; $mobilHari = 0;

                foreach ($transaksiHariList as $item) {
                    $sensusParts = explode(' / ', $item->sensus_rangkuman ?? '0 / 0 / 0');
                    $lokalHari += (int) ($sensusParts[0] ?? 0);
                    $nusantaraHari += (int) ($sensusParts[1] ?? 0);
                    $mancanegaraHari += (int) ($sensusParts[2] ?? 0);

                    $namaKendaraan = strtolower(optional($item->tarif->kendaraan)->nama_kendaraan ?? '');
                    if (str_contains($namaKendaraan, 'motor')) {
                        $motorHari++;
                    } elseif (str_contains($namaKendaraan, 'mobil')) {
                        $mobilHari++;
                    }
                }

                // Analisis Ritme Jam Per Hari (Terramai, Normal, Tersepi)
                $distribusiJamHari = $transaksiHariList->groupBy(function($item) {
                    return Carbon::parse($item->waktu)->format('H');
                });

                $jamTerramai = '-';
                $jamNormal = '-';
                $jamTersepi = '-';

                if ($distribusiJamHari->isNotEmpty()) {
                    $sortedByCount = $distribusiJamHari->sortByDesc(function ($groupedItems) {
                        return $groupedItems->count();
                    });

                    $jamTerramaiObj = $sortedByCount->keys()->first();
                    $jamTerramai = $jamTerramaiObj !== null ? $jamTerramaiObj . ':00 - ' . str_pad((int)$jamTerramaiObj + 1, 2, '0', STR_PAD_LEFT) . ':00' : '-';

                    $jamTersepiObj = $sortedByCount->keys()->last();
                    $jamTersepi = $jamTersepiObj !== null ? $jamTersepiObj . ':00 - ' . str_pad((int)$jamTersepiObj + 1, 2, '0', STR_PAD_LEFT) . ':00' : '-';

                    $keysArray = $sortedByCount->keys()->values()->all();
                    if (count($keysArray) >= 2) {
                        $midKey = $keysArray[floor(count($keysArray) / 2)];
                        $jamNormal = $midKey . ':00 - ' . str_pad((int)$midKey + 1, 2, '0', STR_PAD_LEFT) . ':00';
                    } else {
                        $jamNormal = $jamTerramai;
                    }
                }

                $namaHariLabel = $currentDate->translatedFormat('D, d M');

                $trenKunjungan[] = $jumlahTransaksiHari;
                $labelsGrafik[] = $namaHariLabel;

                $rincianBulanan[] = [
                    'bulan' => $namaHariLabel,
                    'motor' => $motorHari,
                    'mobil' => $mobilHari,
                    'lokal' => $lokalHari,
                    'nusantara' => $nusantaraHari,
                    'mancanegara' => $mancanegaraHari,
                    'pendapatan' => $totalPendapatanHari,
                    'jam_terramai' => $jamTerramai,
                    'jam_normal' => $jamNormal,
                    'jam_tersepi' => $jamTersepi
                ];

                $currentDate->addDay();
            }
        }
        elseif ($filterType == 'tahunan' && $request->filled('tahun')) {
            $groupedByMonth = $transaksiList->groupBy(function($item) {
                return (int) Carbon::parse($item->waktu)->format('n');
            });

            for ($bulan = 1; $bulan <= 12; $bulan++) {
                $transaksiBulanList = $groupedByMonth->get($bulan, collect());
                
                $totalPendapatanBulan = $transaksiBulanList->sum('total_bayar');
                $jumlahTransaksi = $transaksiBulanList->count();

                $lokalBulan = 0; $nusantaraBulan = 0; $mancanegaraBulan = 0;
                $motorBulan = 0; $mobilBulan = 0;

                foreach ($transaksiBulanList as $item) {
                    $sensusParts = explode(' / ', $item->sensus_rangkuman ?? '0 / 0 / 0');
                    $lokalBulan += (int) ($sensusParts[0] ?? 0);
                    $nusantaraBulan += (int) ($sensusParts[1] ?? 0);
                    $mancanegaraBulan += (int) ($sensusParts[2] ?? 0);

                    $namaKendaraan = strtolower(optional($item->tarif->kendaraan)->nama_kendaraan ?? '');
                    if (str_contains($namaKendaraan, 'motor')) {
                        $motorBulan++;
                    } elseif (str_contains($namaKendaraan, 'mobil')) {
                        $mobilBulan++;
                    }
                }
                
                $namaBulan = Carbon::create(null, $bulan)->translatedFormat('F');
                
                $trenKunjungan[] = $jumlahTransaksi;
                $labelsGrafik[] = $namaBulan;

                $rincianBulanan[] = [
                    'bulan' => $namaBulan,
                    'motor' => $motorBulan,
                    'mobil' => $mobilBulan,
                    'lokal' => $lokalBulan,
                    'nusantara' => $nusantaraBulan,
                    'mancanegara' => $mancanegaraBulan,
                    'pendapatan' => $totalPendapatanBulan
                ];
            }
        } 
        elseif ($filterType == 'triwulanan') {
            $triwulanan = $request->input('triwulan', 1);
            $tahun = $request->input('tahun_triwulan', date('Y'));

            $bulanMulai = (($triwulanan - 1) * 3) + 1;
            $bulanSelesai = $bulanMulai + 2;

            $groupedByMonth = $transaksiList->groupBy(function($item) {
                return (int) Carbon::parse($item->waktu)->format('n');
            });

            for ($bulan = $bulanMulai; $bulan <= $bulanSelesai; $bulan++) {
                $transaksiBulanList = $groupedByMonth->get($bulan, collect());
                
                $totalPendapatanBulan = $transaksiBulanList->sum('total_bayar');
                $jumlahTransaksi = $transaksiBulanList->count();

                $lokalBulan = 0; $nusantaraBulan = 0; $mancanegaraBulan = 0;
                $motorBulan = 0; $mobilBulan = 0;

                foreach ($transaksiBulanList as $item) {
                    $sensusParts = explode(' / ', $item->sensus_rangkuman ?? '0 / 0 / 0');
                    $lokalBulan += (int) ($sensusParts[0] ?? 0);
                    $nusantaraBulan += (int) ($sensusParts[1] ?? 0);
                    $mancanegaraBulan += (int) ($sensusParts[2] ?? 0);

                    $namaKendaraan = strtolower(optional($item->tarif->kendaraan)->nama_kendaraan ?? '');
                    if (str_contains($namaKendaraan, 'motor')) {
                        $motorBulan++;
                    } elseif (str_contains($namaKendaraan, 'mobil')) {
                        $mobilBulan++;
                    }
                }

                $namaBulan = Carbon::create(null, $bulan)->translatedFormat('F');

                $trenKunjungan[] = $jumlahTransaksi;
                $labelsGrafik[] = $namaBulan;

                $rincianBulanan[] = [
                    'bulan' => $namaBulan,
                    'motor' => $motorBulan,
                    'mobil' => $mobilHari ?? 0,
                    'lokal' => $lokalBulan,
                    'nusantara' => $nusantaraBulan,
                    'mancanegara' => $mancanegaraBulan,
                    'pendapatan' => $totalPendapatanBulan
                ];
            }
        }
        else {
            for ($jam = 6; $jam <= 21; $jam++) {
                $jumlah = (clone $transaksiQuery)->whereRaw('HOUR(waktu) = ?', [$jam])->count();
                $trenKunjungan[] = $jumlah;
                $labelsGrafik[] = str_pad($jam, 2, '0', STR_PAD_LEFT) . ':00';
            }
        }

        // Label Periode & Konfigurasi Chart
        $labelPeriode = match ($filterType) {
            'bulanan' => $request->filled('bulan') ? Carbon::createFromFormat('Y-m', $request->bulan)->translatedFormat('F Y') : 'Bulan Ini',
            'mingguan' => (function() use ($request) {
                $inputMinggu = $request->input('minggu', date('Y-\WW'));
                if (str_contains($inputMinggu, '-W')) {
                    [$thn, $wk] = explode('-W', $inputMinggu);
                } else {
                    $thn = date('Y'); $wk = date('W');
                }
                $start = Carbon::now()->setISODate($thn, $wk)->startOfWeek()->translatedFormat('d M Y');
                $end = Carbon::now()->setISODate($thn, $wk)->endOfWeek()->translatedFormat('d M Y');
                return "Minggu Ke-{$wk} ({$start} - {$end})";
            })(),
            'tahunan' => 'Tahun ' . $request->input('tahun', date('Y')),
            'triwulanan' => (function() use ($request) {
                $t = $request->input('triwulan', 1);
                $thn = $request->input('tahun_triwulan', date('Y'));
                $namaBulan = match ((int)$t) {
                    1 => 'Januari - Maret',
                    2 => 'April - Juni',
                    3 => 'Juli - September',
                    4 => 'Oktober - Desember',
                    default => ''
                };
                return "Tribulan {$t} ({$namaBulan}) {$thn}";
            })(),
            default => Carbon::parse($request->input('tanggal', date('Y-m-d')))->translatedFormat('d M Y'),
        };

        $satuanWaktu = match ($filterType) {
            'bulanan' => 'Perhari',
            'mingguan' => 'Perhari (Senin - Minggu)',
            'tahunan', 'triwulanan' => 'Perbulan',
            default => 'Perjam',
        };

        $chartConfig = match ($filterType) {
            'bulanan' => ['max' => 300, 'step' => 50],
            'mingguan' => ['max' => 200, 'step' => 40],
            'tahunan' => ['max' => 10000, 'step' => 1000],
            'triwulanan' => ['max' => 3000, 'step' => 500],
            default => ['max' => 50, 'step' => 10],
        };

        return compact(
            'filterType', 'totalPendapatan', 'totalKendaraan', 'totalWisatawan',
            'wisatawanLokal', 'wisatawanNusantara', 'wisatawanMancanegara',
            'kendaraanMotor', 'kendaraanMobil', 'trenKunjungan', 'labelsGrafik', 
            'labelPeriode', 'satuanWaktu', 'chartConfig', 'rincianBulanan'
        );
    }

    public function index(Request $request)
    {
        $data = $this->getDashboardData($request);
        return view('admin.dashboard', $data);
    }

    public function exportExcel(Request $request)
    {
        $data = $this->getDashboardData($request);
        $filterType = $request->input('filter_type', 'harian');

        $namaFilePeriode = match ($filterType) {
            'bulanan'    => 'Bulan-' . ($request->input('bulan') ?: date('Y-m')),
            'mingguan'   => 'Minggu-' . ($request->input('minggu') ?: date('Y-\WW')),
            'tahunan'    => 'Tahun-' . $request->input('tahun', date('Y')),
            'triwulanan' => 'Triwulan-' . $request->input('triwulan', 1) . '-' . $request->input('tahun_triwulan', date('Y')),
            default      => 'Tanggal-' . $request->input('tanggal', date('Y-m-d')),
        };

        $namaFile = "Rekap-Dashboard-SINEK-PADI-{$namaFilePeriode}.xlsx";

        return Excel::download(new DashboardExport($data), $namaFile);
    }
}