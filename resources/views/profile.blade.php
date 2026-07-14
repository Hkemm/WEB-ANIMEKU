<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Anime Template">
    <meta name="keywords" content="Anime, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Anime | Profil Saya</title>

    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Mulish:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/elegant-icons.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/plyr.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/nice-select.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/slicknav.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" type="text/css">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        .profile__card {
            background: #0b0c2a;
            padding: 30px;
            border-radius: 5px;
            margin-bottom: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .profile__avatar img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid #e53637;
            margin-bottom: 15px;
        }
        .profile__info label {
            color: #b7b7b7;
            font-size: 14px;
            margin-bottom: 5px;
            display: block;
        }
        .profile__info h5 {
            color: #fff;
            margin-bottom: 20px;
            font-weight: 600;
        }
        .input__item input {
            background: #ffffff;
            border: none;
            color: #000;
            padding-left: 20px;
            border-radius: 2px;
            height: 50px;
            width: 100%;
            margin-bottom: 20px;
        }
        /* Style untuk Tab Navigasi */
        .nav-pills .nav-link {
            color: #b7b7b7;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            background: rgba(255, 255, 255, 0.05);
            margin-right: 10px;
            border-radius: 4px;
        }
        .nav-pills .nav-link.active {
            background-color: #e53637 !important;
            color: #fff !important;
        }
        .nav-pills .nav-link:hover {
            color: #fff;
            background: rgba(255, 255, 255, 0.1);
        }
        /* Style Modal */
        .modal-content {
            background-color: #0b0c2a;
            border: 1px solid #e53637;
            color: white;
        }
        .modal-header, .modal-footer {
            border-color: #333;
        }
        
        /* TOMBOL LOGOUT FLOATING */
        .floating-logout {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 9999;
            background: #e53637; 
            color: #fff;
            border: none;
            border-radius: 50px;
            padding: 15px 25px;
            font-size: 14px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            box-shadow: 0 4px 15px rgba(229, 54, 55, 0.4);
            transition: all 0.3s ease;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px; 
        }

        .floating-logout:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(229, 54, 55, 0.6);
            background: #ff4d4d;
        }

        .floating-logout i {
            font-size: 18px;
        }
    </style>
</head>

