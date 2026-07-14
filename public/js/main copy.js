

'use strict';

(function ($) {

    /*------------------
        Preloader
    --------------------*/
    $(window).on('load', function () {
        $(".loader").fadeOut();
        $("#preloder").delay(200).fadeOut("slow");

        /*------------------
            FIlter
        --------------------*/
        $('.filter__controls li').on('click', function () {
            $('.filter__controls li').removeClass('active');
            $(this).addClass('active');
        });
        if ($('.filter__gallery').length > 0) {
            var containerEl = document.querySelector('.filter__gallery');
            var mixer = mixitup(containerEl);
        }
    });

    /*------------------
        Background Set
    --------------------*/
    $('.set-bg').each(function () {
        var bg = $(this).data('setbg');
        $(this).css('background-image', 'url(' + bg + ')');
    });

    // Search model
    $('.search-switch').on('click', function () {
        $('.search-model').fadeIn(400);
    });

    $('.search-close-switch').on('click', function () {
        $('.search-model').fadeOut(400, function () {
            $('#search-input').val('');
        });
    });

    /*------------------
		Navigation
	--------------------*/
    $(".mobile-menu").slicknav({
        prependTo: '#mobile-menu-wrap',
        allowParentLinks: true
    });

    /*------------------
		Hero Slider
	--------------------*/
    var hero_s = $(".hero__slider");
    hero_s.owlCarousel({
        loop: true,
        margin: 0,
        items: 1,
        dots: true,
        nav: true,
        navText: ["<span class='arrow_carrot-left'></span>", "<span class='arrow_carrot-right'></span>"],
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
        smartSpeed: 1200,
        autoHeight: false,
        autoplay: true,
        mouseDrag: false
    });

    /*------------------
        Video Player
    --------------------*/
    const player = new Plyr('#player', {
        controls: ['play-large', 'play', 'progress', 'current-time', 'mute', 'captions', 'settings', 'fullscreen'],
        seekTime: 25
    });

    /*------------------
        Niceselect
    --------------------*/
    $('select').niceSelect();

    /*------------------
        Scroll To Top
    --------------------*/
    $("#scrollToTopButton").click(function() {
        $("html, body").animate({ scrollTop: 0 }, "slow");
        return false;
     });

})(jQuery);



/* ---------------------------------------------------
    LOGIC DATA ANIME & SEARCH (Sama seperti sebelumnya)
    --------------------------------------------------- */

