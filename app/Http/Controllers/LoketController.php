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

        // --- PINDAHAN LOGIKA MAPPING KE CONTROLLER ---
        $tarifMap = [];
        foreach($KategoriKendaraan as $k) {
            $tarifMap[$k->id_tarif] = $k->harga_tarif;
        }

        $qtyMap = [];
        foreach($KategoriWisatawan as $w) {
            $qtyMap[$w->id_kategori_wisatawan] = 0;
        }
        // ---------------------------------------------

        // 2. Ringkasan Pendapatan Hari Ini
        $totalPendapatan = DB::table('transaksis')
            ->whereDate('waktu', $tanggalHariIni)
            ->sum('total_bayar') ?? 0;

        // 3. Total Tiket/Struk Terbit Hari Ini
        $totalTiket = DB::table('transaksis')
            ->whereDate('waktu', $tanggalHariIni)
            ->count();

        // 4. Hitung Motor
        $totalMotor = DB::table('transaksis')
            ->join('tarifs', 'transaksis.id_tarif', '=', 'tarifs.id_tarif')
            ->join('kendaraans', 'tarifs.id_kendaraan', '=', 'kendaraans.id_kendaraan')
            ->whereDate('transaksis.waktu', $tanggalHariIni)
            ->where(function($q) {
                $q->where('kendaraans.nama_kendaraan', 'LIKE', '%motor%')
                  ->orWhere('kendaraans.nama_kendaraan', 'LIKE', '%Motor%');
            })
            ->count();

        // 5. Hitung Mobil
        $totalMobil = DB::table('transaksis')
            ->join('tarifs', 'transaksis.id_tarif', '=', 'tarifs.id_tarif')
            ->join('kendaraans', 'tarifs.id_kendaraan', '=', 'kendaraans.id_kendaraan')
            ->whereDate('transaksis.waktu', $tanggalHariIni)
            ->where(function($q) {
                $q->where('kendaraans.nama_kendaraan', 'LIKE', '%mobil%')
                  ->orWhere('kendaraans.nama_kendaraan', 'LIKE', '%Mobil%');
            })
            ->count();

        // 6. Total Wisatawan
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

        foreach ($riwayatTransaksi as $trx) {
            $details = DB::table('detail_wisatawan_transaksis')
                ->join('kategori_wisatawans', 'detail_wisatawan_transaksis.id_kategori_wisatawan', '=', 'kategori_wisatawans.id_kategori_wisatawan')
                ->where('detail_wisatawan_transaksis.id_transaksi', $trx->id_transaksi)
                ->select('kategori_wisatawans.nama_kategori_wisatawan', 'detail_wisatawan_transaksis.jumlah_jiwa')
                ->get();
            
            $lokal = 0;
            $nusantara = 0;
            $mancanegara = 0;

            foreach ($details as $det) {
                $nama = strtolower($det->nama_kategori_wisatawan);

                if (str_contains($nama, 'lokal')) {
                    $lokal += $det->jumlah_jiwa;
                } elseif (str_contains($nama, 'nusantara')) {
                    $nusantara += $det->jumlah_jiwa;
                } elseif (str_contains($nama, 'mancanegara') || str_contains($nama, 'asing')) {
                    $mancanegara += $det->jumlah_jiwa;
                }
            }

            $trx->sensus_l = $lokal;
            $trx->sensus_n = $nusantara;
            $trx->sensus_m = $mancanegara;
        }

        // 8. Kirim variabel lengkap ke view (termasuk tarifMap dan qtyMap)
        return view('petugas.loket', compact(
            'KategoriKendaraan', 
            'KategoriWisatawan', 
            'tarifMap',
            'qtyMap',
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
            DB::beginTransaction();

            $noKarcis = 'TRX-' . date('Ymd') . '-' . strtoupper(Str::random(5));

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

            if ($request->has('qty_wisatawan')) {
                foreach ($request->qty_wisatawan as $idKategoriWisatawan => $jumlah) {
                    if ($jumlah > 0) {
                        DB::table('detail_wisatawan_transaksis')->insert([
                            'id_transaksi'          => $transaksiId,
                            'id_kategori_wisatawan' => $idKategoriWisatawan,
                            'jumlah_jiwa'           => $jumlah,
                            'created_at'            => now(),
                            'updated_at'            => now(),
                        ]);
                    }
                }
            }

            DB::commit();

            return response()->json([
                'status'    => 'sukses',
                'url_print' => route('transaksi.cetak', $transaksiId)
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

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