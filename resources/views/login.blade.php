<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Anime Template">
    <meta name="keywords" content="Anime, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta name="csrf-token" content="{{ csrf_token() }}"> 
    <title>Anime | Login</title>

    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Mulish:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/elegant-icons.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/plyr.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/nice-select.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/slicknav.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" type="text/css">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    .google-btn-dark {
    width: 100%;
    padding: 12px;
    background-color: #E53637; /* Warna merah khas tema Anime template */
    border: none;
    border-radius: 4px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: 0.3s;
    color: #ffffff !important; /* Paksa teks putih */
    font-size: 15px;
    font-weight: 700;
    letter-spacing: 1px;
    text-transform: uppercase;
}

.google-btn-dark:hover {
    background-color: #ffffff;
    color: #E53637 !important;
    border: 1px solid #E53637;
}

.google-btn-dark i {
    margin-right: 10px;
    font-size: 18px;
}
</head>

<body>
    <div id="preloder">
        <div class="loader"></div>
    </div>

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
                                <li><a>Categories <span class="arrow_carrot-down"></span></a>
                                    <ul class="dropdown">
                                        <li><a href="./genres">Genres</a></li>
                                        <li><a href="/n;oh.html">Blog Details</a></li>
                                        <li><a href="/signup">Sign Up</a></li>
                                        <li><a href="/login">Login</a></li>
                                    </ul>
                                </li>
                                <li><a href="#">Our Blog</a></li>
                                <li><a href="/contact">Contacts</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="header__right">
                        <a href="#" class="search-switch"><span class="icon_search"></span></a>
                        <a href="/login.html"><span class="icon_profile"></span></a>
                    </div>
                </div>
            </div>
            <div id="mobile-menu-wrap"></div>
        </div>
    </header>

    <section class="normal-breadcrumb set-bg" data-setbg="{{ asset('img/normal-breadcrumb.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="normal__breadcrumb__text">
                        <h2>Login</h2>
                        <p>Welcome to the official Anime blog.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="login spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="login__form">
                        <h3>Login</h3>
                        
                        <form id="loginForm" action="{{ route('login.process') }}" method="POST">
                            @csrf 
                            <div class="input__item">
                                <input type="text" name="login" id="login" placeholder="Email address or Username" required>
                                <span class="icon_mail"></span>
                            </div>
                            <div class="input__item">
                                <input type="password" name="password" id="password" placeholder="Password" required>
                                <span class="icon_lock"></span>
                            </div>
                            <button type="submit" class="site-btn">Login Now</button>
                        </form>
                        
                        <a href="javascript:void(0);" onclick="openForgotModal()" class="forget_pass">Forgot Your Password?</a>
                        
                        <div id="loginMessage" style="margin-top:10px;"></div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="login__register">
                        <h3>Dont’t Have An Account?</h3>
                        <a href="./signup.html" class="primary-btn">Register Now</a>
                    </div>
                </div>
            </div>
            <div class="login__social">
                <div class="row d-flex justify-content-center">
                    <div class="col-lg-6">
                    <div class="login__social__links">
                        <h3>Login With:</h3>
                        
                        <a href="{{ route('google.login') }}" class="google-btn-dark">
                            <i class="fa fa-google"></i> Sign up with Google
                        </a>

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
                        <a href="/">
                            <img src="{{ asset('img/logo2.png') }}" alt="" style="width: 180px;">
                        </a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="footer__nav">
                        <ul>
                            <li class="active"><a href="/">Homepage</a></li>
                            <li><a href="categories.html">Categories</a></li>
                            <li><a href="/blog.html">Our Blog</a></li>
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
        <div class="h-100 d-flex align-items-center justify-content-center">
            <div class="search-close-switch"><i class="icon_close"></i></div>
            <form class="search-model-form">
                <input type="text" id="search-input" placeholder="Search here.....">
            </form>
        </div>
    </div>
    @include('partials.forgot-password')

    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/player.js') }}"></script>
    <script src="{{ asset('js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('js/mixitup.min.js') }}"></script>
    <script src="{{ asset('js/jquery.slicknav.js') }}"></script>
    <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="{{ asset('js/main.js') }}"></script>

</body>

</html>