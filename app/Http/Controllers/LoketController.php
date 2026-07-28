<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;  

class LoketController extends Controller
{
    public function index()
    {
        $tanggalHariIni = date('Y-m-d');

        // 1. Ambil data tarif & join dengan kendaraan
        $KategoriKendaraan = DB::table('tarifs')
            ->join('kendaraans', 'tarifs.id_kendaraan', '=', 'kendaraans.id_kendaraan')
            ->select('tarifs.id_tarif', 'tarifs.harga_tarif', 'kendaraans.nama_kendaraan')
            ->get(); 

        $KategoriWisatawan = DB::table('kategori_wisatawans')->get(); 

        // 2. Ringkasan Pendapatan Hari Ini
        $totalPendapatan = DB::table('transaksis')
            ->whereDate('waktu', $tanggalHariIni)
            ->sum('total_bayar') ?? 0;

        // 3. Total Tiket/Struk Terbit Hari Ini
        $totalTiket = DB::table('transaksis')
            ->whereDate('waktu', $tanggalHariIni)
            ->count();

        // 4. Hitung Motor (Fleksibel: mendeteksi 'motor' atau 'Motor')
        $totalMotor = DB::table('transaksis')
            ->join('tarifs', 'transaksis.id_tarif', '=', 'tarifs.id_tarif')
            ->join('kendaraans', 'tarifs.id_kendaraan', '=', 'kendaraans.id_kendaraan')
            ->whereDate('transaksis.waktu', $tanggalHariIni)
            ->where(function($q) {
                $q->where('kendaraans.nama_kendaraan', 'LIKE', '%motor%')
                  ->orWhere('kendaraans.nama_kendaraan', 'LIKE', '%Motor%');
            })
            ->count();

        // 5. Hitung Mobil (Fleksibel: mendeteksi 'mobil' atau 'Mobil')
        $totalMobil = DB::table('transaksis')
            ->join('tarifs', 'transaksis.id_tarif', '=', 'tarifs.id_tarif')
            ->join('kendaraans', 'tarifs.id_kendaraan', '=', 'kendaraans.id_kendaraan')
            ->whereDate('transaksis.waktu', $tanggalHariIni)
            ->where(function($q) {
                $q->where('kendaraans.nama_kendaraan', 'LIKE', '%mobil%')
                  ->orWhere('kendaraans.nama_kendaraan', 'LIKE', '%Mobil%');
            })
            ->count();

        // 6. Total Wisatawan (Jumlah jiwa hari ini dari tabel detail)
        $totalWisatawan = DB::table('detail_wisatawan_transaksis')
            ->join('transaksis', 'detail_wisatawan_transaksis.id_transaksi', '=', 'transaksis.id_transaksi')
            ->whereDate('transaksis.waktu', $tanggalHariIni)
            ->sum('detail_wisatawan_transaksis.jumlah_jiwa') ?? 0;

        // 7. Ambil data Riwayat Transaksi (5 terakhir hari ini)
        $riwayatTransaksi = DB::table('transaksis')
            ->join('tarifs', 'transaksis.id_tarif', '=', 'tarifs.id_tarif')
            ->join('kendaraans', 'tarifs.id_kendaraan', '=', 'kendaraans.id_kendaraan')
            ->select('transaksis.*', 'kendaraans.nama_kendaraan')
            ->whereDate('transaksis.waktu', $tanggalHariIni)
            ->orderBy('transaksis.waktu', 'desc')
            ->limit(5)
            ->get();

        // 8. Kirim semua variabel ke view loket
        return view('petugas.loket', compact(
            'KategoriKendaraan', 
            'KategoriWisatawan', 
            'totalPendapatan', 
            'totalTiket', 
            'totalMotor', 
            'totalMobil',
            'totalWisatawan',
            'riwayatTransaksi'
        ));
    }

    public function store(Request $request)
    {
        try {
            // Mulai kunci database. Kalau ada 1 yang gagal insert, semua dibatalkan!
            DB::beginTransaction();

            // 1. Buat nomor karcis otomatis yang unik
            $noKarcis = 'TRX-' . date('Ymd') . '-' . strtoupper(Str::random(5));

            // 2. Simpan ke tabel utama (transaksis)
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

            // 3. Simpan ke tabel detail wisatawan
            if ($request->has('qty_wisatawan')) {
                foreach ($request->qty_wisatawan as $idKategoriWisatawan => $jumlah) {
                    // Hanya simpan yang jumlahnya lebih dari 0
                    if ($jumlah > 0) {
                        
                        // PASTIKAN INI SESUAI DENGAN TABEL DATABASEMU
                        // Saya sesuaikan dengan model yang kamu kirim sebelumnya
                        DB::table('detail_wisatawan_transaksis')->insert([
                            'id_transaksi'  => $transaksiId,
                            'id_kategori_wisatawan'   => $idKategoriWisatawan,
                            'jumlah_jiwa'   => $jumlah,
                            'created_at'    => now(),
                            'updated_at'    => now(),
                        ]);
                    }
                }
            }

            // Simpan permanen ke database
            DB::commit();

            // 4. Kembalikan respons sukses ke Alpine.js
            return response()->json([
                'status'    => 'sukses',
                'url_print' => route('transaksi.cetak', $transaksiId)
            ]);

        } catch (\Exception $e) {
            // Jika ada error, batalkan semua insert data tadi
            DB::rollBack();

            // Kirim pesan error berbentuk JSON agar ditangkap oleh Alpine.js
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
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