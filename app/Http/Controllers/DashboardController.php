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
        $transaksiQuery = Transaksi::with(['details.kategoriWisatawan', 'tarif.kendaraan']);

        // 1. Logika Penyaringan Berdasarkan Filter di Header
        if ($filterType == 'harian') {
            $tanggalPilihan = $request->input('tanggal', date('Y-m-d'));
            $transaksiQuery->whereDate('waktu', $tanggalPilihan);
        } 
        elseif ($filterType == 'bulanan' && $request->filled('bulan')) {
            $tahunBulan = explode('-', $request->bulan);
            $transaksiQuery->whereYear('waktu', $tahunBulan[0])
                           ->whereMonth('waktu', $tahunBulan[1]);
        } 
        elseif ($filterType == 'tahunan' && $request->filled('tahun')) {
            $transaksiQuery->whereYear('waktu', $request->tahun);
        } 
        elseif ($filterType == 'triwulanan') {
            $tahun = $request->input('tahun_triwulan', date('Y'));
            $triwulan = $request->input('triwulan', 1);

            $bulanMulai = (($triwulan - 1) * 3) + 1;
            $bulanSelesai = $bulanMulai + 2;

            $transaksiQuery->whereYear('waktu', $tahun)
                           ->whereMonth('waktu', '>=', $bulanMulai)
                           ->whereMonth('waktu', '<=', $bulanSelesai);
        } else {
            $transaksiQuery->whereDate('waktu', today());
        }

        // Ambil semua data transaksi yang sesuai filter
        $transaksiList = $transaksiQuery->get();

        // 2. Data Statistik Atas
        $totalPendapatan = $transaksiList->sum('total_bayar');
        $totalKendaraan = $transaksiList->count();

        // 3. Menghitung Sensus Wisatawan & Kendaraan Menggunakan Data Collection (Bersih dari query manual!)
        $totalWisatawan = 0;
        $wisatawanLokal = 0;
        $wisatawanNusantara = 0;
        $wisatawanMancanegara = 0;

        $kendaraanMotor = 0;
        $kendaraanMobil = 0;

        foreach ($transaksiList as $item) {
            // Memecah string sensus yang otomatis dihitung oleh Model Transaksi
            $sensusParts = explode(' / ', $item->sensus_rangkuman ?? '0 / 0 / 0');
            $l = (int) ($sensusParts[0] ?? 0);
            $n = (int) ($sensusParts[1] ?? 0);
            $m = (int) ($sensusParts[2] ?? 0);

            $wisatawanLokal += $l;
            $wisatawanNusantara += $n;
            $wisatawanMancanegara += $m;
            $totalWisatawan += ($l + $n + $m);

            // Cek kategori kendaraan dari relasi tarif
            $namaKendaraan = strtolower(optional($item->tarif->kendaraan)->nama_kendaraan ?? '');
            if (str_contains($namaKendaraan, 'motor')) {
                $kendaraanMotor++;
            } elseif (str_contains($namaKendaraan, 'mobil')) {
                $kendaraanMobil++;
            }
        }

        // 5. Data Line Chart Tren Kunjungan
        $trenKunjungan = [];
        $labelsGrafik = [];

        if ($filterType == 'bulanan' && $request->filled('bulan')) {
            $tahunBulan = explode('-', $request->bulan);
            $jumlahHari = Carbon::create($tahunBulan[0], $tahunBulan[1])->daysInMonth;
            
            for ($hari = 1; $hari <= $jumlahHari; $hari++) {
                $tanggalLengkap = $request->bulan . '-' . str_pad($hari, 2, '0', STR_PAD_LEFT);
                $jumlah = (clone $transaksiQuery)->whereDate('waktu', $tanggalLengkap)->count();
                $trenKunjungan[] = $jumlah;
                $labelsGrafik[] = (string) $hari;
            }
        } 
        elseif ($filterType == 'tahunan' && $request->filled('tahun')) {
            for ($bulan = 1; $bulan <= 12; $bulan++) {
                $jumlah = (clone $transaksiQuery)->whereYear('waktu', $request->tahun)
                                               ->whereMonth('waktu', $bulan)
                                               ->count();
                $trenKunjungan[] = $jumlah;
                $labelsGrafik[] = Carbon::create(null, $bulan)->translatedFormat('M');
            }
        } 
        elseif ($filterType == 'triwulanan') {
            $tahun = $request->input('tahun_triwulan', date('Y'));
            $triwulan = $request->input('triwulan', 1);

            $bulanMulai = (($triwulan - 1) * 3) + 1;
            $bulanSelesai = $bulanMulai + 2;

            for ($bulan = $bulanMulai; $bulan <= $bulanSelesai; $bulan++) {
                $jumlah = (clone $transaksiQuery)->whereYear('waktu', $tahun)
                                               ->whereMonth('waktu', $bulan)
                                               ->count();
                $trenKunjungan[] = $jumlah;
                $labelsGrafik[] = Carbon::create(null, $bulan)->translatedFormat('M');
            }
        }
        else {
            for ($jam = 6; $jam <= 21; $jam++) {
                $jumlah = (clone $transaksiQuery)->whereRaw('HOUR(waktu) = ?', [$jam])->count();
                $trenKunjungan[] = $jumlah;
                $labelsGrafik[] = str_pad($jam, 2, '0', STR_PAD_LEFT) . ':00';
            }
        }

        // 6. Label Periode Teks Singkat & Satuan Grafik
        $labelPeriode = match ($filterType) {
            'bulanan' => $request->filled('bulan') ? Carbon::createFromFormat('Y-m', $request->bulan)->translatedFormat('F Y') : 'Bulan Ini',
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
            'rentang' => ($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai')) 
                ? Carbon::parse($request->tanggal_mulai)->translatedFormat('d M Y') . ' s/d ' . Carbon::parse($request->tanggal_selesai)->translatedFormat('d M Y') 
                : 'Rentang Tanggal',
            default => Carbon::parse($request->input('tanggal', date('Y-m-d')))->translatedFormat('d M Y'),
        };

        $satuanWaktu = match ($filterType) {
            'bulanan' => 'Perhari',
            'tahunan', 'triwulanan' => 'Perbulan',
            default => 'Perjam',
        };

        $chartConfig = match ($filterType) {
            'bulanan' => ['max' => 300, 'step' => 50],
            'tahunan' => ['max' => 10000, 'step' => 1000],
            'triwulanan' => ['max' => 3000, 'step' => 500],
            default => ['max' => 50, 'step' => 10],
        };

        return compact(
            'totalPendapatan', 'totalKendaraan', 'totalWisatawan',
            'wisatawanLokal', 'wisatawanNusantara', 'wisatawanMancanegara',
            'kendaraanMotor', 'kendaraanMobil', 'trenKunjungan', 'labelsGrafik', 
            'labelPeriode', 'satuanWaktu', 'chartConfig'
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
        return Excel::download(new DashboardExport($data), 'Rekap-Dashboard-SINEK-PADI.xlsx');
    }
}