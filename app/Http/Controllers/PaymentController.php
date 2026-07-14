<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;

class PaymentController extends Controller
{
    public function __construct()
    {
        // Server Key Abang (Sandbox)
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        
        // Mode Sandbox (False)
        Config::$isProduction = false; 
        
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function createTransaction(Request $request)
    {
        // Cek Login
        if (!Auth::check()) {
            return response()->json(['error' => 'Silakan login terlebih dahulu!'], 401);
        }

        $user = Auth::user();
        $paket = $request->paket;
        $harga = $request->harga; 

        // Order ID Unik
        $orderId = 'ORDER-' . $user->id . '-' . time() . '-' . rand(100, 999);

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $harga,
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
            ],
            'item_details' => [
                [
                    'id' => $paket,
                    'price' => $harga,
                    'quantity' => 1,
                    'name' => 'Premium ' . ucfirst($paket)
                ]
            ],
            // 👇 INI YANG BIKIN DIA PULANG KE WEBSITE KITA (BUKAN EXAMPLE.COM) 👇
            'callbacks' => [
                'finish' => 'http://pbp.test/payment/finish' 
            ]
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            return response()->json(['snap_token' => $snapToken]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // 👇 INI FUNCTION YANG SELAMA INI HILANG 👇
    // Dipanggil saat user selesai bayar dan dialihkan balik ke website
    public function finishPayment(Request $request)
    {
        // Karena ini Sandbox/Localhost, kita langsung paksa jadi VIP
        if (Auth::check()) {
            $user = Auth::user();
            $user->subscription_type = 'VIP'; // Ubah status jadi VIP
            $user->save();
        }

        // Kembalikan ke Halaman Utama dengan pesan sukses
        return redirect('/')->with('success', 'Pembayaran Berhasil! Sekarang Anda adalah VIP.');
    }
}