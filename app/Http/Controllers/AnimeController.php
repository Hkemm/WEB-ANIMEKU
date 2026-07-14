<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail; // WAJIB ADA UNTUK KIRIM EMAIL
use App\Models\User;

class AnimeController extends Controller
{
    // ==========================================
    // --- HALAMAN PUBLIC & API ---
    // ==========================================

    public function index() {
        return view('index');
    }

    public function getAnimeData() {
        $rawAnime = DB::table('anime')->get();
        
        $formattedAnime = $rawAnime->map(function ($item) {
            return [
                'id'            => $item->id,
                'title'         => $item->title,
                'japan'         => $item->japan_title,
                'image'         => $item->image,
                'genres'        => explode(', ', $item->genres ?? ""), 
                'description'   => $item->description,
                'totalEpisodes' => $item->total_episodes,
                'videoSource'   => $item->video_source,
                'tags'          => explode(', ', $item->tags ?? ""),
                'ep'            => $item->current_ep,
                'view'          => $item->view_count,
                'type'          => $item->type,
                'studio'        => $item->studio,
                'dateAired'     => $item->date_aired,
                'status'        => $item->status,
                'score'         => $item->score,
                'rating'        => $item->rating,
                'duration'      => $item->duration
            ];
        });

        return response()->json($formattedAnime);
    }

    public function details(Request $request) {
        $id = (int) $request->query('id');

        if (!$id) {
            return redirect('/');
        }

        $anime = DB::table('anime')->where('id', $id)->first();
        if (!$anime) {
            return redirect('/')->with('error', 'Anime tidak ditemukan.');
        }

        $bookmarkedAnimeIds = [];
        if (Auth::check()) {
            $bookmarkedAnimeIds = DB::table('bookmarks')
                ->where('user_id', Auth::id())
                ->pluck('anime_id')
                ->toArray();
        }

        $reviews = DB::table('reviews')
            ->join('users', 'reviews.user_id', '=', 'users.id')
            ->where('reviews.anime_id', $id)
            ->select('reviews.*', 'users.name', 'users.avatar')
            ->orderBy('reviews.created_at', 'desc')
            ->get();

        return view('anime-details', [
            'id' => $id,
            'anime' => $anime,
            'userBookmarks' => $bookmarkedAnimeIds,
            'reviews' => $reviews
        ]);
    }

    public function watching(Request $request) {
        $id = (int) $request->query('id');
        // Ambil episode dari URL, kalau gak ada otomatis set ke 1
        $current_ep = (int) $request->query('ep', 1);

        if (!$id) {
            return redirect('/');
        }

        $anime = DB::table('anime')->where('id', $id)->first();
        if (!$anime) {
            return redirect('/')->with('error', 'Anime tidak ditemukan.');
        }

        // ==========================================
        // 🔒 LOGIKA SATPAM (LOCK EPISODE 4+)
        // ==========================================
        if ($current_ep > 3) {
            // 1. Cek Login
            if (!Auth::check()) {
                // Kalau belum login, tendang balik dan kasih pesan
                return redirect()->back()->with('error', 'Episode 4 ke atas khusus member! Silakan Login dulu.');
            }

            // 2. Cek Status Subscription (Sesuai database abang: subscription_type)
            $user = Auth::user();
            if ($user->subscription_type == 'Free') { //
                // Kalau login tapi masih Free, tendang balik suruh bayar
                return redirect()->back()->with('error', '🔒 Episode terkunci! Upgrade Premium untuk lanjut nonton.');
            }
        }
        // ==========================================

        $reviews = DB::table('reviews')
            ->join('users', 'reviews.user_id', '=', 'users.id')
            ->where('reviews.anime_id', $id)
            ->select('reviews.*', 'users.name', 'users.avatar')
            ->orderBy('reviews.created_at', 'desc')
            ->get();

        return view('anime-watching', [
            'id' => $id,
            'anime' => $anime,
            'reviews' => $reviews,
            'current_ep' => $current_ep // Kita kirim data episode berapa yg lagi diputar
        ]);
    }

    public function login() {
         return view('login');
    }

    public function signup() {
        return view('signup');
    }

    // ==========================================
    // --- LOGIKA AUTHENTICATION ---
    // ==========================================

    public function processRegister(Request $request)
    {
        $request->validate([
            'email'    => 'required|email|unique:users,email',
            'name'     => 'required|min:3',
            'password' => 'required|min:6'
        ]);

        try {
            $randomNumber = rand(1, 6);
            $randomAvatar = 'img/anime/review-' . $randomNumber . '.jpg';

            User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'role'     => 'user',
                'avatar'   => $randomAvatar
            ]);