(function ($) {
    // Gunakan 'strict mode' untuk keamanan coding javascript
    'use strict';

    $(document).ready(function() {

        // --- 1. DATA ANIME (Tambahkan kembali data daftar anime di sini) ---
        // Catatan: Jika Anda ingin menggunakan data yang sama untuk daftar di homepage dan detail,
        // buat data ini di scope global (di luar document.ready) atau gabungkan kedua fitur.
        
        const trendingList = [
            { title: "Kaiju No.8", image: "img/trending/Kaiju_No8.jpg", ep: "12 / 12", view: 9141, tags: ["Active", "BD"], link: "anime-details.html?id=1" },
            { title: "Kaurou Hana wa Rin to Saku", image: "img/trending/Waguri.webp", ep: "12 / 12", view: 4000, tags: ["Active", "BD"], link: "anime-details.html?id=2" },
            { title: "Shingeki no Kyojin S3", image: "img/trending/trend-3.jpg", ep: "12 / 12", view: 15000, tags: ["Completed"], link: "anime-details.html?id=3" }
        ];
        
        const popularList = [
            { title: "Sen to Chihiro", image: "img/popular/popular-1.jpg", ep: "18 / 18", view: 9141, tags: ["Active", "Movie"], link: "#" },
            { title: "Kizumonogatari III", image: "img/popular/popular-2.jpg", ep: "18 / 18", view: 5000, tags: ["Active", "Movie"], link: "#" },
            { title: "Shirogane Tamashii", image: "img/popular/popular-3.jpg", ep: "18 / 18", view: 2000, tags: ["Active", "Movie"], link: "#" },
            { title: "Rurouni Kenshin", image: "img/popular/popular-4.jpg", ep: "18 / 18", view: 7000, tags: ["Active", "Movie"], link: "#" },
            { title: "Mushishi Zoku Shou", image: "img/popular/popular-5.jpg", ep: "18 / 18", view: 3000, tags: ["Active", "Movie"], link: "#" },
            { title: "Monogatari Series", image: "img/popular/popular-6.jpg", ep: "18 / 18", view: 1000, tags: ["Active", "Movie"], link: "#" }
        ];

        const recentList = [
            { title: "Great Teacher Onizuka", image: "img/recent/recent-1.jpg", ep: "18 / 18", view: 9141, tags: ["Active"], link: "#" },
            { title: "Fate/stay night Movie", image: "img/recent/recent-2.jpg", ep: "18 / 18", view: 9141, tags: ["Active"], link: "#" },
            { title: "Mushishi Zoku Shou", image: "img/recent/recent-3.jpg", ep: "18 / 18", view: 9141, tags: ["Active"], link: "#" },
            { title: "Fate/Zero 2nd Season", image: "img/recent/recent-4.jpg", ep: "18 / 18", view: 9141, tags: ["Active"], link: "#" },
            { title: "Kizumonogatari II", image: "img/recent/recent-5.jpg", ep: "18 / 18", view: 9141, tags: ["Active"], link: "#" },
            { title: "The Seven Deadly Sins", image: "img/recent/recent-6.jpg", ep: "18 / 18", view: 9141, tags: ["Active"], link: "#" }
        ];

        const liveList = [
            { title: "Shouwa Genroku", image: "img/live/live-1.jpg", ep: "18 / 18", view: 9141, tags: ["Active"], link: "#" },
            { title: "Mushishi Zoku Shou", image: "img/live/live-2.jpg", ep: "18 / 18", view: 9141, tags: ["Active"], link: "#" },
            { title: "Mushishi Zoku Shou", image: "img/live/live-3.jpg", ep: "18 / 18", view: 9141, tags: ["Active"], link: "#" },
            { title: "Fate/stay night Movie", image: "img/live/live-4.jpg", ep: "18 / 18", view: 9141, tags: ["Active"], link: "#" },
            { title: "Kizumonogatari II", image: "img/live/live-5.jpg", ep: "18 / 18", view: 9141, tags: ["Active"], link: "#" },
            { title: "Kizumonogatari II", image: "img/live/live-6.jpg", ep: "18 / 18", view: 9141, tags: ["Active"], link: "#" }
        ];

        // --- 2. FUNGSI RENDER UTAMA ---
        function renderAnimeList(dataArray, containerId) {
            const container = document.getElementById(containerId);
            if(!container) return; 

            let htmlContent = '';
            dataArray.forEach(anime => {
                let tagsHtml = '';
                // Tambahkan tags hanya jika ada
                if (anime.tags) {
                    anime.tags.forEach(tag => { tagsHtml += `<li>${tag}</li>`; });
                }
                let commentCount = anime.comment || 11; 

                htmlContent += `
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="product__item">
                            <div class="product__item__pic set-bg" data-setbg="${anime.image}" style="background-image: url('${anime.image}');">
                                <div class="ep">${anime.ep}</div>
                                <div class="comment"><i class="fa fa-comments"></i> ${commentCount}</div>
                                <div class="view"><i class="fa fa-eye"></i> ${anime.view}</div>
                            </div>
                            <div class="product__item__text">
                                <ul>${tagsHtml}</ul>
                                <h5><a href="${anime.link}">${anime.title}</a></h5>
                            </div>
                        </div>
                    </div>
                `;
            });
            container.innerHTML = htmlContent;
            
            // Re-inisialisasi background image
            $('.set-bg').each(function () {
                var bg = $(this).data('setbg');
                if(bg) $(this).css('background-image', 'url(' + bg + ')');
            });
        }

        // --- 3. JALANKAN RENDER HOMEPAGE ---
        if(document.getElementById('trending-data')) renderAnimeList(trendingList, 'trending-data');
        if(document.getElementById('popular-data')) renderAnimeList(popularList, 'popular-data');
        if(document.getElementById('recent-data')) renderAnimeList(recentList, 'recent-data');
        if(document.getElementById('live-data')) renderAnimeList(liveList, 'live-data');


        // --- 4. LOGIC PENCARIAN (LIVE SEARCH) ---
        const searchInput = document.getElementById('search-input');
        const searchResultContainer = document.getElementById('search-result-container');

        if (searchInput && searchResultContainer) {
            // Gabungkan data
            let allAnimeDatabase = [...trendingList, ...popularList, ...recentList, ...liveList];
            
            // Hapus Duplikat
            allAnimeDatabase = allAnimeDatabase.filter((value, index, self) =>
                index === self.findIndex((t) => (
                    t.title === value.title
                ))
            );

            // Event Listener Keyup
            searchInput.addEventListener('keyup', function(e) {
                const query = e.target.value.toLowerCase();
                searchResultContainer.innerHTML = ''; 

                if(query === '') return;

                const filteredAnime = allAnimeDatabase.filter(anime => 
                    anime.title.toLowerCase().includes(query)
                );

                if(filteredAnime.length > 0) {
                    renderAnimeList(filteredAnime, 'search-result-container');
                } else {
                    searchResultContainer.innerHTML = '<h3 style="color:white; text-align:center;">Anime tidak ditemukan :(</h3>';
                }
            });

            // Prevent Form Submit
            $('.search-model-form').on('submit', function(e){
                e.preventDefault();
            });
        }
    });

})(jQuery);

