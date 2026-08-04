<?php

namespace App\Http\Controllers;

use App\Models\KategoriWisatawan;
use App\Models\Kendaraan;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\DetailWisatawanTransaksi;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Ambil jenis filter yang dipilih (default 'harian')
        $filterType = $request->input('filter_type', 'harian');

        // Buat query dasar untuk transaksi
        $transaksiQuery = Transaksi::query();

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

        // 2. Data Statistik Atas (Mengikuti Filter)
        $totalPendapatan = (clone $transaksiQuery)->sum('total_bayar');
        $totalKendaraan = (clone $transaksiQuery)->count();

        // Ambil ID transaksi yang lolos filter untuk menghitung detail wisatawan
        $transaksiIds = (clone $transaksiQuery)->pluck('id_transaksi');
        $totalWisatawan = DetailWisatawanTransaksi::whereIn('id_transaksi', $transaksiIds)->count();

        // 3. Data Donut Chart Wisatawan 
        $kategoriLokal = KategoriWisatawan::where('nama_kategori_wisatawan', 'like', '%Lokal%Bangka%')->pluck('id_kategori_wisatawan');
        $kategoriNusantara = KategoriWisatawan::where('nama_kategori_wisatawan', 'like', '%Nusantara%')->pluck('id_kategori_wisatawan');
        $kategoriMancanegara = KategoriWisatawan::where('nama_kategori_wisatawan', 'like', '%Mancanegara%')->pluck('id_kategori_wisatawan');

        $wisatawanLokal = DetailWisatawanTransaksi::whereIn('id_transaksi', $transaksiIds)
            ->whereIn('id_kategori_wisatawan', $kategoriLokal)->count();

        $wisatawanNusantara = DetailWisatawanTransaksi::whereIn('id_transaksi', $transaksiIds)
            ->whereIn('id_kategori_wisatawan', $kategoriNusantara)->count();

        $wisatawanMancanegara = DetailWisatawanTransaksi::whereIn('id_transaksi', $transaksiIds)
            ->whereIn('id_kategori_wisatawan', $kategoriMancanegara)->count();

        // 4. Data Donut Chart Kendaraan 
        $kendaraanMotor = (clone $transaksiQuery)->where('id_tarif', 1)->count(); 
        $kendaraanMobil = (clone $transaksiQuery)->where('id_tarif', 2)->count();

        // 5. Data Line Chart Tren Kunjungan (Dinamis Berdasarkan Filter)
        $trenKunjungan = [];
        $labelsGrafik = [];

        if ($filterType == 'bulanan' && $request->filled('bulan')) {
            // Jika Bulanan: Ambil data per hari dalam bulan tersebut
            $tahunBulan = explode('-', $request->bulan);
            $jumlahHari = Carbon::create($tahunBulan[0], $tahunBulan[1])->daysInMonth;
            
            for ($hari = 1; $hari <= $jumlahHari; $hari++) {
                $tanggalLengkap = $request->bulan . '-' . str_pad($hari, 2, '0', STR_PAD_LEFT);
                $jumlah = (clone $transaksiQuery)->whereDate('waktu', $tanggalLengkap)->count();
                $trenKunjungan[] = $jumlah;
                $labelsGrafik[] = (string) $hari; // Label: 1, 2, 3, ... 31
            }
        } 
        elseif ($filterType == 'tahunan' && $request->filled('tahun')) {
            // Jika Tahunan: Ambil data per bulan (Jan - Des)
            for ($bulan = 1; $bulan <= 12; $bulan++) {
                $jumlah = (clone $transaksiQuery)->whereYear('waktu', $request->tahun)
                                                 ->whereMonth('waktu', $bulan)
                                                 ->count();
                $trenKunjungan[] = $jumlah;
                $labelsGrafik[] = Carbon::create(null, $bulan)->translatedFormat('M'); // Jan, Feb...
            }
        } 
        elseif ($filterType == 'triwulanan') {
            // Jika Triwulanan: Ambil data per 3 bulan dalam triwulan tersebut
            $tahun = $request->input('tahun_triwulan', date('Y'));
            $triwulan = $request->input('triwulan', 1);

            $bulanMulai = (($triwulan - 1) * 3) + 1;
            $bulanSelesai = $bulanMulai + 2;

            for ($bulan = $bulanMulai; $bulan <= $bulanSelesai; $bulan++) {
                $jumlah = (clone $transaksiQuery)->whereYear('waktu', $tahun)
                                                 ->whereMonth('waktu', $bulan)
                                                 ->count();
                $trenKunjungan[] = $jumlah;
                $labelsGrafik[] = Carbon::create(null, $bulan)->translatedFormat('M'); // Misal: Jan, Feb, Mar
            }
        }
        else {
            // Jika Harian / Rentang / Lainnya: Ambil data per jam (06:00 s.d 21:00)
            for ($jam = 6; $jam <= 21; $jam++) {
                $jumlah = (clone $transaksiQuery)->whereRaw('HOUR(waktu) = ?', [$jam])->count();
                $trenKunjungan[] = $jumlah;
                $labelsGrafik[] = str_pad($jam, 2, '0', STR_PAD_LEFT) . ':00'; // Label: 06:00, 07:00...
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

        // Satuan waktu untuk judul grafik
        $satuanWaktu = match ($filterType) {
            'bulanan' => 'Perhari',
            'tahunan', 'triwulanan' => 'Perbulan', // Triwulanan kini menggunakan satuan per bulan
            default => 'Perjam',
        };

        // 7. Pengaturan Skala Maksimal & Step Grafik Berdasarkan Filter
        $chartConfig = match ($filterType) {
            'bulanan' => ['max' => 300, 'step' => 50],
            'tahunan' => ['max' => 10000, 'step' => 1000],
            'triwulanan' => ['max' => 3000, 'step' => 500], // Sesuaikan skala untuk triwulanan (3 bulan)
            default => ['max' => 50, 'step' => 10], // Untuk harian / rentang / tanggal
        };

        return view('admin.dashboard', compact(
            'totalPendapatan', 'totalKendaraan', 'totalWisatawan',
            'wisatawanLokal', 'wisatawanNusantara', 'wisatawanMancanegara',
            'kendaraanMotor', 'kendaraanMobil', 'trenKunjungan', 'labelsGrafik', 
            'labelPeriode', 'satuanWaktu', 'chartConfig' // <-- Masukkan ke compact
        ));
    }
}