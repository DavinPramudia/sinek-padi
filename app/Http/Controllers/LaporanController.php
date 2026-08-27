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

        $transaksiQuery = Transaksi::with(['details.kategoriWisatawan', 'user', 'tarif.kendaraan']);

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

        if ($search) {
            $transaksiQuery->where('no_karcis', 'like', "%{$search}%");
        }

        return $transaksiQuery;
    }

    /**
     * FUNGSI BANTUAN UNTUK LABEL PERIODE
     */
    private function getLabelPeriode(Request $request, $filterType)
    {
        return match ($filterType) {
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
    }

    /**
     * Method index
     */
    public function index(Request $request)
    {
        if ($request->has('search') && trim($request->input('search')) === '') {
            $request->request->remove('search');
        }

        $filterType = $request->input('filter_type', 'harian');
        $search = $request->input('search');

        $transaksiQuery = $this->getQueryFilter($request);

        // Data Statistik Kartu Atas
        $totalTransaksi = (clone $transaksiQuery)->count();
        $totalPendapatan = (clone $transaksiQuery)->sum('total_bayar');

        // Label Periode
        $labelPeriode = $this->getLabelPeriode($request, $filterType);

        // Pagination (Tanpa transform manual lagi karena sudah di-handle di Model)
        $transaksi = $transaksiQuery->latest('waktu')
                                    ->paginate(5)
                                    ->onEachSide(1)
                                    ->withQueryString();

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
        if ($request->has('search') && trim($request->input('search')) === '') {
            $request->request->remove('search');
        }
        
        $filterType = $request->input('filter_type', 'harian');
        $transaksiQuery = $this->getQueryFilter($request);
        $transaksi = $transaksiQuery->latest('waktu')->get();

        $labelPeriode = $this->getLabelPeriode($request, $filterType);

        return Excel::download(new LaporanTransaksiExport($transaksi, $labelPeriode), 'Laporan-Transaksi-SINEK-PADI.xlsx');
    }
}