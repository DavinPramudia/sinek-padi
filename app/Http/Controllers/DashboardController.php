<?php

namespace App\Http\Controllers;

use App\Models\KategoriWisatawan;
use App\Models\Kendaraan;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\DetailWisatawanTransaksi;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Data Statistik Atas (Hari ini)
        $totalPendapatan = Transaksi::whereDate('waktu', today())->sum('total_bayar');
        $totalKendaraan = Transaksi::whereDate('waktu', today())->count();
        $totalWisatawan = DetailWisatawanTransaksi::whereHas('transaksi', function($q) {
            $q->whereDate('waktu', today());
        })->count();

        // 2. Data Donut Chart Wisatawan 
        $kategoriLokal = KategoriWisatawan::where('nama_kategori_wisatawan', 'like', '%Lokal%Bangka%')->pluck('id_kategori_wisatawan');
        $kategoriNusantara = KategoriWisatawan::where('nama_kategori_wisatawan', 'like', '%Nusantara%')->pluck('id_kategori_wisatawan');
        $kategoriMancanegara = KategoriWisatawan::where('nama_kategori_wisatawan', 'like', '%Mancanegara%')->pluck('id_kategori_wisatawan');

        $wisatawanLokal = DetailWisatawanTransaksi::whereIn('id_kategori_wisatawan', $kategoriLokal)
            ->whereHas('transaksi', function($q) {
                $q->whereDate('waktu', today());
            })->count();

        $wisatawanNusantara = DetailWisatawanTransaksi::whereIn('id_kategori_wisatawan', $kategoriNusantara)
            ->whereHas('transaksi', function($q) {
                $q->whereDate('waktu', today());
            })->count();

        $wisatawanMancanegara = DetailWisatawanTransaksi::whereIn('id_kategori_wisatawan', $kategoriMancanegara)
            ->whereHas('transaksi', function($q) {
                $q->whereDate('waktu', today());
            })->count();

        // 3. Data Donut Chart Kendaraan 
        $kategoriMotor = Kendaraan::where('nama_kendaraan', 'like', '%Motor%')->pluck('id_kendaraan');
        $kategoriMobil = Kendaraan::where('nama_kendaraan', 'like', '%Mobil%')->pluck('id_kendaraan');

        $kendaraanMotor = Transaksi::whereDate('waktu', today())
            ->where('total_bayar', '2000') // Sesuaikan isi kolom di database Anda
            ->count();

        $kendaraanMobil = Transaksi::whereDate('waktu', today())
            ->where('total_bayar', '4000') // Sesuaikan isi kolom di database Anda
            ->count();

        return view('admin.dashboard', compact(
            'totalPendapatan',
            'totalKendaraan',
            'totalWisatawan',
            'wisatawanLokal',
            'wisatawanNusantara',
            'wisatawanMancanegara',
            'kendaraanMotor',
            'kendaraanMobil'
        ));
    }
}