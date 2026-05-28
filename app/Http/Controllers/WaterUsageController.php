<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WaterUsageController extends Controller
{
    // Admin: semua pengguna
    public function adminIndex(Request $request)
    {
        $search = $request->input('search');

        $penggunas = Pengguna::withSum('tagihans', 'jumlah')
            ->withCount('tagihans')
            ->when($search, fn($q) => $q->where('nama', 'like', "%{$search}%"))
            ->paginate(10)
            ->withQueryString();

        return view('admin.waterusage.index', compact('penggunas'));
    }

    // Admin: detail per pengguna
    public function adminShow($id)
    {
        $pengguna = Pengguna::findOrFail($id);
        $tagihans = Tagihan::where('pengguna_id', $id)
            ->orderByDesc('tahun')
            ->orderByDesc('bulan')
            ->get();

        return view('admin.waterusage.show', compact('pengguna', 'tagihans'));
    }

    // User: pemakaian milik sendiri
    public function userIndex()
    {
        $user     = Auth::guard('web')->user();
        $tagihans = Tagihan::where('pengguna_id', $user->id)
            ->orderByDesc('tahun')
            ->orderByDesc('bulan')
            ->get();

        $totalPemakaian = $tagihans->sum('jumlah');

        return view('pengguna.waterusage.index', compact('tagihans', 'totalPemakaian'));
    }
}
