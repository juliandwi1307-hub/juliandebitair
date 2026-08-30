<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\ConnectionSettings;

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

    // Admin: toggle water status
    public function toggleStatus($id)
    {
        $pengguna = Pengguna::findOrFail($id);
        
        $pengguna->water_status = !$pengguna->water_status;
        $pengguna->save();

        try {
            $settings = (new ConnectionSettings)
                ->setUsername(config('mqtt.username'))
                ->setPassword(config('mqtt.password'))
                ->setUseTls(true)
                ->setTlsSelfSignedAllowed(false);

            $mqtt = new MqttClient(config('mqtt.host'), config('mqtt.port'), config('mqtt.client_id') . '_web_' . uniqid());
            $mqtt->connect($settings, true);

            $payload = json_encode([
                'id' => $pengguna->id,
                'status' => $pengguna->water_status ? "True" : "False"
            ]);

            $mqtt->publish('user/watercontrol', $payload, 1);
            $mqtt->disconnect();
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('MQTT Publish Error: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Status air untuk ' . $pengguna->nama . ' berhasil diubah menjadi ' . ($pengguna->water_status ? 'Aktif' : 'Non-Aktif'));
    }
}
