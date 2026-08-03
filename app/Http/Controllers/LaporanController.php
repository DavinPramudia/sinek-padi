<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil jenis filter dan kata kunci pencarian
        $filterType = $request->input('filter_type', 'harian');
        $search = $request->input('search');

        // 2. Buat query dasar untuk transaksi (Sama persis seperti Dashboard)
        $transaksiQuery = Transaksi::with(['detailWisatawan.kategoriWisatawan', 'petugas']);

        // 3. Logika Penyaringan Berdasarkan Filter di Header (Copy-paste dari Dashboard)
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

        // 4. Tambahan Fitur Pencarian No Tiket
        if ($search) {
            $transaksiQuery->where('no_tiket', 'like', "%{$search}%");
        }

        // 5. Data Statistik Kartu Atas (Mengikuti Filter)
        $totalTransaksi = (clone $transaksiQuery)->count();
        $totalPendapatan = (clone $transaksiQuery)->sum('total_bayar');

        // 6. Ambil Data untuk Tabel dengan Pagination (Menggantikan get())
        $transaksi = $transaksiQuery->latest('waktu')->paginate(10)->appends($request->query());

        return view('admin.laporan-transaksi', compact(
            'totalTransaksi',
            'totalPendapatan',
            'search',
            'transaksi',
            'filterType'
        ));
    }
}