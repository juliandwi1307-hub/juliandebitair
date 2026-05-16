<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengguna;
use App\Models\Tagihan;

class DBAdminController extends Controller
{
    public function index()
    {
        // Hitung jumlah pengguna
        $jumlahPengguna = Pengguna::count();

        // Hitung jumlah tagihan yang belum lunas
        $jumlahTagihan = Tagihan::where('status', 'belum lunas')->count();

        return view('admin.dashboard.index', compact('jumlahPengguna', 'jumlahTagihan'));
    }
}
