<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;  

class LoketController extends Controller
{
    public function index()
    {
        // 1. Ambil data tarif & join dengan tabel kendaraans supaya nama kendaraannya ikut
        $KategoriKendaraan = DB::table('tarifs')
            ->join('kendaraans', 'tarifs.id_kendaraan', '=', 'kendaraans.id_kendaraan')
            ->select('tarifs.id_tarif', 'tarifs.harga_tarif', 'kendaraans.nama_kendaraan')
            ->get(); 

        $KategoriWisatawan = DB::table('kategori_wisatawans')->get(); 

        // 2. Ringkasan Pendapatan Hari Ini
        $totalPendapatan = DB::table('transaksis')
            ->whereDate('created_at', today())
            ->sum('total_bayar') ?? 0;

        // 3. Total Tiket Terbit Hari Ini
        $totalTiket = DB::table('transaksis')
            ->whereDate('created_at', today())
            ->count();

        // 4. Hitung berdasarkan Foreign Key (id_tarif)
        $totalMotor = DB::table('transaksis')
            ->whereDate('created_at', today())
            ->where('id_tarif', 1) 
            ->count();

        $totalMobil = DB::table('transaksis')
            ->whereDate('created_at', today())
            ->where('id_tarif', 2) 
            ->count();

        // 5. Kirim semua variabel ke view loket
        return view('petugas.loket', compact(
            'KategoriKendaraan', 
            'KategoriWisatawan', 
            'totalPendapatan', 
            'totalTiket', 
            'totalMotor', 
            'totalMobil'
        ));
    }

    public function store(Request $request)
    {
        // 1. Buat nomor karcis otomatis yang unik
        $noKarcis = 'TRX-' . date('Ymd') . '-' . strtoupper(Str::random(5));

        // 2. Simpan ke database sesuai kolom migrasi kamu
        $transaksiId = DB::table('transaksis')->insertGetId([
            'no_karcis'     => $noKarcis,
            'total_bayar'   => $request->total_bayar ?? 0,
            'waktu'         => now(),
            'reprint_count' => 0,                    
            'metode_cetak'  => $request->metode_cetak ?? 'print',
            'id_users'      => auth()->id(),       
            'id_tarif'      => $request->id_tarif, 
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);

        // 3. Kembalikan respons sukses ke Alpine.js
        return response()->json([
            'status'    => 'sukses',
            'url_print' => route('transaksi.cetak', $transaksiId)
        ]);
    }

    public function cetak($id)
    {
        $transaksi = DB::table('transaksis')
            ->join('tarifs', 'transaksis.id_tarif', '=', 'tarifs.id_tarif')
            ->join('kendaraans', 'tarifs.id_kendaraan', '=', 'kendaraans.id_kendaraan')
            ->where('transaksis.id_transaksi', $id)
            ->first();

        if (!$transaksi) {
            abort(404, 'Data transaksi tidak ditemukan.');
        }

        return view('transaksi.cetak-struk', compact('transaksi'));
    }
}