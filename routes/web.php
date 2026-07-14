<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnimeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\LoginGoogle; 
use App\Http\Controllers\ContactController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ==========================================
// 0. LOGIN GOOGLE
// ==========================================
// PENTING: Pastikan URL "Authorized redirect URI" di Google Cloud Console adalah:
// http://127.0.0.1:8000/auth/google/callback (atau domain kamu)

// ==========================================
// 0. LOGIN GOOGLE
// ==========================================

// KITA KEMBALIKAN KE 'google.login'
Route::get('/auth/google', [LoginGoogle::class, 'redirect'])->name('google.login');
Route::get('/auth/google/callback', [LoginGoogle::class, 'callback'])->name('google.callback');


// ==========================================
// 1. HALAMAN PUBLIK
// ==========================================

Route::get('/', [AnimeController::class, 'index'])->name('home');
Route::get('/anime-data', [AnimeController::class, 'getAnimeData']);
Route::get('/anime-details.html', [AnimeController::class, 'details'])->name('anime.details');
Route::get('/anime-watching.html', [AnimeController::class, 'watching'])->name('anime.watching');


// ==========================================
// 2. OTENTIKASI (LOGIN/REGISTER MANUAL)
// ==========================================

Route::get('/login.html', [AnimeController::class, 'login'])->name('login');
Route::get('/signup.html', [AnimeController::class, 'signup'])->name('register');

Route::post('/login-process', [AnimeController::class, 'processLogin'])->name('login.process');
Route::post('/register-process', [AnimeController::class, 'processRegister'])->name('register.process');
Route::post('/logout', [AnimeController::class, 'logout'])->name('logout');


// ==========================================
// 3. FITUR USER (BUTUH LOGIN)
// ==========================================

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [AnimeController::class, 'profile'])->name('profile');
    Route::post('/profile/update', [AnimeController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/delete-avatar', [AnimeController::class, 'deleteAvatar'])->name('profile.delete.avatar');

    Route::post('/bookmark/toggle', [AnimeController::class, 'toggleBookmark'])->name('bookmark.toggle');
    Route::post('/anime/comment', [AnimeController::class, 'postComment'])->name('anime.comment');
    
    // Payment
    Route::post('/payment/process', [PaymentController::class, 'createTransaction'])->name('payment.process');
    Route::get('/payment/finish', [PaymentController::class, 'finishPayment'])->name('payment.finish');
});


// ==========================================
// 4. HALAMAN ADMIN
// ==========================================

// Sebaiknya tambahkan middleware 'admin' nanti jika sudah siap
Route::prefix('admin')->group(function () {
    Route::get('/', [AnimeController::class, 'admin'])->name('admin.dashboard');           
    Route::get('/edit/{id}', [AnimeController::class, 'edit'])->name('admin.edit');  
    Route::post('/update/{id}', [AnimeController::class, 'update'])->name('admin.update'); 
    Route::get('/delete/{id}', [AnimeController::class, 'delete'])->name('admin.delete');
});

Route::get('/search', [AnimeController::class, 'search'])->name('anime.search');
Route::get('/genres', [AnimeController::class, 'listGenres'])->name('anime.genres');


// ==========================================
// 5. LUPA PASSWORD
// ==========================================

Route::post('/forgot-password/send-otp', [AnimeController::class, 'sendOtp'])->name('password.otp');
Route::post('/forgot-password/reset', [AnimeController::class, 'resetPassword'])->name('password.reset');


// ==========================================
// 6. DEBUGGING (HAPUS SAAT PRODUCTION)
// ==========================================

Route::get('/cek-php', function () {
    phpinfo();
});

Route::get('/cek-asli', function () {
    $path = php_ini_loaded_file();
    $versi = phpversion();
    
    if (!$path) {
        return "⚠️ GAWAT: File php.ini tidak terdeteksi sama sekali!";
    }
    $content = file_get_contents($path);
    $status = "MISTERIUS";

    if (preg_match('/^\s*extension\s*=\s*curl\s*$/m', $content)) {
        $status = "✅ TULISAN SUDAH BENAR (Tanpa Titik Koma).";
        $solusi = "Masalahnya tinggal RESTART Laragon yang benar.";
    } elseif (preg_match('/^;extension\s*=\s*curl/m', $content)) {
        $status = "❌ MASIH ADA TITIK KOMA (;)";
        $solusi = "Abang belum menghapus titik komanya, atau lupa Save.";
    } else {
        $status = "⚠️ BARIS TIDAK DITEMUKAN";
        $solusi = "Coba cari baris 'extension=curl' dan pastikan ada.";
    }
    echo "<h1>Laporan Detektif PHP</h1>";
    echo "<b>Versi PHP Website:</b> $versi <br>";
    echo "<b>File yang Dipakai:</b> $path <br><br>";
    echo "<b>Status File:</b> $status <br>";
    echo "<b>Solusi:</b> $solusi";
});



// ==========================================
// 7. cotact 
// ==========================================

// Route untuk halaman Contact
Route::get('/contact', function () {
    return view('contact');
})->name('contact');


//untuk mengirim pesan dari form contact
Route::post('/contact/send', [ContactController::class, 'store'])->name('contact.send');