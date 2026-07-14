<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Anime Template">
    <meta name="keywords" content="Anime, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Anime | Contacts & Team</title>

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
        /* --- STYLE KHUSUS TEAM CARD --- */
        .team__item {
            background: #0b0c2a;
            padding: 30px 20px;
            border-radius: 10px;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 30px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        .team__item:hover {
            border-color: #e53637;
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(229, 54, 55, 0.2);
        }
        .team__item__pic img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            margin-bottom: 15px;
            border: 3px solid #e53637;
            object-fit: cover;
            padding: 3px;
            background: #ffffff;
        }
        .team__item__text h5 {
            color: #fff;
            font-weight: 700;
            margin-bottom: 5px;
            font-family: 'Oswald', sans-serif;
            text-transform: uppercase;
        }
        .team__item__text span {
            color: #e53637;
            font-size: 14px;
            display: block;
            margin-bottom: 15px;
            font-weight: 600;
            letter-spacing: 1px;
        }
        .team__item__text p {
            color: #b7b7b7;
            font-size: 14px;
            line-height: 1.5;
            margin-bottom: 20px;
        }
        .team__social a {
            display: inline-block;
            color: #ffffff;
            margin: 0 8px;
            font-size: 18px;
            transition: 0.3s;
        }
        .team__social a:hover {
            color: #e53637;
            transform: scale(1.2);
        }

        /* --- STYLE CONTACT FORM --- */
        .contact__form h3 {
            color: #ffffff;
            font-weight: 700;
            margin-bottom: 30px;
        }
        .contact__form input, .contact__form textarea {
            width: 100%;
            background: #ffffff;
            border: none;
            border-radius: 5px;
            margin-bottom: 20px;
            padding-left: 20px;
            color: #000;
        }
        .contact__form input {
            height: 50px;
        }
        .contact__form textarea {
            height: 120px;
            padding-top: 15px;
            resize: none;
        }
        .contact__widget {
            margin-bottom: 30px;
        }
        .contact__widget__item {
            margin-bottom: 30px;
        }
        .contact__widget__item h4 {
            color: #ffffff;
            font-weight: 700;
            margin-bottom: 10px;
        }
        .contact__widget__item p {
            color: #b7b7b7;
            margin-bottom: 0;
        }
        .contact__widget__item span {
            color: #e53637;
            margin-right: 10px;
            font-size: 18px;
        }
        .map {
            height: 450px;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 40px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }
        .map iframe {
            width: 100%;
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
                                        <li><a href="/n;oh.html">Blog Details</a></li>
                                        <li><a href="/signup">Sign Up</a></li>
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
                                <li class="active"><a href="/contact">Contacts</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
                
                {{-- BAGIAN KANAN HEADER --}}
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

                                {{-- 2. NAMA USERNAME --}}
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
    <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href="/"><i class="fa fa-home"></i> Home</a>
                        <span>Contacts & Team</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section class="team spad" style="padding-bottom: 20px;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title text-center">
                        <h4 style="color: #fff; font-size: 32px; font-weight: 700; margin-bottom: 40px;">
                            Meet The <span style="color: #e53637;">Creators</span>
                        </h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="team__item">
                        <div class="team__item__pic">
                            <img src="{{ asset('img/Team/Hakim.jpg') }}" alt="Jekimm">
                        </div>
                        <div class="team__item__text">
                            <h5>Hakim</h5>
                            <span>Backend Developer</span>
                            <p>isien manut laporan.</p>
                            <div class="team__social">
                                <a href="https://www.instagram.com/hkemm__/?igsh=ajUybTR6OXFidHAy&utm_source=qr#"><i class="fa fa-instagram"></i></a>
                                <a href="https://github.com/Hkemm"><i class="fa fa-github"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="team__item">
                        <div class="team__item__pic">
                            <img src="{{ asset('img/Team/blablabla.jpg') }}" alt="Firmas">
                        </div>
                        <div class="team__item__text">
                            <h5>Hilmi</h5>
                            <span>---</span>
                            <p>------</p>
                            <div class="team__social">
                                <a href="#"><i class="fa fa-instagram"></i></a>
                                <a href="#"><i class="fa fa-github"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="team__item">
                        <div class="team__item__pic">
                            <img src="{{ asset('img/Team/nopan.jpg') }}" alt="Nopan">
                        </div>
                        <div class="team__item__text">
                            <h5>Mahendra</h5>
                            <span>isi dewe</span>
                            <p>isi en nkok </p>
                            <div class="team__social">
                                <a href=" https://www.instagram.com/jnsaa__?igsh=emR1ZTF6cHN3OXB4"><i class="fa fa-instagram"></i></a>
                                <a href="https://github.com/Jnsaa26"><i class="fa fa-github"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="team__item">
                        <div class="team__item__pic">
                            <img src="{{ asset('img/Team/firmas.jpg') }}" alt="Bangkai">
                        </div>
                        <div class="team__item__text">
                            <h5>Firmas</h5>
                            <span>Database Engineer</span>
                            <p>manut laporane.</p>
                            <div class="team__social">
                                <a href="https://www.instagram.com/two.fing3r?igsh=MTQ2NmlnaWphMzY4eA=="><i class="fa fa-instagram"></i></a>
                                <a href="https://github.com/dariusatera"><i class="fa fa-github"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <section class="contact spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="contact__content">
                        <div class="contact__address">
                            <div class="contact__widget__item">
                                <h4><span class="icon_pin_alt"></span> Address</h4>
                                <p>Jl. Ketintang, Unesa, Surabaya - Indonesia</p>
                            </div>
                            <div class="contact__widget__item">
                                <h4><span class="icon_phone"></span> Phone</h4>
                                <p>+62 812 3456 7890</p>
                            </div>
                            <div class="contact__widget__item">
                                <h4><span class="icon_mail_alt"></span> Email</h4>
                                <p>support@animeku.com</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6">
                    <div class="contact__form">
                        <h3>Hubungi Kami</h3>
                        
                        {{-- FORM CONTACT YANG BENAR --}}
                        <form id="contactForm">
                            <div class="row">
                                <div class="col-lg-6">
                                    {{-- TAMBAHKAN name="name" --}}
                                    <input type="text" name="name" placeholder="Nama Kamu" required>
                                </div>
                                <div class="col-lg-6">
                                    {{-- TAMBAHKAN name="email" --}}
                                    <input type="email" name="email" placeholder="Email Kamu" required>
                                </div>
                                <div class="col-lg-12">
                                    {{-- TAMBAHKAN name="message" --}}
                                    <textarea name="message" placeholder="Tulis pesan..." required></textarea>
                                    <button type="submit" class="site-btn">KIRIM PESAN</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-12">
                    <div class="map" style="margin-top: 50px;">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3957.382029579893!2d112.72667367600871!3d-7.310892971879017!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7fb705777df33%3A0xae02a64795747514!2sUniversitas%20Negeri%20Surabaya%20-%20Kampus%20Ketintang!5e0!3m2!1sid!2sid!4v1709623847291!5m2!1sid!2sid" 
                            width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
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
                            <li><a href="#">Contacts</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3">
                    <p>Copyright ©<script>document.write(new Date().getFullYear());</script> All rights reserved</p>
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
    
    <script src="{{ asset('js/main.js') }}"></script>

    <script type="text/javascript"
        src="https://app.sandbox.midtrans.com/snap/snap.js" 
        data-client-key="Mid-client-_HnWFmEfaDl1oRr1"></script>

    <script>
        // SweetAlert untuk Form Pesan dengan AJAX/Fetch (PERBAIKAN UTAMA)
        document.getElementById('contactForm').addEventListener('submit', function(e) {
            e.preventDefault(); // Mencegah reload halaman

            // Ambil data dari form
            let formData = new FormData(this);
            
            // Ambil CSRF Token dari meta tag (WAJIB UNTUK LARAVEL)
            let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Tampilkan loading saat proses kirim
            Swal.fire({
                title: 'Mengirim...',
                text: 'Mohon tunggu sebentar.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Kirim data ke route contact.send menggunakan Fetch API
            fetch("{{ route('contact.send') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": csrfToken, // Token keamanan Laravel
                    "Accept": "application/json"
                },
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Gagal mengirim pesan.');
                }
                return response.json();
            })
            .then(data => {
                // Jika sukses (Server merespon sukses)
                Swal.fire({
                    title: 'Pesan Terkirim!',
                    text: 'Terima kasih telah menghubungi kami.',
                    icon: 'success',
                    confirmButtonText: 'OKE',
                    background: '#0b0c2a',
                    color: '#fff',
                    confirmButtonColor: '#e53637'
                }).then(() => {
                    document.getElementById('contactForm').reset(); // Kosongkan form
                });
            })
            .catch(error => {
                // Jika terjadi error
                console.error('Error:', error);
                Swal.fire({
                    title: 'Gagal!',
                    text: 'Terjadi kesalahan saat mengirim pesan. Coba lagi.',
                    icon: 'error',
                    confirmButtonText: 'Tutup',
                    background: '#0b0c2a',
                    color: '#fff'
                });
            });
        });
    </script>

</body>

</html>