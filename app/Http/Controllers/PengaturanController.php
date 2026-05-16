<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tarif;
use App\Models\Pengaturan;

class PengaturanController extends Controller
{
    public function index()
    {
        $pengaturan = Pengaturan::first();
        $tarif = Tarif::first();
        return view('admin.pengaturan.index', compact('pengaturan', 'tarif'));
    }

    public function updateInfo(Request $request, $id)
    {
        $request->validate([
            'pengaturan' => 'required|string',
        ], [
            'pengaturan.required' => 'Pengaturan tidak boleh kosong',
            'pengaturan.string' => 'Pengaturan harus berupa teks'
        ]);

        $pengaturan = Pengaturan::findOrFail($id);
        $pengaturan->pengaturan = $request->pengaturan;
        $pengaturan->save();

        return redirect()->back()->with('success', 'Informasi berhasil diperbarui.');
    }

    public function updateTarif(Request $request, $id)
    {
        $request->validate([
            'harga' => 'required|numeric',
        ], [
            'harga.required' => 'Harga tidak boleh kosong',
            'harga.numeric' => 'Harga harus berupa angka',
        ]);

        $tarif = Tarif::findOrFail($id);
        $tarif->harga = $request->harga;
        $tarif->save();

        return redirect()->back()->with('success', 'Tarif berhasil diperbarui.');
    }
}
