<?php
use App\Models\Transaksi;
use App\Models\DetailWisatawanTransaksi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

public function store(Request $request)
{
    // 1. Validasi keamanan data dari Frontend
    $request->validate([
        'id_tarif'      => 'required',
        'total_bayar'   => 'required|numeric',
        'metode_cetak'  => 'required',
        'qty_wisatawan' => 'required|array',
    ]);

    try {
        // Mulai transaksi database (jika satu gagal, semua dibatalkan)
        DB::beginTransaction();

        // 2. Generate Nomor Karcis Unik (Contoh: TKT-20260728-154321)
        $noKarcis = 'TKT-' . date('Ymd') . '-' . date('His');

        // 3. Simpan ke tabel utama: `transaksis`
        $transaksi = Transaksi::create([
            'no_karcis'     => $noKarcis,
            'total_bayar'   => $request->total_bayar,
            'waktu'         => now(), // Waktu otomatis saat ini
            'id_users'      => Auth::user()->id_users ?? Auth::id(), // ID Kasir yang sedang login
            'id_tarif'      => $request->id_tarif,
            'reprint_count' => 0,
            'metode_cetak'  => $request->metode_cetak,
        ]);

        // 4. Simpan ke tabel anak: `detail_wisatawan_transaksis`
        foreach ($request->qty_wisatawan as $id_kategori => $jumlah_jiwa) {
            // Hanya simpan kategori yang jumlah orangnya lebih dari 0
            if ($jumlah_jiwa > 0) {
                DetailWisatawanTransaksi::create([
                    'id_transaksi' => $transaksi->id_transaksi,
                    'id_kategori'  => $id_kategori,
                    'jumlah_jiwa'  => $jumlah_jiwa,
                ]);
            }
        }

        // Simpan permanen ke database
        DB::commit();

        // 5. Kembalikan jawaban sukses ke Frontend (Alpine.js)
        return response()->json([
            'status'    => 'sukses',
            // url_print ini akan diklik oleh tombol "Cetak Tiket" di Modal
            'url_print' => route('transaksi.cetak', $transaksi->id_transaksi) 
        ]);

    } catch (\Exception $e) {
        // Jika terjadi error, batalkan semua proses simpan
        DB::rollback();
        
        return response()->json([
            'status'  => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
}