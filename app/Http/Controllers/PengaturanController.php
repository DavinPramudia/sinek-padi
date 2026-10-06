<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tarif;

class PengaturanController extends Controller
{
    public function index()
    {
        $tarifs = Tarif::with('kendaraan')->get();

        return view('admin.pengaturan', compact('tarifs'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'harga_tarif' => 'required|numeric|min:0'
        ]);

        $tarif = Tarif::findOrFail($id);
        
        $tarif->update([
            'harga_tarif' => $request->harga_tarif,
        ]);

        return redirect()->back()->with('success', 'Tarif retribusi berhasil diperbarui!');
    }
}