<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Anime Template">
    <meta name="keywords" content="Anime, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Anime | Home</title>

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
                <div class="col-lg-7">
                    <div class="header__nav">
                        <nav class="header__menu mobile-menu">
                            <ul>
                                <li class="active"><a href="/">Homepage</a></li>
                                <li><a href="#">Categories <span class="arrow_carrot-down"></span></a>
                                    <ul class="dropdown">
                                        <li><a href="./genres">Genres</a></li>
                                        <li><a href="#">Blog Details</a></li>
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
                
                {{-- BAGIAN KANAN HEADER (SEARCH & PROFIL + NAMA) --}}
                <div class="col-lg-3">
                    <div class="header__right">
                        <a href="#" class="search-switch"><span class="icon_search"></span></a>
                    
                        @auth
                            <a href="{{ route('profile') }}" style="margin-left: 15px; display: inline-flex; align-items: center; text-decoration: none;">
                                
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

                                {{-- 2. NAMA USERNAME (Logic Warna VIP) --}}
                                @if(Auth::user()->subscription_type == 'VIP')
                                    <span style="color: #ffd700; font-weight: 600; margin-left: 10px; font-size: 14px; text-shadow: 0 0 5px rgba(255, 215, 0, 0.5);">
                                        {{ Auth::user()->name }}
                                    </span>
                                @else
                                    <span style="color: white; font-weight: 600; margin-left: 10px; font-size: 14px;">
                                        {{ Auth::user()->name }}
                                    </span>
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
    <section class="hero">
        <div class="container">
            <div class="hero__slider owl-carousel">
                <div class="hero__items set-bg" data-setbg="{{ asset('img/hero/kaiju.jpg') }}">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="hero__text">
                                <div class="label">Action</div>
                                <h2>Kaiju No.8</h2>
                                <p>After 30 days of travel across the world...</p>
                                <a href="#"><span>Watch Now</span> <i class="fa fa-angle-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="hero__items set-bg" data-setbg="{{ asset('img/hero/SoloLev.png') }}">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="hero__text">
                                <div class="label">Action</div>
                                <h2>Solo Leveling Season 2</h2>
                                <p>After 30 days of travel across the world...</p>
                                <a href="#"><span>Watch Now</span> <i class="fa fa-angle-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="hero__items set-bg" data-setbg="{{ asset('img/hero/saekano.png') }}">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="hero__text">
                                <div class="label">Romance</div>
                                <h2>Saekano</h2>
                                <p>After 30 days of travel across the world...</p>
                                <a href="#"><span>Watch Now</span> <i class="fa fa-angle-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="product spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    
                    <div class="trending__product">
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-sm-8">
                                <div class="section-title">
                                    <h4>Trending Now</h4>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4">
                                <div class="btn__all">
                                    <a href="#" class="primary-btn">View All <span class="arrow_right"></span></a>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="trending-data"></div>
                    </div>

                    <div class="popular__product">
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-sm-8">
                                <div class="section-title">
                                    <h4>Popular Shows</h4>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4">
                                <div class="btn__all">
                                    <a href="#" class="primary-btn">View All <span class="arrow_right"></span></a>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="popular-data"></div>
                    </div>

                    <div class="recent__product">
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-sm-8">
                                <div class="section-title">
                                    <h4>Recently Added Shows</h4>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4">
                                <div class="btn__all">
                                    <a href="#" class="primary-btn">View All <span class="arrow_right"></span></a>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="recent-data"></div>
                    </div>

                    <div class="live__product">
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-sm-8">
                                <div class="section-title">
                                    <h4>Live Action</h4>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4">
                                <div class="btn__all">
                                    <a href="#" class="primary-btn">View All <span class="arrow_right"></span></a>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="live-data"></div>
                    </div>

                </div>

                <div class="col-lg-4 col-md-6 col-sm-8">
                    <div class="product__sidebar">
                        <div class="product__sidebar__view">
                            <div class="section-title">
                                <h5>Top Views</h5>
                            </div>
                            <ul class="filter__controls">
                                <li class="active" data-filter="*">Day</li>
                                <li data-filter=".week">Week</li>
                                <li data-filter=".month">Month</li>
                                <li data-filter=".years">Years</li>
                            </ul>
                            <div class="filter__gallery">
                                <div class="product__sidebar__view__item set-bg mix day years"
                                    data-setbg="{{ asset('img/sidebar/tv-1.jpg') }}">
                                    <div class="ep">18 / ?</div>
                                    <div class="view"><i class="fa fa-eye"></i> 9141</div>
                                    <h5><a href="#">Boruto: Naruto next generations</a></h5>
                                </div>
                                <div class="product__sidebar__view__item set-bg mix month week"
                                    data-setbg="{{ asset('img/sidebar/tv-2.jpg') }}">
                                    <div class="ep">18 / ?</div>
                                    <div class="view"><i class="fa fa-eye"></i> 9141</div>
                                    <h5><a href="#">The Seven Deadly Sins: Wrath of the Gods</a></h5>
                                </div>
                                <div class="product__sidebar__view__item set-bg mix week years"
                                    data-setbg="{{ asset('img/sidebar/tv-3.jpg') }}">
                                    <div class="ep">18 / ?</div>
                                    <div class="view"><i class="fa fa-eye"></i> 9141</div>
                                    <h5><a href="#">Sword art online alicization war of underworld</a></h5>
                                </div>
                                <div class="product__sidebar__view__item set-bg mix years month"
                                    data-setbg="{{ asset('img/sidebar/tv-4.jpg') }}">
                                    <div class="ep">18 / ?</div>
                                    <div class="view"><i class="fa fa-eye"></i> 9141</div>
                                    <h5><a href="#">Fate/stay night: Heaven's Feel I. presage flower</a></h5>
                                </div>
                                <div class="product__sidebar__view__item set-bg mix day"
                                    data-setbg="{{ asset('img/sidebar/tv-5.jpg') }}">
                                    <div class="ep">18 / ?</div>
                                    <div class="view"><i class="fa fa-eye"></i> 9141</div>
                                    <h5><a href="#">Fate stay night unlimited blade works</a></h5>
                                </div>
                            </div>
                        </div>
                        <div class="product__sidebar__comment">
                            <div class="section-title">
                                <h5>New Comment</h5>
                            </div>
                            <div class="product__sidebar__comment__item">
                                <div class="product__sidebar__comment__item__pic">
                                    <img src="{{ asset('img/sidebar/comment-1.jpg') }}" alt="">
                                </div>
                                <div class="product__sidebar__comment__item__text">
                                    <ul>
                                        <li>Active</li>
                                        <li>Movie</li>
                                    </ul>
                                    <h5><a href="#">The Seven Deadly Sins: Wrath of the Gods</a></h5>
                                    <span><i class="fa fa-eye"></i> 19.141 Viewes</span>
                                </div>
                            </div>
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
                        <a href="./index.html"><img src="{{ asset('img/logo2.png') }}" alt="" style="width: 180px;"></a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="footer__nav">
                        <ul>
                            <li class="active"><a href="./index.html">Homepage</a></li>
                            <li><a href="./categories.html">Categories</a></li>
                            <li><a href="./blog.html">Our Blog</a></li>
                            <li><a href="">Contacts</a></li>
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
    
    <script src="{{ asset('js/main.js') }}"></script>

    <script type="text/javascript"
        src="https://app.sandbox.midtrans.com/snap/snap.js" 
        data-client-key="Mid-client-_HnWFmEfaDl1oRr1"></script>

</body>

</html>