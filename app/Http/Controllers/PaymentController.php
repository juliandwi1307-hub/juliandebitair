<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tagihan;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;

class PaymentController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
        
        // Memaksa webhook URL agar tidak perlu disetting manual di dashboard
        Config::$overrideNotifUrl = url('/midtrans/callback');
    }

    public function pay($id)
    {
        $tagihan = Tagihan::with('pengguna')->findOrFail($id);

        if ($tagihan->status == 'lunas') {
            return redirect()->back()->with('error', 'Tagihan sudah lunas.');
        }

        if (!$tagihan->snap_token) {
            $params = [
                'transaction_details' => [
                    'order_id' => 'TAGIHAN-' . $tagihan->id . '-' . time(),
                    'gross_amount' => $tagihan->tagihan,
                ],
                'customer_details' => [
                    'first_name' => $tagihan->pengguna->nama ?? 'Pengguna',
                    'phone' => $tagihan->pengguna->no_hp ?? '08123456789',
                ]
            ];

            try {
                $snapToken = Snap::getSnapToken($params);
                $tagihan->snap_token = $snapToken;
                $tagihan->save();
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Gagal memuat pembayaran: ' . $e->getMessage());
            }
        }

        return view('pengguna.bayar', compact('tagihan'));
    }

    public function callback(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);
        
        if ($hashed == $request->signature_key) {
            if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
                $order_id_parts = explode('-', $request->order_id);
                $tagihan_id = $order_id_parts[1] ?? null;
                
                if ($tagihan_id) {
                    $tagihan = Tagihan::find($tagihan_id);
                    if ($tagihan && $tagihan->status !== 'lunas') {
                        $tagihan->status = 'lunas';
                        $tagihan->save();
                    }
                }
            }
        }

        return response()->json(['message' => 'Callback handled']);
    }

    public function cancelPayment($id)
    {
        $tagihan = Tagihan::findOrFail($id);
        
        if ($tagihan->status != 'lunas') {
            // Hapus token lama agar dibuat ulang saat pay() dipanggil
            $tagihan->snap_token = null;
            $tagihan->save();
        }

        return redirect()->route('pembayaran.bayar', $id)->with('success', 'Metode pembayaran direset. Silakan pilih metode pembayaran baru Anda.');
    }
}
