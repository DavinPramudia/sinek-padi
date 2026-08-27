<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanTransaksiExport;

class LaporanController extends Controller
{
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

    public function index(Request $request)
    {
        if ($request->has('search') && trim($request->input('search')) === '') {
            $request->request->remove('search');
        }

        $filterType = $request->input('filter_type', 'harian');
        $search = $request->input('search');

        $transaksiQuery = Transaksi::with(['details.kategoriWisatawan', 'user', 'tarif.kendaraan'])
                                   ->filter($request);

        $totalTransaksi = (clone $transaksiQuery)->count();
        $totalPendapatan = (clone $transaksiQuery)->sum('total_bayar');
        $labelPeriode = $this->getLabelPeriode($request, $filterType);

        $transaksi = $transaksiQuery->latest('waktu')
                                    ->paginate(5)
                                    ->onEachSide(1)
                                    ->withQueryString();

        return view('admin.laporan-transaksi', compact(
            'totalTransaksi', 'totalPendapatan', 'search', 'transaksi', 'filterType', 'labelPeriode'
        ));
    }

    public function exportExcel(Request $request)
    {
        if ($request->has('search') && trim($request->input('search')) === '') {
            $request->request->remove('search');
        }
        
        $filterType = $request->input('filter_type', 'harian');
        
        $transaksi = Transaksi::with(['details.kategoriWisatawan', 'user', 'tarif.kendaraan'])
                              ->filter($request)
                              ->latest('waktu')
                              ->get();

        $labelPeriode = $this->getLabelPeriode($request, $filterType);

        $namaFilePeriode = match ($filterType) {
            'bulanan'    => 'Bulan-' . ($request->input('bulan') ?: date('Y-m')),
            'tahunan'    => 'Tahun-' . $request->input('tahun', date('Y')),
            'triwulanan' => 'Triwulan-' . $request->input('triwulan', 1) . '-' . $request->input('tahun_triwulan', date('Y')),
            default      => 'Tanggal-' . $request->input('tanggal', date('Y-m-d')),
        };

        $namaFile = "Laporan-Transaksi-SINEK-PADI-{$namaFilePeriode}.xlsx";

        return Excel::download(new LaporanTransaksiExport($transaksi, $labelPeriode), $namaFile);
    }
}