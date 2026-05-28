<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tagihan;
use App\Models\Pengaturan;
use Illuminate\Support\Facades\Auth;

class DBPenggunaController extends Controller
{
    public function index()
    {
        $user = Auth::guard('web')->user();


        // Hitung jumlah tagihan dengan status 'lunas' untuk user ini
        $jumlahLunas = Tagihan::where('pengguna_id', $user->id)
            ->where('status', 'lunas')
            ->count();


        // Hitung jumlah tagihan dengan status 'belum lunas' untuk user ini
        $jumlahBelumLunas = Tagihan::where('pengguna_id', $user->id)
            ->where('status', 'belum lunas')
            ->count();



        $pengaturan = Pengaturan::find(1);
        $informasiAdmin = $pengaturan?->pengaturan ?? 'Belum ada informasi dari admin.';

        $tagihanTerakhir = Tagihan::where('pengguna_id', $user->id)
            ->latest()
            ->first();

        return view('pengguna.index', compact('jumlahLunas', 'jumlahBelumLunas', 'informasiAdmin', 'tagihanTerakhir'));
    }
}
