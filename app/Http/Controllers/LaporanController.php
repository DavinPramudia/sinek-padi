<?php

namespace App\Http\Controllers;

use App\Models\KategoriWisatawan;
use App\Models\Kendaraan;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\DetailWisatawanTransaksi;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanTransaksiExport;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    /**
     * FUNGSI BANTUAN UNTUK FILTER (Agar tidak nulis ulang di index & exportExcel)
     */
    private function getQueryFilter(Request $request)
    {
        $filterType = $request->input('filter_type', 'harian');
        $search = $request->input('search');

        $transaksiQuery = Transaksi::with(['details.kategoriWisatawan', 'user']);

        // Logika Penyaringan Berdasarkan Filter di Header
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

        // Tambahan Fitur Pencarian No Karcis / No Tiket
        if ($search) {
            $transaksiQuery->where('no_karcis', 'like', "%{$search}%");
        }

        return $transaksiQuery;
    }

    /**
     * Method index (TIDAK BERUBAH)
     */
    public function index(Request $request)
    {
        $filterType = $request->input('filter_type', 'harian');
        $search = $request->input('search');

        // Panggil fungsi filter bantuan
        $transaksiQuery = $this->getQueryFilter($request);

        // Data Statistik Kartu Atas
        $totalTransaksi = (clone $transaksiQuery)->count();
        $totalPendapatan = (clone $transaksiQuery)->sum('total_bayar');

        // Label Periode Teks Singkat
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

        // Ambil Data dengan ->get()
        $transaksi = $transaksiQuery->latest('waktu')->get();

        $transaksi->transform(function ($item) {
            $details = DB::table('detail_wisatawan_transaksis')
                ->join('kategori_wisatawans', 'detail_wisatawan_transaksis.id_kategori_wisatawan', '=', 'kategori_wisatawans.id_kategori_wisatawan')
                ->where('detail_wisatawan_transaksis.id_transaksi', $item->id_transaksi)
                ->select('kategori_wisatawans.nama_kategori_wisatawan', 'detail_wisatawan_transaksis.jumlah_jiwa')
                ->get();

            $lokal = 0;
            $nusantara = 0;
            $mancanegara = 0;

            foreach ($details as $det) {
                $nama = strtolower($det->nama_kategori_wisatawan);
                $jumlahJiwa = (int) ($det->jumlah_jiwa ?? 0);

                if (str_contains($nama, 'lokal')) {
                    $lokal += $jumlahJiwa;
                } elseif (str_contains($nama, 'nusantara')) {
                    $nusantara += $jumlahJiwa;
                } elseif (str_contains($nama, 'mancanegara') || str_contains($nama, 'asing')) {
                    $mancanegara += $jumlahJiwa;
                }
            }

            // Simpan ke properti yang dibaca oleh Export Excel & View
            $item->sensus_l = $lokal;
            $item->sensus_n = $nusantara;
            $item->sensus_m = $mancanegara;
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

    /**
     * METHOD BARU: Untuk Mengunduh Excel Laporan Transaksi
     */
public function exportExcel(Request $request)
    {
        $filterType = $request->input('filter_type', 'harian');
        $transaksiQuery = $this->getQueryFilter($request);
        $transaksi = $transaksiQuery->latest('waktu')->get();

        // Label Periode untuk di Excel
        $labelPeriode = match ($filterType) {
            'bulanan' => $request->filled('bulan') ? Carbon::createFromFormat('Y-m', $request->bulan)->translatedFormat('F Y') : 'Bulan Ini',
            'tahunan' => 'Tahun ' . $request->input('tahun', date('Y')),
            'triwulanan' => 'Triwulan ' . $request->input('triwulan', 1) . ' Tahun ' . $request->input('tahun_triwulan', date('Y')),
            'rentang' => 'Rentang Tanggal',
            default => Carbon::parse($request->input('tanggal', date('Y-m-d')))->translatedFormat('d M Y'),
        };

        // SALIN LOGIKA YANG BERHASIL DARI INDEX KE SINI
        $transaksi->transform(function ($item) {
            $details = \Illuminate\Support\Facades\DB::table('detail_wisatawan_transaksis')
                ->join('kategori_wisatawans', 'detail_wisatawan_transaksis.id_kategori_wisatawan', '=', 'kategori_wisatawans.id_kategori_wisatawan')
                ->where('detail_wisatawan_transaksis.id_transaksi', $item->id_transaksi)
                ->select('kategori_wisatawans.nama_kategori_wisatawan', 'detail_wisatawan_transaksis.jumlah_jiwa')
                ->get();

            $lokal = 0;
            $nusantara = 0;
            $mancanegara = 0;

            foreach ($details as $det) {
                $nama = strtolower($det->nama_kategori_wisatawan);
                $jumlahJiwa = (int) ($det->jumlah_jiwa ?? 0);

                if (str_contains($nama, 'lokal')) {
                    $lokal += $jumlahJiwa;
                } elseif (str_contains($nama, 'nusantara')) {
                    $nusantara += $jumlahJiwa;
                } elseif (str_contains($nama, 'mancanegara') || str_contains($nama, 'asing')) {
                    $mancanegara += $jumlahJiwa;
                }
            }

            // Wajib mendefinisikan properti ini agar dibaca oleh LaporanTransaksiExport
            $item->sensus_l = $lokal;
            $item->sensus_n = $nusantara;
            $item->sensus_m = $mancanegara;
            $item->sensus_rangkuman = "{$lokal} / {$nusantara} / {$mancanegara}";
            
            return $item;
        });

        return Excel::download(new LaporanTransaksiExport($transaksi, $labelPeriode), 'Laporan-Transaksi-SINEK-PADI.xlsx');
    }
}