<body>
    <div id="preloder">
        <div class="loader"></div>
    </div>

    @include('partials.vip-overlay')

    <header class="header">
        <div class="container">
            <div class="row">
                <div class="col-lg-2">
                    <div class="header__logo">
                        <a href="/">
                            <img src="{{ asset('img/logo2.png') }}" alt="" style="width: 100px;">
                        </a>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="header__nav">
                        <nav class="header__menu mobile-menu">
                            <ul>
                                <li><a href="/">Homepage</a></li>
                                <li><a href="#">Categories <span class="arrow_carrot-down"></span></a>
                                    <ul class="dropdown">
                                        <li><a href="./genres">Genres</a></li>
                                        <li><a href="#">Blog Details</a></li>
                                        <li><a href="#">Sign Up</a></li>
                                        <li><a href="#">Login</a></li>
                                    </ul>
                                </li>
                                <li>
                                    @auth
                                        {{-- LOGIKA JIKA USER SUDAH LOGIN --}}
                                        @if(Auth::user()->subscription_type == 'VIP')
                                            {{-- SUDAH VIP: Tampilkan Emas + Mahkota --}}
                                            <a href="javascript:void(0);" style="color: #ffd700; text-shadow: 0 0 10px rgba(255, 215, 0, 0.5); cursor: default;">
                                                VIP <i class="fa-solid fa-crown"></i>
                                            </a>
                                        @else
                                            {{-- BELUM VIP --}}
                                            <a href="#" id="vip-btn" class="vip-mobile-fix" style="color: white;">
                                                VIP
                                            </a>
                                        @endif
                                    @else
                                        {{-- BELUM LOGIN --}}
                                        <a href="#" id="vip-btn" class="vip-mobile-fix" style="color: white;">
                                            VIP
                                        </a>
                                    @endauth
                                </li>
                                <li class="active"><a href="/profile">My Profile</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
                
                {{-- BAGIAN KANAN HEADER (HANYA FOTO & MAHKOTA, TANPA NAMA) --}}
                <div class="col-lg-3">
                    <div class="header__right">
                        {{-- ICON SEARCH DIHAPUS --}}
                    
                        @auth
                            {{-- margin-left dihapus karena search hilang --}}
                            <a href="{{ route('profile') }}" style="display: inline-flex; align-items: center; text-decoration: none;">
                                
                                {{-- 1. FOTO PROFIL / INISIAL --}}
                                @if(Auth::user()->avatar)
                                    <img src="{{ asset(Auth::user()->avatar) }}" 
                                         alt="Profile" 
                                         style="width: 35px; height: 35px; border-radius: 50%; object-fit: cover; border: 2px solid #fff;">
                                @else
                                    <div style="width: 35px; height: 35px; background: #e53637; border-radius: 50%; color: #fff; text-align: center; line-height: 35px; font-weight: bold; font-size: 18px; border: 2px solid #fff;">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </div>
                                @endif

                                {{-- 2. HANYA MAHKOTA (JIKA VIP), TANPA NAMA --}}
                                @if(Auth::user()->subscription_type == 'VIP')
                                    <span style="color: #ffd700; margin-left: 10px; font-size: 16px; text-shadow: 0 0 5px rgba(255, 215, 0, 0.5);" title="VIP Member">
                                        <i class="fa-solid fa-crown"></i>
                                    </span>
                                @endif
                                
                                {{-- NAMA USERNAME DIHAPUS DARI SINI --}}

                            </a>
                        @else
                            <a href="{{ route('login') }}"><span class="icon_profile"></span></a>
                        @endauth
                    </div>
                </div>

            </div>
            <div id="mobile-menu-wrap"></div>
        </div>
    </header>

    <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href="/"><i class="fa fa-home"></i> Home</a>
                        <span>Profil Saya</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="spad">
        <div class="container">
            <div class="row">
                
                {{-- KARTU PROFIL KIRI --}}
                <div class="col-lg-4">
                    <div class="profile__card text-center">
                        <div class="profile__avatar">
                            @if($user->avatar)
                                <img src="{{ asset($user->avatar) }}" alt="User Avatar">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=e53637&color=fff&size=150" alt="User Avatar">
                            @endif
                        </div>
                        <h4 class="text-white mt-2">{{ $user->name }}</h4>
                        <p class="text-white-50">{{ ucfirst($user->role) }} Member</p>
                        
                        <div class="profile__info text-left mt-4 pl-3">
                            <label>Email Terdaftar:</label>
                            <h5>{{ $user->email }}</h5>
                            <label>Bergabung Sejak:</label>
                            <h5>{{ $user->created_at->format('d M Y') }}</h5>
                        </div>

                        <hr style="border-color: rgba(255,255,255,0.1); margin: 30px 0;">

                        {{-- TOMBOL GANTI FOTO --}}
                        <button type="button" class="site-btn" style="width: 100%; margin-bottom: 10px;" data-toggle="modal" data-target="#uploadModal">
                            GANTI FOTO PROFIL
                        </button>

                        {{-- TOMBOL HAPUS FOTO (Hanya muncul jika sudah upload foto) --}}
                        @if($user->avatar && strpos($user->avatar, 'uploads') !== false)
                            <form action="{{ route('profile.delete.avatar') }}" method="POST" id="deleteAvatarForm">
                                @csrf
                                <button type="button" onclick="confirmDeleteAvatar()" class="site-btn" style="width: 100%; background: transparent; border: 1px solid #e53637; color: #e53637;">
                                    <i class="fa fa-trash"></i> Hapus Foto
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

                {{-- KONTEN TAB KANAN --}}
                <div class="col-lg-8">
                    <div class="profile__card">
                        
                        <ul class="nav nav-pills mb-4" id="pills-tab" role="tablist" style="border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 20px;">
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-favorit-tab" data-toggle="pill" href="#pills-favorit" role="tab">
                                    <i class="fa fa-heart"></i> Favorit Saya
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-edit-tab" data-toggle="pill" href="#pills-edit" role="tab">
                                    <i class="fa fa-cog"></i> Edit Profil
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content" id="pills-tabContent">
                            
                            {{-- TAB FAVORIT --}}
                            <div class="tab-pane fade show active" id="pills-favorit" role="tabpanel">
                                <div class="row">
                                    @if(isset($favorites) && count($favorites) > 0)
                                        @foreach($favorites as $fav)
                                        <div class="col-lg-4 col-md-6 col-sm-6">
                                            <div class="product__item">
                                                <div class="product__item__pic set-bg" data-setbg="{{ $fav->image }}" style="background-image: url('{{ $fav->image }}'); border-radius: 5px;">
                                                    <div class="ep">{{ $fav->current_ep }}</div>
                                                    <div class="view"><i class="fa fa-eye"></i> {{ $fav->view_count }}</div>
                                                </div>
                                                <div class="product__item__text">
                                                    <ul><li>{{ explode(',', $fav->genres)[0] }}</li></ul>
                                                    <h5><a href="/anime-details.html?id={{ $fav->id }}">{{ $fav->title }}</a></h5>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    @else
                                        <div class="col-lg-12 text-center mt-4 mb-4">
                                            <i class="fa fa-folder-open" style="font-size: 40px; color: #333;"></i>
                                            <h5 style="color: #fff; margin-top: 15px;">Belum ada anime favorit.</h5>
                                            <p style="color: #b7b7b7;">Yuk cari anime keren dan klik tombol Love!</p>
                                            <a href="/" class="site-btn mt-2">Cari Anime</a>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{-- TAB EDIT DATA DIRI --}}
                            <div class="tab-pane fade" id="pills-edit" role="tabpanel">
                                <h4 class="text-white mb-3">Edit Data Diri</h4>
                                <form action="{{ route('profile.update') }}" method="POST" id="mainProfileForm">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="input__item">
                                                <label style="color:#fff;">Nama Lengkap</label>
                                                <input type="text" name="name" value="{{ old('name', $user->name) }}" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="input__item">
                                                <label style="color:#fff;">Ganti Password (Opsional)</label>
                                                <input type="password" name="password" placeholder="Kosongkan jika tidak ingin mengganti password">
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="input__item">
                                                <label style="color:#fff;">Konfirmasi Password Baru</label>
                                                <input type="password" name="password_confirmation" placeholder="Ulangi password baru">
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <div class="d-flex justify-content-end align-items-center mt-3 pt-3" style="border-top: 1px solid rgba(255,255,255,0.1);">
                                    <button type="submit" form="mainProfileForm" class="site-btn">SIMPAN PERUBAHAN</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <button type="button" class="floating-logout" onclick="confirmLogout()">
        <i class="fa fa-sign-out"></i> Logout
    </button>

    <form action="{{ route('logout') }}" method="POST" id="logoutForm" style="display: none;">
        @csrf
    </form>

    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="footer__logo">
                        <a href="/"><img src="{{ asset('img/logo2.png') }}" alt="" width="150"></a>
                    </div>
                </div>
                <div class="col-lg-6 text-center">
                    <p class="text-white-50 mt-2">Copyright &copy; All rights reserved</p>
                </div>
            </div>
        </div>
    </footer>

    <div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" style="color: #fff;">Upload Foto Baru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="name" value="{{ $user->name }}">
                        <div class="form-group text-center">
                            <label for="avatarInput" style="color: #b7b7b7; margin-bottom: 15px; display:block;">Pilih Gambar (JPG/PNG)</label>
                            <input type="file" name="avatar" id="avatarInput" class="form-control-file" style="color: #fff; background: #151638; padding: 10px;">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="site-btn">Upload Foto</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    
    <script src="{{ asset('js/player.js') }}"></script>
    <script src="{{ asset('js/mixitup.min.js') }}"></script>
    <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
    
    <script src="{{ asset('js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('js/jquery.slicknav.js') }}"></script>
    
    <script src="{{ asset('js/main.js') }}"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // LOGIC LOGOUT
        function confirmLogout() {
            Swal.fire({
                title: 'Yakin ingin keluar?',
                text: "Anda harus login kembali untuk masuk.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e53637',
                cancelButtonColor: '#333',
                confirmButtonText: 'Ya, Logout!',
                cancelButtonText: 'Batal',
                background: '#0b0c2a',
                color: '#fff'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logoutForm').submit();
                }
            })
        }

        // LOGIC HAPUS FOTO
        function confirmDeleteAvatar() {
            Swal.fire({
                title: 'Hapus Foto Profil?',
                text: "Foto akan dihapus dan kembali ke gambar Anime acak.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#333',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                background: '#0b0c2a',
                color: '#fff'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteAvatarForm').submit();
                }
            })
        }

        @if(session('success'))
            Swal.fire({
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonText: 'OKE',
                background: '#0b0c2a',
                color: '#fff',
                confirmButtonColor: '#e53637'
            });
        @endif

        @if($errors->any())
            let errorMsg = '';
            @foreach($errors->all() as $error)
                errorMsg += '{{ $error }}\n';
            @endforeach
            Swal.fire({
                title: 'Gagal!',
                text: errorMsg,
                icon: 'error',
                confirmButtonText: 'Perbaiki',
                background: '#0b0c2a',
                color: '#fff'
            });
        @endif
    </script>
</body>
</html>