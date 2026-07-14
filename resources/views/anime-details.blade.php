<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Anime Template">
    <meta name="keywords" content="Anime, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Anime | {{ $anime->title ?? 'Details' }}</title>

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
                                        <li><a href="/blog.html">Blog Details</a></li>
                                        <li><a href="signup">Sign Up</a></li>
                                        <li><a href="/login">Login</a></li>
                                    </ul>
                                </li>
                                <li>
                                    @auth
                                        {{-- LOGIKA JIKA USER SUDAH LOGIN --}}
                                        @if(Auth::user()->subscription_type == 'VIP')
                                            {{-- SUDAH VIP --}}
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
                        <span>Details</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section class="anime-details spad">
        <div class="container">
            
            {{-- Flash Message --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="anime__details__content">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="anime__details__pic set-bg" data-setbg="{{ $anime->image }}">
                            <div class="comment"><i class="fa fa-comments"></i> {{ count($reviews) }}</div>
                            <div class="view"><i class="fa fa-eye"></i> {{ $anime->view_count }}</div>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="anime__details__text">
                            <div class="anime__details__title">
                                <h3>{{ $anime->title }}</h3>
                                <span>{{ $anime->japan_title }}</span>
                            </div>
                            <div class="anime__details__rating">
                                <div class="rating">
                                    <a href="#"><i class="fa fa-star"></i></a>
                                    <a href="#"><i class="fa fa-star"></i></a>
                                    <a href="#"><i class="fa fa-star"></i></a>
                                    <a href="#"><i class="fa fa-star"></i></a>
                                    <a href="#"><i class="fa fa-star-half-o"></i></a>
                                </div>
                                <span>{{ $anime->score }} Votes</span>
                            </div>
                            
                            <p>{{ $anime->description }}</p>
                            
                            <div class="anime__details__widget">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <ul>
                                            <li><span>Type:</span> {{ $anime->type }}</li>
                                            <li><span>Studios:</span> {{ $anime->studio }}</li>
                                            <li><span>Date aired:</span> {{ $anime->date_aired }}</li>
                                            <li><span>Status:</span> {{ $anime->status }}</li>
                                            <li><span>Genre:</span> {{ $anime->genres }}</li>
                                        </ul>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <ul>
                                            <li><span>Scores:</span> {{ $anime->score }}</li>
                                            <li><span>Rating:</span> {{ $anime->rating }}</li>
                                            <li><span>Duration:</span> {{ $anime->duration }}</li>
                                            <li><span>Quality:</span> HD</li>
                                            <li><span>Views:</span> {{ $anime->view_count }}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="anime__details__btn">
                                @php $animeId = $anime->id ?? null; @endphp
                                <a href="#" class="follow-btn" @if($animeId) data-anime-id="{{ $animeId }}" @endif>
                                    <i class="fa fa-heart-o"></i> Follow
                                </a>
                                <a href="/anime-watching.html?id={{ $anime->id }}" class="watch-btn"><span>Watch Now</span> <i class="fa fa-angle-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-8 col-md-8">
                    
                    {{-- 1. DAFTAR KOMENTAR --}}
                    <div class="anime__details__review">
                        <div class="section-title">
                            <h5>Reviews (<span id="reviewCount">{{ count($reviews) }}</span>)</h5>
                        </div>

                        <div id="reviewContainer">
                            @if(count($reviews) > 0)
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

                    {{-- 2. FORM INPUT KOMENTAR --}}
                    <div class="anime__details__form">
                        <div class="section-title">
                            <h5>Your Comment</h5>
                        </div>

                        @auth
                            <form id="commentForm">
                                @csrf
                                <input type="hidden" name="anime_id" value="{{ $anime->id }}">
                                
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
                
                {{-- SIDEBAR --}}
                <div class="col-lg-4 col-md-4">
                    <div class="anime__details__sidebar">
                        <div class="section-title">
                            <h5>you might like...</h5>
                        </div>
                        <div class="product__sidebar__view__item set-bg" data-setbg="{{ asset('img/sidebar/tv-1.jpg') }}">
                            <div class="ep">18 / ?</div>
                            <div class="view"><i class="fa fa-eye"></i> 9141</div>
                            <h5><a href="#">Boruto: Naruto next generations</a></h5>
                        </div>
                        <div class="product__sidebar__view__item set-bg" data-setbg="{{ asset('img/sidebar/tv-2.jpg') }}">
                            <div class="ep">18 / ?</div>
                            <div class="view"><i class="fa fa-eye"></i> 9141</div>
                            <h5><a href="#">The Seven Deadly Sins: Wrath of the Gods</a></h5>
                        </div>
                        <div class="product__sidebar__view__item set-bg" data-setbg="{{ asset('img/sidebar/tv-3.jpg') }}">
                            <div class="ep">18 / ?</div>
                            <div class="view"><i class="fa fa-eye"></i> 9141</div>
                            <h5><a href="#">Sword art online alicization war of underworld</a></h5>
                        </div>
                        <div class="product__sidebar__view__item set-bg" data-setbg="{{ asset('img/sidebar/tv-4.jpg') }}">
                            <div class="ep">18 / ?</div>
                            <div class="view"><i class="fa fa-eye"></i> 9141</div>
                            <h5><a href="#">Fate/stay night: Heaven's Feel I. presage flower</a></h5>
                        </div>
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
                 <div class="row" id="search-result-container">
                 </div>
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
    
    <script type="text/javascript"
        src="https://app.sandbox.midtrans.com/snap/snap.js" 
        data-client-key="Mid-client-_HnWFmEfaDl1oRr1"></script>

    <script>
        // Konversi array PHP ke array JavaScript
        // Jika user belum login, ini akan menjadi array kosong []
        window.userBookmarks = @json($userBookmarks ?? []); 
    </script>
    
    <script>
        (function($){
            $(function(){
                const csrf = $('meta[name="csrf-token"]').attr('content');

                function showMsg(text){
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: text,
                        showConfirmButton: false,
                        timer: 1500
                    });
                }

                // Inisialisasi state tombol jika anime sudah ada di bookmarks
                $('.follow-btn').each(function(){
                    const $btn = $(this);
                    const animeId = $btn.data('anime-id');
                    if(animeId && window.userBookmarks && window.userBookmarks.includes(animeId)){
                        $btn.addClass('followed');
                        $btn.html('<i class="fa fa-heart"></i> Followed');
                    }
                });

                // Klik follow/unfollow
                $(document).on('click', '.follow-btn', function(e){
                    e.preventDefault();
                    const $btn = $(this);
                    const animeId = $btn.data('anime-id');

                    if(!animeId){
                        Swal.fire({
                            position: 'center',
                            icon: 'warning',
                            title: 'Tidak ada anime yang dipilih',
                            showConfirmButton: false,
                            timer: 1400
                        });
                        return;
                    }

                    window.userBookmarks = window.userBookmarks || [];
                    const isFollowed = window.userBookmarks.includes(animeId);

                    if(!isFollowed){
                        // Client-side update
                        window.userBookmarks.push(animeId);
                        $btn.addClass('followed');
                        $btn.html('<i class="fa fa-heart"></i> Followed');
                        showMsg('Anime disimpan ke favorit!');

                        // Server-side request
                        $.ajax({
                            url: '/bookmark/toggle', 
                            method: 'POST',
                            data: { anime_id: animeId, _token: csrf },
                            error: function() {
                                // Revert jika gagal (opsional)
                                window.userBookmarks = window.userBookmarks.filter(id => id != animeId);
                                $btn.removeClass('followed');
                                $btn.html('<i class="fa fa-heart-o"></i> Follow');
                            }
                        });
                    } else {
                        // Client-side update
                        window.userBookmarks = window.userBookmarks.filter(id => id != animeId);
                        $btn.removeClass('followed');
                        $btn.html('<i class="fa fa-heart-o"></i> Follow');
                        showMsg('Anime dihapus dari favorit.');

                        // Server-side request
                        $.ajax({
                            url: '/bookmark/toggle', 
                            method: 'POST', 
                            data: { anime_id: animeId, _token: csrf },
                            error: function() {
                                // Revert jika gagal (opsional)
                                window.userBookmarks.push(animeId);
                                $btn.addClass('followed');
                                $btn.html('<i class="fa fa-heart"></i> Followed');
                            }
                        });
                    }
                });
            });
        })(jQuery);
    </script>

    <script src="{{ asset('js/main.js') }}"></script>

</body>

</html>