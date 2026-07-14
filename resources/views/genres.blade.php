<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Anime Template">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anime | {{ $genre ?? 'Genre List' }}</title>

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <style>
        .product__item__text h5 a { color: #ffffff; font-weight: 700; }
        .product__item__text ul li { background: rgba(255, 255, 255, 0.2); color: white; padding: 1px 10px; border-radius: 50px; font-size: 10px; }
        .ep { background: #e53637; color: #fff; padding: 2px 10px; border-radius: 4px; font-size: 11px; }
    </style>
</head>

<body>

    <header class="header">
        <div class="container">
            <div class="row">
                <div class="col-lg-2">
                    <div class="header__logo">
                        <a href="/"><img src="{{ asset('img/logo2.png') }}" alt="" style="width: 100px;"></a>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="header__nav">
                        <nav class="header__menu mobile-menu">
                            <ul>
                                <li><a href="/">Homepage</a></li>
                                <li class="active"><a href="./genres">Categories</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="header__right">
                        @auth <a href="/profile"><span class="icon_profile"></span></a>
                        @else <a href="/login.html"><span class="icon_profile"></span></a> @endauth
                    </div>
                </div>
            </div>
            <div id="mobile-menu-wrap"></div>
        </div>
    </header>
    <div class="container">
        <div class="genre-container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="genre-header">
                        <h4>Genre List</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-6"><a href="/genres?genre=Action" class="genre-box">Action</a></div>
                <div class="col-lg-3 col-md-4 col-sm-6"><a href="/genres?genre=Adventure" class="genre-box">Adventure</a></div>
                <div class="col-lg-3 col-md-4 col-sm-6"><a href="/genres?genre=Comedy" class="genre-box">Comedy</a></div>
                <div class="col-lg-3 col-md-4 col-sm-6"><a href="/genres?genre=Demons" class="genre-box">Demons</a></div>

                <div class="col-lg-3 col-md-4 col-sm-6"><a href="/genres?genre=Drama" class="genre-box">Drama</a></div>
                <div class="col-lg-3 col-md-4 col-sm-6"><a href="/genres?genre=Ecchi" class="genre-box">Ecchi</a></div>
                <div class="col-lg-3 col-md-4 col-sm-6"><a href="/genres?genre=Fantasy" class="genre-box">Fantasy</a></div>
                <div class="col-lg-3 col-md-4 col-sm-6"><a href="/genres?genre=Game" class="genre-box">Game</a></div>

                <div class="col-lg-3 col-md-4 col-sm-6"><a href="/genres?genre=Harem" class="genre-box">Harem</a></div>
                <div class="col-lg-3 col-md-4 col-sm-6"><a href="/genres?genre=Historical" class="genre-box">Historical</a></div>
                <div class="col-lg-3 col-md-4 col-sm-6"><a href="/genres?genre=Horror" class="genre-box">Horror</a></div>
                <div class="col-lg-3 col-md-4 col-sm-6"><a href="/genres?genre=Josei" class="genre-box">Josei</a></div>

                <div class="col-lg-3 col-md-4 col-sm-6"><a href="/genres?genre=Magic" class="genre-box">Magic</a></div>
                <div class="col-lg-3 col-md-4 col-sm-6"><a href="/genres?genre=Martial Arts" class="genre-box">Martial Arts</a></div>
                <div class="col-lg-3 col-md-4 col-sm-6"><a href="/genres?genre=Mecha" class="genre-box">Mecha</a></div>
                <div class="col-lg-3 col-md-4 col-sm-6"><a href="/genres?genre=Military" class="genre-box">Military</a></div>

                <div class="col-lg-3 col-md-4 col-sm-6"><a href="/genres?genre=Music" class="genre-box">Music</a></div>
                <div class="col-lg-3 col-md-4 col-sm-6"><a href="/genres?genre=Mystery" class="genre-box">Mystery</a></div>
                <div class="col-lg-3 col-md-4 col-sm-6"><a href="/genres?genre=Psychological" class="genre-box">Psychological</a></div>
                <div class="col-lg-3 col-md-4 col-sm-6"><a href="/genres?genre=Parody" class="genre-box">Parody</a></div>

                <div class="col-lg-3 col-md-4 col-sm-6"><a href="/genres?genre=Police" class="genre-box">Police</a></div>
                <div class="col-lg-3 col-md-4 col-sm-6"><a href="/genres?genre=Romance" class="genre-box">Romance</a></div>
                <div class="col-lg-3 col-md-4 col-sm-6"><a href="/genres?genre=Samurai" class="genre-box">Samurai</a></div>
                <div class="col-lg-3 col-md-4 col-sm-6"><a href="/genres?genre=School" class="genre-box">School</a></div>

                <div class="col-lg-3 col-md-4 col-sm-6"><a href="/genres?genre=Sci-Fi" class="genre-box">Sci-Fi</a></div>
                <div class="col-lg-3 col-md-4 col-sm-6"><a href="/genres?genre=Seinen" class="genre-box">Seinen</a></div>
                <div class="col-lg-3 col-md-4 col-sm-6"><a href="/genres?genre=Shoujo" class="genre-box">Shoujo</a></div>
                <div class="col-lg-3 col-md-4 col-sm-6"><a href="/genres?genre=Shoujo Ai" class="genre-box">Shoujo Ai</a></div>

                <div class="col-lg-3 col-md-4 col-sm-6"><a href="/genres?genre=Shounen" class="genre-box">Shounen</a></div>
                <div class="col-lg-3 col-md-4 col-sm-6"><a href="/genres?genre=Slice of Life" class="genre-box">Slice of Life</a></div>
                <div class="col-lg-3 col-md-4 col-sm-6"><a href="/genres?genre=Sports" class="genre-box">Sports</a></div>
                <div class="col-lg-3 col-md-4 col-sm-6"><a href="/genres?genre=Space" class="genre-box">Space</a></div>

                <div class="col-lg-3 col-md-4 col-sm-6"><a href="/genres?genre=Super Power" class="genre-box">Super Power</a></div>
                <div class="col-lg-3 col-md-4 col-sm-6"><a href="/genres?genre=Supernatural" class="genre-box">Supernatural</a></div>
                <div class="col-lg-3 col-md-4 col-sm-6"><a href="/genres?genre=Thriller" class="genre-box">Thriller</a></div>
                <div class="col-lg-3 col-md-4 col-sm-6"><a href="/genres?genre=Vampire" class="genre-box">Vampire</a></div>
            </div>
        </div>
    </div>

    <section class="product-page spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="product__page__content">
                        
                        <div class="product__page__title">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="section-title">
                                        @if($genre)
                                            <h4>Result for: <span style="color: #e53637;">{{ $genre }}</span></h4>
                                        @else
                                            <h4>Select Genre</h4>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            {{-- LOOPING DATA DARI DATABASE --}}
                            @forelse($animeList as $item)
                                <div class="col-lg-3 col-md-6 col-sm-6">
                                    <div class="product__item">
                                        
                                        <div class="product__item__pic set-bg" data-setbg="{{ $item->image }}" style="background-image: url('{{ $item->image }}');">
                                            <div class="ep">{{ $item->current_ep ?? '?' }}</div>
                                            <div class="view"><i class="fa fa-eye"></i> {{ $item->view_count ?? 0 }}</div>
                                        </div>

                                        <div class="product__item__text">
                                            <ul>
                                                {{-- Ambil 1 genre pertama untuk ditampilkan di tag kecil --}}
                                                @php $g = explode(',', $item->genres); @endphp
                                                <li>{{ $g[0] ?? 'Anime' }}</li>
                                            </ul>
                                            <h5><a href="/anime-details.html?id={{ $item->id }}">{{ $item->title }}</a></h5>
                                        </div>

                                    </div>
                                </div>
                            @empty
                                {{-- Jika Tidak Ada Anime --}}
                                <div class="col-lg-12 text-center" style="margin-top: 50px; margin-bottom: 100px;">
                                    @if($genre)
                                        <h3 style="color: white;">Maaf, belum ada anime dengan genre "{{ $genre }}" :(</h3>
                                    @else
                                        <h3 style="color: white;">Silakan pilih genre di atas untuk melihat anime.</h3>
                                    @endif
                                </div>
                            @endforelse
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
                            <li><a>Categories</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3">
                    <p>Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>

</body>
</html>