/* ---------------------------------------------------
    LOGIC ANIME DETAILS (Luar scope document.ready untuk mencegah konflik, 
    tapi akan jalan di akhir load)
    --------------------------------------------------- */

// Kami biarkan kode ini di luar wrapper JQuery utama Anda, tapi menambahkan pengecekan 
// ID agar hanya berjalan di halaman anime-details.html

if(document.getElementById('animeTitle')) {

    const animeData = [
        {
            id: 1,
            title: "Kaiju No.8",
            japan: "七つの大罪 (Nanatsu no Taizai)",
            image: "img/trending/Kaiju_No8.jpg", 
            genre: "Action, Adventure, Fantasy",
            desc: "The Seven Deadly Sins bercerita tentang sekelompok ksatria yang bubar setelah dituduh merencanakan penggulingan Kerajaan Liones."
            
        },
        {
            id: 2,
            title: "Gintama Movie 2: Kanketsu-hen",
            japan: "銀魂 (Gintama)",
            image: "img/trending/Waguri.webp",
            genre: "Action, Comedy, Sci-Fi",
            desc: "Gintoki Sakata tiba-tiba terlempar ke masa depan di mana Edo telah hancur dan dirinya dikabarkan sudah meninggal."
        },
        {
            id: 3,
            title: "Sword Art Online: Alicization",
            japan: "ソードアート・オンライン",
            image: "img/trending/trend-3.jpg",
            genre: "Game, Sci-Fi, Adventure",
            desc: "Kirito terbangun di hutan misterius penuh pohon raksasa. Dia bertemu dengan Eugeo dan memulai petualangan baru."
        },
        {
            id: 4,
            title: "Fate/Stay Night: Unlimited Blade Works",
            japan: "フェイト／ステイナイト",
            image: "img/anime/details-pic.jpg" ,
            genre: "Action, Supernatural, Magic",
            desc: "Perang Cawan Suci dimulai. Shirou Emiya terseret ke dalam pertarungan mematikan antar penyihir dan roh pahlawan."
        },
        {
            id: 5,
            title: "Fate/Stay Night: Unlimited Blade Works",
            japan: "フェイト／ステイナイト",
            image: "img/trending/trend-5.jpg" ,
            genre: "Action, Supernatural, Magic",
            desc: "Perang Cawan Suci dimulai. Shirou Emiya terseret ke dalam pertarungan mematikan antar penyihir dan roh pahlawan."
        }
    ];

    // --- 2. AMBIL ID DARI URL ---
    const params = new URLSearchParams(window.location.search);
    const id = params.get('id');

    // --- 3. CARI DATA DI DATABASE ---
    const data = animeData.find(anime => anime.id == id);

    // --- 4. TAMPILKAN KE HALAMAN ---
    if (data) {
        // Ganti Judul
        document.getElementById('animeTitle').innerText = data.title;
        
        // Ganti Judul Jepang
        document.getElementById('animeJapan').innerText = data.japan;
        
        // Ganti Deskripsi
        document.getElementById('animeDesc').innerText = data.desc;
        
        // Ganti Genre (Hati-hati, kita sisipkan text "Genre:" dulu)
        document.getElementById('animeGenre').innerHTML = `<span>Genre:</span> ${data.genre}`;
        
        // Ganti Gambar (Pakai style background-image karena format div set-bg)
        document.getElementById('animeImage').style.backgroundImage = `url(${data.image})`;
        
        // Juga set data-setbg agar konsisten dengan cara kerja template
        document.getElementById('animeImage').setAttribute('data-setbg', data.image);

    } else {
        // Jika ID tidak ditemukan
        if (document.getElementById('animeTitle')) {
             document.getElementById('animeTitle').innerText = "Anime Tidak Ditemukan";
        }
        if (document.getElementById('animeDesc')) {
             document.getElementById('animeDesc').innerText = "Silakan kembali ke halaman utama dan pilih anime.";
        }
    }
}