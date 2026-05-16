<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tagihan;
use Illuminate\Support\Facades\Auth;

class PembayaranController extends Controller
{
    public function index()
    {
        $userId = Auth::user()->id;
        $tagihans = Tagihan::where('pengguna_id', $userId)->orderByDesc('tahun')->orderByDesc('bulan')->paginate(10);

        return view('pengguna.infobayar', compact('tagihans'));
    }
}
