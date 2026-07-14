<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Anime Template">
    <meta name="keywords" content="Anime, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>Watching | {{ $anime->title ?? 'Anime' }}</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

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

    <style>
        /* 1. Batasi lebar slider volume biar gak kepanjangan */
        .anime__video__player .plyr__volume input[type=range] {
            max-width: 70px !important; 
            min-width: 50px !important;
        }

        /* 2. Geser Posisi Waktu (Menit) lebih ke kanan */
        .anime__video__player .plyr__controls .plyr__controls__item.plyr__time {
            left: 180px !important; 
            z-index: 99 !important;
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
                <div class="col-lg-8">
                    <div class="header__nav">
                        <nav class="header__menu mobile-menu">
                            <ul>
                                <li><a href="/">Homepage</a></li>
                                <li class="active"><a href="#">Categories <span class="arrow_carrot-down"></span></a>
                                    <ul class="dropdown">
                                        <li><a href="./genres">Genres</a></li>
                                        <li><a href="/n;oh.html">Blog Details</a></li>
                                        <li><a href="/signup">Sign Up</a></li>
                                        <li><a href="/login">Login</a></li>
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
                                <li><a href="/contact">Contacts</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="col-lg-2">
                    
                    {{-- UPDATE: Bagian Kanan Header Sekarang Pakai Foto Profil --}}
                    <div class="header__right">
                        <a href="#" class="search-switch"><span class="icon_search"></span></a>
                    
                        @auth
                            <a href="{{ route('profile') }}" style="margin-left: 15px; display: inline-block; vertical-align: middle;">
                                
                                @if(Auth::user()->avatar)
                                    <img src="{{ asset(Auth::user()->avatar) }}" 
                                         alt="Profile" 
                                         style="width: 35px; height: 35px; border-radius: 50%; object-fit: cover; border: 2px solid #fff;">
                                
                                @else
                                    <div style="width: 35px; height: 35px; background: #e53637; border-radius: 50%; color: #fff; text-align: center; line-height: 35px; font-weight: bold; font-size: 18px; border: 2px solid #fff;">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </div>
                                @endif
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
                        <a href="#">Categories</a>
                        <a href="#">Watching</a>
                        <span id="watchBreadcrumbTitle">{{ $anime->title ?? 'Loading...' }}</span> 
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="anime-details spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="anime__video__player">
                        {{-- PHP menyiapkan video awal (default episode 1 atau sesuai URL) --}}
                        @php
                            $init_ep = request()->query('ep', 1);
                            $init_ep_str = str_pad($init_ep, 2, '0', STR_PAD_LEFT); 
                            $init_video_url = asset('videos/' . $anime->id . '/ep-' . $init_ep_str . '.mp4');
                        @endphp

                        <video id="player" playsinline controls data-poster="{{ $anime->image ?? asset('videos/anime-watch.jpg') }}">
                            <source src="{{ $init_video_url }}" type="video/mp4" />
                            <track kind="captions" label="English captions" src="#" srclang="en" default />
                        </video>

                        <div class="anime__details__download" style="margin-top: 20px;">
                            <p style="color: white;">Unduh Episode Saat Ini:</p>
                            <a href="{{ $init_video_url }}" id="customDownloadLink" class="site-btn" download>
                                <i class="fa fa-download"></i> Download Ep {{ $init_ep }}
                            </a>
                        </div>
                    </div>
                    
                    <div class="section-title">
                        <h5>List Episode</h5>
                    </div>
                    
                    <div class="anime__details__episodes" id="episodeListContainer">
                        {{-- Loop dari 1 sampai Total Episode --}}
                        @for($i = 1; $i <= $anime->total_episodes; $i++) 
                            
                            @php
                                $isLocked = false;
                                // Logika Kunci: Jika Ep > 3 DAN (User tidak login ATAU Status Free)
                                if ($i > 3) {
                                    if (!Auth::check() || Auth::user()->subscription_type == 'Free') {
                                        $isLocked = true;
                                    }
                                }

                                $ep_num_str = str_pad($i, 2, '0', STR_PAD_LEFT); 
                                $video_url = asset('videos/' . $anime->id . '/ep-' . $ep_num_str . '.mp4');
                                $file_name = $anime->title . ' - Eps ' . $ep_num_str . '.mp4';

                                // Cek Style Tombol Aktif
                                $curr = request()->query('ep', 1);
                                $isActiveClass = ($curr == $i) ? 'active-episode' : '';
                                $btnStyle = ($curr == $i) ? 'background: #e53637; color: #fff;' : 'background: #333; color: #fff;';
                            @endphp

                            @if($isLocked)
                                <a href="javascript:void(0);" class="vip-trigger" 
                                   style="margin-right: 10px; margin-bottom: 10px; display:inline-block; padding: 10px 20px; background: #222; color: #999; border-radius: 4px; cursor: pointer;">
                                    Ep {{ $i }} <i class="fa fa-lock"></i>
                                </a>
                            @else
                                <a href="javascript:void(0);" 
                                   class="site-btn play-episode {{ $isActiveClass }}" 
                                   data-video="{{ $video_url }}"
                                   data-episode="{{ $i }}"
                                   data-filename="{{ $file_name }}"
                                   style="margin-right: 10px; margin-bottom: 10px; {{ $btnStyle }}">
                                    Ep {{ $i }}
                                </a>
                            @endif

                        @endfor
                    </div>
                    </div>
            </div>
            
            <div class="row">
                <div class="col-lg-8 col-md-8">
                    {{-- Reviews Section --}}
                    <div class="anime__details__review">
                        <div class="section-title">
                            <h5>Reviews (<span id="reviewCount">{{ isset($reviews) ? count($reviews) : 0 }}</span>)</h5>
                        </div>
                        <div id="reviewContainer">
                            @if(isset($reviews) && count($reviews) > 0)
                                @foreach($reviews as $review)
                                    <div class="anime__review__item">
                                        <div class="anime__review__item__pic">
                                            <img src="{{ $review->avatar ? asset($review->avatar) : asset('img/anime/review-1.jpg') }}" alt="User Avatar" style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
                                        </div>
                                        <div class="anime__review__item__text">
                                            <h6>
                                                {{ $review->name }} - 
                                                <span>{{ \Carbon\Carbon::parse($review->created_at)->diffForHumans() }}</span>
                                            </h6>
                                            <p>{{ $review->comment }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div id="no-review-msg" class="alert alert-dark text-white">
                                    Belum ada ulasan. Jadilah yang pertama berkomentar!
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Comment Form --}}
                    <div class="anime__details__form">
                        <div class="section-title">
                            <h5>Your Comment</h5>
                        </div>
                        @auth
                            <form id="commentForm">
                                @csrf
                                <input type="hidden" name="anime_id" value="{{ $anime->id ?? '' }}">
                                <textarea name="comment" placeholder="Tulis komentar kamu disini..." required></textarea>
                                <button type="submit"><i class="fa fa-location-arrow"></i> Review</button>
                            </form>
                        @else
                            <div class="anime__details__form">
                                <div class="alert alert-warning" role="alert">
                                    Silakan <a href="/login.html" style="font-weight: bold; color: #e53637;">Login</a> terlebih dahulu untuk menulis komentar.
                                </div>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="page-up">
            <a href="#" id="scrollToTopButton"><span class="arrow_carrot-up"></span></a>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="footer__logo">
                        <a href="/"><img src="{{ asset('img/logo2.png') }}" alt="" style="width: 180px;"></a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="footer__nav">
                        <ul>
                            <li class="active"><a href="/">Homepage</a></li>
                            <li><a href="#">Categories</a></li>
                            <li><a href="#">Our Blog</a></li>
                            <li><a href="/contact">Contacts</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3">
                    <p>Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved</p>
                </div>
            </div>
        </div>
    </footer>

    <div class="search-model">
        <div class="h-100 d-flex align-items-center justify-content-center flex-column">
            <div class="search-close-switch"><i class="icon_close"></i></div>
            <form class="search-model-form">
                <input type="text" id="search-input" placeholder="Cari anime disini....." autocomplete="off">
            </form>
            <div class="container" style="margin-top: 50px; height: 60vh; overflow-y: auto;">
                 <div class="row" id="search-result-container"></div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/player.js') }}"></script>
    <script src="{{ asset('js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('js/mixitup.min.js') }}"></script>
    <script src="{{ asset('js/jquery.slicknav.js') }}"></script>
    <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        window.AppConfig = {
            // Mengambil episode awal dari URL (default 1)
            initialEpisode: {{ request()->query('ep', 1) }},
            // Status apakah user sudah login
            isUserLoggedIn: {{ Auth::check() ? 'true' : 'false' }},
            // Status apakah user sudah VIP
            isUserVIP: {{ (Auth::check() && Auth::user()->subscription_type == 'VIP') ? 'true' : 'false' }},
            // Judul anime
            animeTitle: "{{ $anime->title ?? 'Anime' }}"
        };
    </script>
    
    <script src="{{ asset('js/main.js') }}"></script>

    <script type="text/javascript"
        src="https://app.sandbox.midtrans.com/snap/snap.js" 
        data-client-key="Mid-client-_HnWFmEfaDl1oRr1"></script>

</body>
</html>