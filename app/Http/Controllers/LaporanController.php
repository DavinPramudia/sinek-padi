<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanTransaksiExport;

class LaporanController extends Controller
{
    /**
     * FUNGSI BANTUAN UNTUK FILTER (Eager Loading relasi yang dibutuhkan)
     */
    private function getQueryFilter(Request $request)
    {
        $filterType = $request->input('filter_type', 'harian');
        $search = $request->input('search');

        // Memuat relasi details, kategoriWisatawan, user, dan tarif.kendaraan sekaligus (Eager Loading)
        $transaksiQuery = Transaksi::with(['details.kategoriWisatawan', 'user', 'tarif.kendaraan']);

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
     * Method index
     */
    public function index(Request $request)
    {
        $filterType = $request->input('filter_type', 'harian');
        $search = $request->input('search');

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

        // Pagination
        $transaksi = $transaksiQuery->latest('waktu')
                                    ->paginate(5)
                                    ->onEachSide(1)
                                    ->withQueryString();

        // Transform data menggunakan relasi Eloquent (Bersih dari DB::table manual)
        $transaksi->getCollection()->transform(function ($item) {
            $lokal = 0;
            $nusantara = 0;
            $mancanegara = 0;

            // Membaca langsung dari relasi $item->details yang sudah dimuat lewat Eager Loading
            foreach ($item->details as $det) {
                $nama = strtolower($det->kategoriWisatawan->nama_kategori_wisatawan ?? '');
                $jumlahJiwa = (int) ($det->jumlah_jiwa ?? 0);

                if (str_contains($nama, 'lokal')) {
                    $lokal += $jumlahJiwa;
                } elseif (str_contains($nama, 'nusantara')) {
                    $nusantara += $jumlahJiwa;
                } elseif (str_contains($nama, 'mancanegara') || str_contains($nama, 'asing')) {
                    $mancanegara += $jumlahJiwa;
                }
            }

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
     * Method exportExcel
     */
    public function exportExcel(Request $request)
    {
        $filterType = $request->input('filter_type', 'harian');
        $transaksiQuery = $this->getQueryFilter($request);
        $transaksi = $transaksiQuery->latest('waktu')->get();

        $labelPeriode = match ($filterType) {
            'bulanan' => $request->filled('bulan') ? Carbon::createFromFormat('Y-m', $request->bulan)->translatedFormat('F Y') : 'Bulan Ini',
            'tahunan' => 'Tahun ' . $request->input('tahun', date('Y')),
            'triwulanan' => 'Triwulan ' . $request->input('triwulan', 1) . ' Tahun ' . $request->input('tahun_triwulan', date('Y')),
            'rentang' => 'Rentang Tanggal',
            default => Carbon::parse($request->input('tanggal', date('Y-m-d')))->translatedFormat('d M Y'),
        };

        $transaksi->transform(function ($item) {
            $lokal = 0;
            $nusantara = 0;
            $mancanegara = 0;

            foreach ($item->details as $det) {
                $nama = strtolower($det->kategoriWisatawan->nama_kategori_wisatawan ?? '');
                $jumlahJiwa = (int) ($det->jumlah_jiwa ?? 0);

                if (str_contains($nama, 'lokal')) {
                    $lokal += $jumlahJiwa;
                } elseif (str_contains($nama, 'nusantara')) {
                    $nusantara += $jumlahJiwa;
                } elseif (str_contains($nama, 'mancanegara') || str_contains($nama, 'asing')) {
                    $mancanegara += $jumlahJiwa;
                }
            }

            $item->sensus_l = $lokal;
            $item->sensus_n = $nusantara;
            $item->sensus_m = $mancanegara;
            $item->sensus_rangkuman = "{$lokal} / {$nusantara} / {$mancanegara}";
            
            return $item;
        });

        return Excel::download(new LaporanTransaksiExport($transaksi, $labelPeriode), 'Laporan-Transaksi-SINEK-PADI.xlsx');
    }
}