<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengaturanController extends Controller
{
    public function index()
    {
        // Ambil data tarif bergabung dengan nama kendaraan
        $tarifs = DB::table('tarifs')
            ->join('kendaraans', 'tarifs.id_kendaraan', '=', 'kendaraans.id_kendaraan')
            ->select('tarifs.id_tarif', 'tarifs.harga_tarif', 'kendaraans.nama_kendaraan')
            ->get();

        return view('admin.pengaturan', compact('tarifs'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'harga_tarif' => 'required|numeric|min:0'
        ]);

        DB::table('tarifs')
            ->where('id_tarif', $id)
            ->update([
                'harga_tarif' => $request->harga_tarif,
                'updated_at' => now()
            ]);

        return redirect()->back()->with('success', 'Tarif retribusi berhasil diperbarui!');
    }
}