<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoketController extends Controller
{
    public function index()
    {
        // Mengambil data kategori kendaraan & harga dari tabel 'tarifs' di database
        // (Pastikan tabel 'tarifs' sudah ada di database kamu ya)
        $KategoriKendaraan = DB::table('tarifs')->get(); 

        // Data kategori wisatawan
        $KategoriWisatawan = [
            ['id' => 'lokal', 'label' => 'Lokal Bangka'],
            ['id' => 'nusantara', 'label' => 'Nusantara'],
            ['id' => 'asing', 'label' => 'Mancanegara'],
        ];

        // Menampilkan view halaman loket beserta datanya
        return view('petugas.loket', compact('KategoriKendaraan', 'KategoriWisatawan'));
    }

    public function store(Request $request)
    {
        // Fungsi ini nanti untuk menyimpan transaksi saat tombol cetak diklik
        // Kita isi nanti setelah halamannya berhasil dibuka dengan normal
        return response()->json(['success' => true]);
    }
}