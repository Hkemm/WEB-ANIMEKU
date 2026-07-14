<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Controller;

class LoginGoogle extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        // KITA COPOT TRY-CATCH AGAR ERROR ASLINYA KELIHATAN
        
        $googleUser = Socialite::driver('google')->stateless()->user();
        $email      = strtolower(trim($googleUser->getEmail()));

        // Cek data Google (Pastikan tidak kosong)
        if (empty($email)) {
            dd("ERROR: Google tidak memberikan email! Cek akun Google kamu.");
        }

        $user = User::whereRaw('LOWER(email) = ?', [$email])->first();

        if (!$user) {
            // === PROSES CREATE USER BARU ===
            // Kita pakai dd() dulu untuk memastikan kode masuk sini
            // Jika layar berhenti disini, berarti logika Create jalan, tinggal save-nya.
            // Hapus baris dd("MASUK LOGIKA CREATE") ini kalau sudah yakin.
            
            $user = User::create([
                'name'      => $googleUser->getName() ?? 'User Google',
                'email'     => $email,
                'google_id' => $googleUser->getId(),
                'password'  => bcrypt(Str::random(16)),
                'role'      => 'user', 
                // Pastikan tidak ada kolom 'required' lain di database kamu yang belum diisi disini!
            ]);
        } else {
            // === PROSES UPDATE USER LAMA ===
            if ($user->google_id !== $googleUser->getId()) {
                $user->google_id = $googleUser->getId();
                $user->save();
            }
        }

        // Login
        Auth::login($user, true);

        // Cek apakah login berhasil tersimpan di sesi?
        if (!Auth::check()) {
            dd("BAHAYA: Auth::login dijalankan tapi user tidak login. Masalah Sesi/Cookie!");
        }

        return redirect('/')->with('success', 'Login Berhasil!');
    }
}