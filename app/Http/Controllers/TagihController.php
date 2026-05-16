<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tagihan;
use App\Models\Pengguna;
use App\Models\Tarif;

class TagihController extends Controller
{
    public function index(Request $request)
    {
        $limit = $request->input('limit', 10); // Default 10
        $search = $request->input('search');

        $query = Tagihan::with('pengguna')
            ->orderBy('created_at', 'desc');

        if ($search) {
            $query->whereHas('pengguna', function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('id', 'like', "%{$search}%");
            });
        }

        $tagihans = $query->paginate($limit)->withQueryString();

        return view('admin.tagihan.index', compact('tagihans'));
    }

    public function create()
    {
        $penggunas = Pengguna::all();
        $tarif = Tarif::find(1); // Ambil tarif ID 1
        return view('admin.tagihan.create', compact('penggunas', 'tarif'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pengguna_id' => 'required|exists:pengguna,id',
            'bulan' => 'required|string',
            'tahun' => 'required|integer',
            'awal' => 'required|numeric|min:0',
            'akhir' => 'required|numeric|min:0|gte:awal',
            'tarif' => 'required',
        ], [
            'pengguna_id.required' => 'Pengguna wajib dipilih.',
            'pengguna_id.exists' => 'Pengguna yang dipilih tidak ditemukan.',
            'bulan.required' => 'Bulan wajib diisi.',
            'tahun.required' => 'Tahun wajib diisi.',
            'tahun.integer' => 'Tahun harus berupa angka.',
            'awal.required' => 'Angka meteran awal wajib diisi.',
            'awal.numeric' => 'Angka meteran awal harus berupa angka.',
            'awal.min' => 'Angka meteran awal minimal 0.',
            'akhir.required' => 'Angka meteran akhir wajib diisi.',
            'akhir.numeric' => 'Angka meteran akhir harus berupa angka.',
            'akhir.min' => 'Angka meteran akhir minimal 0.',
            'akhir.gte' => 'Angka meteran akhir harus lebih besar atau sama dengan awal.',
            'status.required' => 'Status pembayaran wajib dipilih.',
            'tarif.required' => 'Tarif wajib diisi.',
        ]);

        $jumlah = $request->akhir - $request->awal;
        $tarif = $request->tarif; // Ambil dari input form
        $total_tagihan = ($jumlah * $tarif);

        Tagihan::create([
            'pengguna_id' => $request->pengguna_id,
            'bulan' => $request->bulan,
            'tahun' => $request->tahun,
            'awal' => $request->awal,
            'akhir' => $request->akhir,
            'jumlah' => $jumlah,
            'tarif' => $tarif,
            'tagihan' => $total_tagihan,
            'status' => 'belum lunas', // <- Ditetapkan default
        ]);

        return redirect('tagihan')->with('success', 'Tagihan berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $tagihan = Tagihan::findOrFail($id);
        $penggunas = Pengguna::all(); // ambil semua pengguna untuk dropdown pelanggan
        $tarif = Tarif::first();


        return view('admin.tagihan.edit', compact('tagihan', 'penggunas', 'tarif'));
    }


    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'pengguna_id' => 'required|exists:pengguna,id',
            'bulan' => 'required|string',
            'tahun' => 'required|integer',
            'awal' => 'required|numeric|min:0',
            'akhir' => 'required|numeric|min:0|gte:awal',
            'status' => 'required|in:lunas,belum lunas',
        ], [
            'pengguna_id.required' => 'Pelanggan wajib dipilih.',
            'pengguna_id.exists' => 'Pelanggan yang dipilih tidak ditemukan.',
            'bulan.required' => 'Bulan wajib diisi.',
            'tahun.required' => 'Tahun wajib diisi.',
            'tahun.integer' => 'Tahun harus berupa angka.',
            'awal.required' => 'Meteran awal wajib diisi.',
            'awal.numeric' => 'Meteran awal harus berupa angka.',
            'awal.min' => 'Meteran awal minimal 0.',
            'akhir.required' => 'Meteran akhir wajib diisi.',
            'akhir.numeric' => 'Meteran akhir harus berupa angka.',
            'akhir.min' => 'Meteran akhir minimal 0.',
            'akhir.gte' => 'Meteran akhir harus lebih besar atau sama dengan awal.',
            'status.required' => 'Status pembayaran wajib dipilih.',
            'status.in' => 'Status hanya boleh bernilai lunas atau belum lunas.',
        ]);

        $jumlah = $request->akhir - $request->awal;
        $tarif = $request->tarif;
        $total_tagihan = ($jumlah * $tarif);

        $tagihan = Tagihan::findOrFail($id);
        $tagihan->update([
            'pengguna_id' => $request->pengguna_id,
            'bulan' => $request->bulan,
            'tahun' => $request->tahun,
            'awal' => $request->awal,
            'akhir' => $request->akhir,
            'jumlah' => $jumlah,
            'tarif' => $tarif,
            'tagihan' => $total_tagihan,
            'status' => $request->status,
        ]);

        return redirect('tagihan')->with('success', 'Tagihan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $tagihans = Tagihan::findOrFail($id);
        $tagihans->delete();
        return redirect('/tagihan')->with('success', 'Data Tagihan Berhasil Dihapus');
    }
}
