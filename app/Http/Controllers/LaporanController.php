<?php

namespace App\Http\Controllers;

use App\Models\KategoriWisatawan;
use App\Models\Kendaraan;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\DetailWisatawanTransaksi;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil jenis filter dan kata kunci pencarian
        $filterType = $request->input('filter_type', 'harian');
        $search = $request->input('search');

        // 2. Buat query dasar untuk transaksi
        $transaksiQuery = Transaksi::with(['details.kategoriWisatawan', 'user']);

        // 3. Logika Penyaringan Berdasarkan Filter di Header
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

        // 4. Tambahan Fitur Pencarian No Karcis / No Tiket
        if ($search) {
            $transaksiQuery->where('no_karcis', 'like', "%{$search}%");
        }

        // 5. Data Statistik Kartu Atas (Mengikuti Filter)
        $totalTransaksi = (clone $transaksiQuery)->count();
        $totalPendapatan = (clone $transaksiQuery)->sum('total_bayar');

        // 6. Label Periode Teks Singkat
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
            default => Carbon::parse($request->input('tanggal', date('Y-m-d')))->translatedFormat('d M Y'),
        };

        // 7. Ambil Data dengan ->get() (Tanpa Pagination)
        $transaksi = $transaksiQuery->latest('waktu')->get();

        // 8. Olah/Transformasi data sensus wisatawan dengan format (L / N / M)
        $transaksi->transform(function ($item) {
            $lokal = 0;
            $nusantara = 0;
            $mancanegara = 0;

            foreach ($item->details as $det) {
                $namaKategori = optional($det->kategoriWisatawan)->nama_kategori_wisatawan;
                
                if (stripos($namaKategori, 'Nusantara') !== false) {
                    $nusantara += $det->jumlah_jiwa;
                } elseif (stripos($namaKategori, 'Mancanegara') !== false) {
                    $mancanegara += $det->jumlah_jiwa;
                } else {
                    $lokal += $det->jumlah_jiwa;
                }
            }

            $item->sensus_rangkuman = "{$lokal} / {$nusantara} / {$mancanegara}";
            
            return $item;
        });

        return view('admin.laporan-transaksi', compact(
            'totalTransaksi',
            'totalPendapatan',
            'search',
            'transaksi',
            'filterType',
            'labelPeriode'
        ));
    }
}