            return response()->json(['status' => 'success', 'message' => 'Registrasi Berhasil!']);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error', 
                'message' => 'Database Error: ' . $e->getMessage() 
            ]);
        }
    }

    public function processLogin(Request $request)
    {
        $request->validate([
            'login'    => 'required', 
            'password' => 'required'
        ]);

        $loginType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        $credentials = [
            $loginType => $request->login,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();
            $msg = ($user->role == 'admin') ? 'Login Admin Berhasil!' : 'Login Berhasil!';
            return response()->json(['status' => 'success', 'message' => $msg]);
        }

        return response()->json(['status' => 'error', 'message' => 'Username/Email atau Password salah!']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    // ==========================================
    // --- USER PROFILE, BOOKMARK & COMMENT ---
    // ==========================================

    public function profile() {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();

        try {
            $favorites = DB::table('bookmarks')
                ->join('anime', 'bookmarks.anime_id', '=', 'anime.id')
                ->where('bookmarks.user_id', $user->id)
                ->select('anime.*')
                ->get();
        } catch (\Exception $e) {
            $favorites = [];
        }

        return view('profile', [
            'user' => $user,
            'favorites' => $favorites
        ]);
    }

    public function updateProfile(Request $request) {
        $user = Auth::user(); 

        if (!$user) {
            return redirect('/login')->with('error', 'Sesi habis.');
        }

        $request->validate([
            'name' => 'required|min:3|max:50',
            'password' => 'nullable|min:6|confirmed',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048' 
        ]);

        try {
            /** @var \App\Models\User $user */
            $user->name = $request->name;

            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            if ($request->hasFile('avatar')) {
                if ($user->avatar && strpos($user->avatar, 'uploads/avatars') !== false) {
                    $oldPath = public_path($user->avatar);
                    if (file_exists($oldPath)) {
                        @unlink($oldPath);
                    }
                }

                $file = $request->file('avatar');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/avatars'), $filename);
                $user->avatar = 'uploads/avatars/' . $filename;
            }

            $user->save();
            return redirect()->back()->with('success', 'Profil berhasil diperbarui!');

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['msg' => 'Gagal Update: ' . $e->getMessage()]);
        }
    }

    public function deleteAvatar() {
        $user = Auth::user();

        if (!$user) {
            return redirect('/login');
        }

        // Hapus file fisik jika bukan default
        if ($user->avatar && strpos($user->avatar, 'uploads/avatars') !== false) {
            $filePath = public_path($user->avatar);
            if (file_exists($filePath)) {
                @unlink($filePath);
            }
        }

        // Reset ke Random Anime
        $randomNumber = rand(1, 6);
        /** @var \App\Models\User $user */
        $user->avatar = 'img/anime/review-' . $randomNumber . '.jpg';
        
        $user->save();

        return redirect()->back()->with('success', 'Foto profil berhasil dihapus dan di-reset!');
    }

    public function toggleBookmark(Request $request) {
        if (!Auth::check()) {
            return response()->json(['status' => 'error', 'message' => 'Silakan Login Terlebih Dahulu!']);
        }

        $userId = Auth::id();
        $animeId = $request->input('anime_id'); 

        if(!$animeId) {
             return response()->json(['status' => 'error', 'message' => 'ID Anime tidak valid']);
        }

        try {
            $exist = DB::table('bookmarks')
                        ->where('user_id', $userId)
                        ->where('anime_id', $animeId)
                        ->first();

            if ($exist) {
                DB::table('bookmarks')->where('id', $exist->id)->delete();
                return response()->json(['status' => 'removed', 'message' => 'Dihapus dari favorit']);
            } else {
                DB::table('bookmarks')->insert([
                    'user_id' => $userId,
                    'anime_id' => $animeId,
                    'created_at' => now()
                ]);
                return response()->json(['status' => 'added', 'message' => 'Ditambahkan ke favorit']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Database Error: ' . $e->getMessage()]);
        }
    }

    public function postComment(Request $request) {
        if (!Auth::check()) {
            return response()->json(['status' => 'error', 'message' => 'Harap login untuk berkomentar.']);
        }

        $validator = Validator::make($request->all(), [
            'anime_id' => 'required|integer',
            'comment' => 'required|string|max:500'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => 'Komentar tidak valid atau terlalu panjang.']);
        }

        try {
            DB::table('reviews')->insert([
                'user_id' => Auth::id(),
                'anime_id' => $request->anime_id,
                'comment' => $request->comment,
                'created_at' => now()
            ]);

            $user = Auth::user();
            $avatarUrl = $user->avatar ? asset($user->avatar) : asset('img/anime/review-1.jpg');

            return response()->json([
                'status' => 'success', 
                'message' => 'Komentar berhasil dikirim!',
                'data' => [
                    'name' => $user->name,
                    'avatar' => $avatarUrl,
                    'comment' => $request->comment,
                    'date' => 'Baru saja'
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Gagal mengirim komentar: ' . $e->getMessage()]);
        }
    }

    // ==========================================
    // --- FITUR LUPA PASSWORD (OTP) ---
    // ==========================================

    public function sendOtp(Request $request) {
        $request->validate(['email' => 'required|email']);

        // 1. Cek apakah user ada di tabel users
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'Email tidak terdaftar!']);
        }

        // 2. Generate OTP
        $otp = rand(100000, 999999);

        // 3. Simpan ke tabel 'otp_resets' (Hapus dulu OTP lama biar gak numpuk)
        try {
            DB::table('otp_resets')->where('email', $request->email)->delete();
            
            DB::table('otp_resets')->insert([
                'email' => $request->email,
                'otp' => $otp,
                'expires_at' => now()->addMinutes(15), // Berlaku 15 menit
                'created_at' => now()
            ]);

            // 4. Kirim Email
            Mail::raw("Halo $user->name,\n\nKode OTP reset password kamu adalah: $otp\n\nBerlaku selama 15 menit.\nJangan berikan kode ini kepada siapapun.", function ($message) use ($user) {
                $message->to($user->email)
                        ->subject('Kode OTP Reset Password - AnimeKu');
            });

            return response()->json(['status' => 'success', 'message' => 'Kode OTP telah dikirim ke email Anda!']);
            
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Gagal mengirim email: ' . $e->getMessage()]);
        }
    }

    public function resetPassword(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|numeric',
            'password' => 'required|min:6'
        ]);

        // 1. Cek OTP di tabel 'otp_resets'
        $resetData = DB::table('otp_resets')
                        ->where('email', $request->email)
                        ->where('otp', $request->otp)
                        ->first();

        if (!$resetData) {
            return response()->json(['status' => 'error', 'message' => 'Kode OTP salah atau tidak ditemukan!']);
        }

        // 2. Cek Kadaluarsa
        if (now()->greaterThan($resetData->expires_at)) {
            return response()->json(['status' => 'error', 'message' => 'Kode OTP sudah kadaluarsa. Minta ulang kode.']);
        }

        // 3. Update Password User
        $user = User::where('email', $request->email)->first();
        if ($user) {
            $user->password = Hash::make($request->password);
            $user->save();
        }

        // 4. Hapus OTP yang sudah dipakai
        DB::table('otp_resets')->where('email', $request->email)->delete();

        return response()->json(['status' => 'success', 'message' => 'Password berhasil diubah! Silakan login.']);
    }

    // ==========================================
    // --- FITUR ADMIN ---
    // ==========================================

    public function admin() {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect('/login')->with('error', 'Anda bukan Admin!');
        }
        
        try {
            $anime = DB::table('anime')->orderBy('id', 'desc')->get();
            return view('admin.index', ['anime' => $anime]);
        } catch (\Exception $e) {
            return "Tabel 'anime' belum dibuat di database.";
        }
    }

    public function edit($id) {
        $data = DB::table('anime')->where('id', $id)->first();
        if(!$data) return redirect()->back()->with('error', 'Anime tidak ditemukan');
        return view('admin.edit', ['anime' => $data]);
    }

    public function update(Request $request, $id) {
        $request->validate([
            'title' => 'required',
            'image' => 'required',
        ]);

        DB::table('anime')->where('id', $id)->update([
            'title'          => $request->title,
            'japan_title'    => $request->japan_title,
            'image'          => $request->image,
            'genres'         => $request->genres,
            'description'    => $request->description,
            'total_episodes' => $request->total_episodes,
            'current_ep'     => $request->current_ep,
            'studio'         => $request->studio,
            'status'         => $request->status,
            'score'          => $request->score,
            'rating'         => $request->rating,
            'duration'       => $request->duration,
            'date_aired'     => $request->date_aired,
            'video_source'   => $request->video_source,
            'tags'           => $request->tags,
        ]);

        return redirect()->back()->with('success', 'Data berhasil diupdate!');
    }

    public function delete($id) {
        DB::table('anime')->where('id', $id)->delete();
        return redirect()->back()->with('success', 'Data dihapus!');
    }
    
    // ==========================================
    // --- FITUR GENRE & PENCARIAN ---
    // ==========================================

    public function listGenres(Request $request)
    {
        $genre = $request->query('genre'); 
        $query = DB::table('anime');

        if ($genre) {
            $query->where('genres', 'LIKE', '%' . $genre . '%');
        }

        $results = $query->orderBy('id', 'desc')->get();

        return view('genres', [
            'animeList' => $results,
            'genre'     => $genre
        ]);
    }

    public function search(Request $request) {
        return view('index'); 
    }
}