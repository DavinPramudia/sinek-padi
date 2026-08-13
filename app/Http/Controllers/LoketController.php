<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;  
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Models\Tarif;
use App\Models\KategoriWisatawan;
use App\Models\Transaksi;
use App\Models\DetailWisatawanTransaksi;

class LoketController extends Controller
{
    public function index()
    {
        $tanggalHariIni = now()->toDateString();

        // 1. Ambil data tarif & relasi ke kendaraan menggunakan Eloquent Model
        $KategoriKendaraan = Tarif::with('kendaraan')->get()->map(function($tarif) {
            return (object)[
                'id_tarif' => $tarif->id_tarif,
                'harga_tarif' => $tarif->harga_tarif,
                'nama_kendaraan' => $tarif->kendaraan->nama_kendaraan ?? '-'
            ];
        });

        $KategoriWisatawan = KategoriWisatawan::all(); 

        // Mapping untuk frontend
        $tarifMap = $KategoriKendaraan->pluck('harga_tarif', 'id_tarif')->toArray();
        $qtyMap = $KategoriWisatawan->pluck('id_kategori_wisatawan')->mapWithKeys(fn($id) => [$id => 0])->toArray();

        // 2. Ringkasan Pendapatan Hari Ini
        $totalPendapatan = Transaksi::whereDate('waktu', $tanggalHariIni)->sum('total_bayar') ?? 0;

        // 3. Total Tiket Terbit Hari Ini
        $totalTiket = Transaksi::whereDate('waktu', $tanggalHariIni)->count();

        // 4. Hitung Motor menggunakan relasi Eloquent
        $totalMotor = Transaksi::whereDate('waktu', $tanggalHariIni)
            ->whereHas('tarif.kendaraan', function($q) {
                $q->where('nama_kendaraan', 'LIKE', '%motor%');
            })->count();

        // 5. Hitung Mobil menggunakan relasi Eloquent
        $totalMobil = Transaksi::whereDate('waktu', $tanggalHariIni)
            ->whereHas('tarif.kendaraan', function($q) {
                $q->where('nama_kendaraan', 'LIKE', '%mobil%');
            })->count();

        // 6. Total Wisatawan
        $totalWisatawan = DetailWisatawanTransaksi::whereHas('transaksi', function($q) use ($tanggalHariIni) {
            $q->whereDate('waktu', $tanggalHariIni);
        })->sum('jumlah_jiwa') ?? 0;

        // 7. Ambil Riwayat Transaksi (5 terakhir hari ini) dengan Eloquent Relationships
        $riwayatTransaksi = Transaksi::with(['tarif.kendaraan', 'details.kategoriWisatawan'])
            ->whereDate('waktu', $tanggalHariIni)
            ->orderBy('waktu', 'desc')
            ->limit(5)
            ->get();

        foreach ($riwayatTransaksi as $trx) {
            $lokal = 0;
            $nusantara = 0;
            $mancanegara = 0;

            foreach ($trx->details as $det) {
                $nama = strtolower($det->kategoriWisatawan->nama_kategori_wisatawan ?? '');

                if (str_contains($nama, 'lokal')) {
                    $lokal += $det->jumlah_jiwa;
                } elseif (str_contains($nama, 'nusantara')) {
                    $nusantara += $det->jumlah_jiwa;
                } elseif (str_contains($nama, 'mancanegara') || str_contains($nama, 'asing')) {
                    $mancanegara += $det->jumlah_jiwa;
                }
            }

            $trx->nama_kendaraan = $trx->tarif->kendaraan->nama_kendaraan ?? '-';
            $trx->sensus_l = $lokal;
            $trx->sensus_n = $nusantara;
            $trx->sensus_m = $mancanegara;
        }

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

            // Menggunakan Eloquent Model create()
            $transaksi = Transaksi::create([
                'no_karcis'     => $noKarcis,
                'total_bayar'   => $request->total_bayar ?? 0,
                'waktu'         => now(),
                'reprint_count' => 0,                    
                'metode_cetak'  => $request->metode_cetak ?? 'print',
                'id_users'      => auth()->id(),       
                'id_tarif'      => $request->id_tarif, 
            ]);

            if ($request->has('qty_wisatawan')) {
                foreach ($request->qty_wisatawan as $idKategoriWisatawan => $jumlah) {
                    if ($jumlah > 0) {
                        DetailWisatawanTransaksi::create([
                            'id_transaksi'          => $transaksi->id_transaksi,
                            'id_kategori_wisatawan' => $idKategoriWisatawan,
                            'jumlah_jiwa'           => $jumlah,
                        ]);
                    }
                }
            }

            DB::commit();

            if ($request->metode_cetak === 'e-ticket') {
                // Jika pilih e-ticket, arahkan URL-nya ke halaman khusus QR Code
                $urlTujuan = route('transaksi.qrcode', $transaksi->id_transaksi);
            } else {
                // Jika pilih print biasa, arahkan ke URL cetak kertas thermal
                $urlTujuan = route('transaksi.cetak', $transaksi->id_transaksi);
            }

            return response()->json([
                'status'    => 'sukses',
                'url_print' => $urlTujuan
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function cetak(Request $request, $id)
    {
        // Menggunakan Eloquent dengan Eager Loading
        $transaksi = Transaksi::with(['tarif.kendaraan', 'user'])->where('id_transaksi', $id)->first();

        if (!$transaksi) {
            abort(404, 'Data transaksi tidak ditemukan.');
        }

        // --- TAMBAHKAN LOGIKA REPRINT DI SINI ---
        // Jika URL membawa parameter ?reprint=true, maka tambah reprint_count +1
        if ($request->has('reprint') && $request->reprint == 'true') {
            $transaksi->increment('reprint_count');
        }
        // ----------------------------------------

        $transaksi->details = DetailWisatawanTransaksi::with('kategoriWisatawan')
            ->where('id_transaksi', $id)
            ->get()
            ->map(function($detail) {
                return (object)[
                    'nama_kategori_wisatawan' => $detail->kategoriWisatawan->nama_kategori_wisatawan ?? '-',
                    'jumlah_jiwa' => $detail->jumlah_jiwa
                ];
            });

        $transaksi->nama_kendaraan = $transaksi->tarif->kendaraan->nama_kendaraan ?? '-';

        $mode = $request->query('mode', 'print');

        if ($mode === 'e-ticket') {
            $pdf = Pdf::loadView('transaksi.cetak-struk', compact('transaksi'))
                        ->setPaper([0, 0, 164, 350], 'portrait'); 

            return $pdf->download('E-Ticket-' . $transaksi->no_karcis . '.pdf');
        }

        return view('transaksi.cetak-struk', compact('transaksi'));
    }

    public function qrcode($id)
    {
        $transaksi = Transaksi::with(['tarif.kendaraan', 'user'])->where('id_transaksi', $id)->first();

        if (!$transaksi) {
            abort(404, 'Data transaksi tidak ditemukan.');
        }

        return view('transaksi.qr-tiket', compact('transaksi'));
    }
}