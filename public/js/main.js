"use strict";

// =========================================================
// 1. GLOBAL FUNCTION: CHECKOUT / PAYMENT
// =========================================================
window.checkout = function(paket, harga) {
    if (typeof Swal === 'undefined') {
        alert("Library SweetAlert Gagal Dimuat! Cek koneksi internet.");
        return;
    }
    if (typeof window.snap === 'undefined') {
        Swal.fire('Error', 'Sistem pembayaran belum siap. Coba refresh halaman.', 'error');
        return;
    }

    Swal.fire({
        title: 'Memproses...', text: 'Mohon tunggu sebentar',
        allowOutsideClick: false, didOpen: () => { Swal.showLoading() }
    });

    var csrfToken = document.querySelector('meta[name="csrf-token"]');
    if(!csrfToken) {
        Swal.fire('Error', 'CSRF Token tidak ditemukan.', 'error');
        return;
    }

    fetch('/payment/process', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
            'Accept': 'application/json'
        },
        body: JSON.stringify({ paket: paket, harga: harga })
    })
    .then(response => {
        if (response.status === 401) {
            Swal.fire('Login Dulu', 'Anda harus login untuk membeli paket.', 'warning')
            .then(() => { window.location.href = '/login.html'; });
            throw new Error("Belum Login");
        }
        return response.json();
    })
    .then(data => {
        Swal.close();
        if(data && data.snap_token) {
            window.snap.pay(data.snap_token, {
                onSuccess: function(result){
                    Swal.fire('Berhasil!', 'Pembayaran sukses.', 'success')
                    .then(() => { window.location.reload(); });
                },
                onPending: function(result){ Swal.fire('Menunggu', 'Selesaikan pembayaran.', 'info'); },
                onError: function(result){ Swal.fire('Gagal', 'Pembayaran gagal.', 'error'); },
                onClose: function(){ Swal.fire('Batal', 'Anda menutup popup.', 'warning'); }
            });
        } else {
            Swal.fire('Error', data.error || 'Gagal memproses transaksi.', 'error');
        }
    })
    .catch(error => {
        console.error(error);
        if(error.message !== "Belum Login") Swal.fire('Error', 'Terjadi kesalahan koneksi.', 'error');
    });
};

// =========================================================
// 2. SETUP UTAMA & PLUGINS (JQUERY)
// =========================================================

(function ($) {
    $(window).on("load", function () {
        $(".loader").fadeOut();
        $("#preloder").delay(200).fadeOut("slow");

        $(".filter__controls li").on("click", function () {
            $(".filter__controls li").removeClass("active");
            $(this).addClass("active");
        });
        if ($(".filter__gallery").length > 0) {
            var containerEl = document.querySelector(".filter__gallery");
            var mixer = mixitup(containerEl);
        }
    });

    $(".set-bg").each(function () {
        var bg = $(this).data("setbg");
        if (bg) $(this).css("background-image", "url(" + bg + ")");
    });

    $(".search-switch").on("click", function () {
        $(".search-model").fadeIn(400);
    });

    $(".search-close-switch").on("click", function () {
        $(".search-model").fadeOut(400, function () {
            $("#search-input").val("");
        });
    });

    $(".mobile-menu").slicknav({
        prependTo: "#mobile-menu-wrap",
        allowParentLinks: true,
    });

    var hero_s = $(".hero__slider");
    hero_s.owlCarousel({
        loop: true, margin: 0, items: 1, dots: true, nav: true,
        navText: ["<span class='arrow_carrot-left'></span>", "<span class='arrow_carrot-right'></span>"],
        animateOut: "fadeOut", animateIn: "fadeIn",
        smartSpeed: 1200, autoHeight: false, autoplay: true, mouseDrag: false,
    });

    $("select").niceSelect();

    $("#scrollToTopButton").click(function () {
        $("html, body").animate({ scrollTop: 0 }, "slow");
        return false;
    });
})(jQuery);

// =========================================================
// 3. AUTHENTICATION (LOGIN & REGISTER)
// =========================================================

$(document).ready(function () {
    $.ajaxSetup({
        headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
    });

    $("#registerForm").on("submit", function (e) {
        e.preventDefault();
        var btn = $(this).find("button");
        var originalText = btn.text();
        var messageBox = $("#registerMessage");

        btn.text("Processing...").prop("disabled", true);
        messageBox.html("");

        $.ajax({
            url: "/register-process", type: "POST", data: $(this).serialize(),
            success: function (response) {
                if (response.status === "success") {
                    messageBox.html('<span style="color:green;">' + response.message + " Redirecting...</span>");
                    $("#registerForm")[0].reset();
                    setTimeout(function () { window.location.href = "./login.html"; }, 2000);
                } else {
                    messageBox.html('<span style="color:red;">' + response.message + "</span>");
                    btn.text(originalText).prop("disabled", false);
                }
            },
            error: function (xhr) {
                var msg = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : "Gagal menghubungi server.";
                messageBox.html('<span style="color:red;">' + msg + "</span>");
                btn.text(originalText).prop("disabled", false);
            },
        });
    });

    $("#loginForm").on("submit", function (e) {
        e.preventDefault();
        var btn = $(this).find("button");
        var originalText = btn.text();
        var messageBox = $("#loginMessage");

        btn.text("Checking...").prop("disabled", true);
        messageBox.html("");

        $.ajax({
            url: "/login-process", type: "POST", data: $(this).serialize(),
            success: function (response) {
                if (response.status === "success") {
                    messageBox.html('<span style="color:green;">' + response.message + "</span>");
                    setTimeout(function () { window.location.href = "/"; }, 1500);
                } else {
                    messageBox.html('<span style="color:red;">' + response.message + "</span>");
                    btn.text(originalText).prop("disabled", false);
                }
            },
            error: function (xhr) {
                var msg = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : "Terjadi kesalahan server.";
                messageBox.html('<span style="color:red;">' + msg + "</span>");
                btn.text(originalText).prop("disabled", false);
            },
        });
    });
});

// =========================================================
// 4. LOGIKA DATA HOMEPAGE & SEARCH
// =========================================================

document.addEventListener("DOMContentLoaded", function () {
    if ((document.getElementById("trending-data") || document.getElementById("search-input")) && !document.getElementById("loginForm")) {

        fetch("/anime-data")
            .then((response) => response.json())
            .then((animeData) => {
                const allAnimeDatabase = [...animeData].filter(
                    (value, index, self) => index === self.findIndex((t) => t.title === value.title)
                );

                function renderAnimeList(dataArray, containerId) {
                    const container = document.getElementById(containerId);
                    if (!container) return;
                    let htmlContent = "";
                    dataArray.forEach((anime) => {
                        let tagsHtml = "";
                        (anime.tags || []).forEach((tag) => { tagsHtml += `<li>${tag}</li>`; });
                        const link = `/anime-details.html?id=${anime.id}`; 
                        
                        htmlContent += `
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="product__item">
                                    <div class="product__item__pic set-bg" data-setbg="${anime.image}" style="background-image: url('${anime.image}');">
                                        <div class="ep">${anime.ep || "N/A"}</div>
                                        <div class="comment"><i class="fa fa-comments"></i> ${anime.comment || 0}</div>
                                        <div class="view"><i class="fa fa-eye"></i> ${anime.view || 0}</div>
                                    </div>
                                    <div class="product__item__text">
                                        <ul>${tagsHtml}</ul>
                                        <h5><a href="${link}">${anime.title}</a></h5>
                                    </div>
                                </div>
                            </div>`;
                    });
                    container.innerHTML = htmlContent;
                    $(".set-bg").each(function () {
                        var bg = $(this).data("setbg");
                        if (bg) $(this).css("background-image", "url(" + bg + ")");
                    });
                }

                if (document.getElementById("trending-data")) renderAnimeList(allAnimeDatabase.slice(0, 3), "trending-data");
                if (document.getElementById("popular-data")) renderAnimeList(allAnimeDatabase.slice(0, 6), "popular-data");
                if (document.getElementById("recent-data")) renderAnimeList(allAnimeDatabase.slice(0, 6), "recent-data");
                if (document.getElementById("live-data")) renderAnimeList(allAnimeDatabase.slice(0, 6), "live-data");

                const searchInput = document.getElementById("search-input");
                const searchResultContainer = document.getElementById("search-result-container");
                if (searchInput && searchResultContainer) {
                    searchInput.addEventListener("keyup", function (e) {
                        const query = e.target.value.toLowerCase();
                        searchResultContainer.innerHTML = "";
                        if (query.length < 2) {
                            searchResultContainer.innerHTML = '<h3 style="color:white; text-align:center;">Ketik minimal 2 karakter...</h3>';
                            return;
                        }
                        const filteredAnime = allAnimeDatabase.filter((anime) => anime.title.toLowerCase().includes(query));
                        if (filteredAnime.length > 0) {
                            renderAnimeList(filteredAnime, "search-result-container");
                        } else {
                            searchResultContainer.innerHTML = '<h3 style="color:white; text-align:center;">Anime tidak ditemukan :(</h3>';
                        }
                    });
                }
            })
            .catch((error) => console.error("Error fetching anime data:", error));
    }
});

// =========================================================
// 5. LOGIKA PLAYER & VIP (GLOBAL - MOBILE FIX)
// =========================================================

document.addEventListener("DOMContentLoaded", function () {
    // --- A. LOGIKA PLAYER & GANTI EPISODE ---
    const playerElement = document.getElementById('player');
    let playerInstance = null;

    // 1. Inisialisasi Plyr
    if (playerElement && typeof Plyr !== 'undefined') {
         playerInstance = new Plyr('#player', {
            controls: ['play-large', 'play', 'progress', 'current-time', 'mute', 'volume', 'captions', 'settings', 'pip', 'fullscreen'],
        });
    }

    // 2. Logic Ganti Episode (INI YANG HILANG SEBELUMNYA)
    const episodeButtons = document.querySelectorAll('.play-episode');
    const downloadBtn = document.getElementById('customDownloadLink');

    episodeButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault(); // Mencegah halaman scroll ke atas atau reload

            // Ambil data dari tombol yang diklik
            const videoUrl = this.getAttribute('data-video');
            const episodeNum = this.getAttribute('data-episode');
            const fileName = this.getAttribute('data-filename');

            // 1. Ganti Source Video di Player
            if (playerInstance) {
                playerInstance.source = {
                    type: 'video',
                    sources: [
                        {
                            src: videoUrl,
                            type: 'video/mp4',
                        },
                    ],
                    poster: playerElement.getAttribute('data-poster') // Tetapkan poster anime
                };
                // Opsional: Langsung play setelah ganti
                playerInstance.play(); 
            } else {
                // Fallback jika Plyr gagal load (HTML5 native)
                playerElement.src = videoUrl;
                playerElement.play();
            }

            // 2. Update Link Download (Biar sesuai episode yg ditonton)
            if(downloadBtn) {
                downloadBtn.href = videoUrl;
                downloadBtn.innerHTML = '<i class="fa fa-download"></i> Download Ep ' + episodeNum;
                downloadBtn.setAttribute('download', fileName || '');
            }

            // 3. Update Tampilan Tombol Aktif (Warna Merah)
            episodeButtons.forEach(b => {
                b.classList.remove('active-episode');
                b.style.background = '#333'; // Reset warna tombol lain
                b.style.color = '#fff';
            });
            
            this.classList.add('active-episode');
            this.style.background = '#e53637'; // Warna merah aktif
            
            // 4. Update URL Browser (Opsional: Agar kalau di-refresh tetap di episode ini)
            const newUrl = new URL(window.location);
            newUrl.searchParams.set('ep', episodeNum);
            window.history.pushState({}, '', newUrl);
            
            // Update Breadcrumb text (opsional)
            const breadcrumbSpan = document.getElementById('watchBreadcrumbTitle');
            if(breadcrumbSpan && window.AppConfig) {
                 breadcrumbSpan.innerText = window.AppConfig.animeTitle + ' - Episode ' + episodeNum;
            }
        });
    });


    // --- B. LOGIKA POPUP VIP ---
    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.vip-mobile-fix, .vip-trigger, #vip-btn');
        if (btn) {
            e.preventDefault();
            const vipOverlay = document.getElementById('vip-overlay');
            if (vipOverlay) {
                vipOverlay.style.display = 'flex';
                setTimeout(() => { vipOverlay.classList.add('active'); }, 10);
            }
        }

        const closeBtn = e.target.closest('.vip-close');
        const overlay = document.getElementById('vip-overlay');
        if (closeBtn || (overlay && e.target === overlay)) {
            if (overlay) {
                overlay.classList.remove('active');
                setTimeout(() => { overlay.style.display = 'none'; }, 300);
            }
        }
    });
});

// =========================================================
// 6. BOOKMARK & COMMENT
// =========================================================
(function () {
    "use strict";
    const API_TOGGLE = "/bookmark/toggle";
    const API_BOOKMARKS = "/user/bookmarks"; 

    function parseId(v) { return Number.isInteger(Number(v)) ? Number(v) : null; }
    function getAnimeIdFromBtn(btn) {
        if (!btn) return null;
        const a = btn.getAttribute("data-anime-id");
        if (a) return parseId(a);
        const qs = new URLSearchParams(window.location.search);
        return parseId(qs.get("id"));
    }
    function renderBtn(btn, followed) {
        if (!btn) return;
        if (followed) {
            btn.classList.add("followed");
            btn.setAttribute("data-followed", "1");
            btn.innerHTML = '<i class="fa fa-heart"></i> Followed';
        } else {
            btn.classList.remove("followed");
            btn.setAttribute("data-followed", "0");
            btn.innerHTML = '<i class="fa fa-heart-o"></i> Follow';
        }
        btn.dataset.initialized = "1";
    }
    function ensureUserBookmarks() {
        if (Array.isArray(window.userBookmarks)) return Promise.resolve(window.userBookmarks);
        window.userBookmarks = [];
        return fetch(API_BOOKMARKS).then(res => res.ok ? res.json() : {bookmarks:[]})
            .then(json => {
                window.userBookmarks = Array.isArray(json.bookmarks) ? json.bookmarks.map(v => Number(v)) : [];
                return window.userBookmarks;
            }).catch(() => []);
    }
    function toggleBookmark(animeId, btn) {
        const originalHtml = btn.innerHTML;
        btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> ...';
        $.ajax({
            url: API_TOGGLE, type: "POST",
            data: { anime_id: animeId, _token: $('meta[name="csrf-token"]').attr("content") },
            success: function (res) {
                if (res && res.status === "added") {
                    renderBtn(btn, true);
                    if (!window.userBookmarks.includes(animeId)) window.userBookmarks.push(animeId);
                } else if (res && res.status === "removed") {
                    renderBtn(btn, false);
                    window.userBookmarks = window.userBookmarks.filter(v => v !== animeId);
                } else {
                    btn.innerHTML = originalHtml;
                    alert(res.message || "Gagal");
                }
            },
            error: function () { btn.innerHTML = originalHtml; alert("Error koneksi"); }
        });
    }
    document.addEventListener("DOMContentLoaded", function () {
        ensureUserBookmarks().then(() => {
             const pageParams = new URLSearchParams(window.location.search);
             const pageId = pageParams.get("id") ? parseId(pageParams.get("id")) : null;
             document.querySelectorAll(".follow-btn").forEach((btn) => {
                const btnId = getAnimeIdFromBtn(btn) || pageId;
                const isFollowed = window.userBookmarks.includes(Number(btnId));
                renderBtn(btn, isFollowed);
             });
        });
        document.addEventListener("click", function (e) {
            const btn = e.target.closest && e.target.closest(".follow-btn");
            if (!btn) return;
            e.preventDefault();
            const animeId = getAnimeIdFromBtn(btn);
            if (animeId) toggleBookmark(Number(animeId), btn);
        });
    });
})();

$(document).ready(function() {
    $('#commentForm').on('submit', function(e) {
        e.preventDefault(); 
        var form = $(this);
        var btn = form.find('button');
        var originalBtnText = btn.html();
        var textarea = form.find('textarea');
        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Sending...');
        $.ajax({
            url: '/anime/comment', type: 'POST', data: form.serialize(),
            success: function(response) {
                if (response.status === 'success') {
                    if(typeof Swal !== 'undefined') Swal.fire({ icon: 'success', title: 'Terkirim!', text: response.message, showConfirmButton: false, timer: 1500 });
                    else alert(response.message);
                    var newCommentHtml = `
                        <div class="anime__review__item" style="display:none;">
                            <div class="anime__review__item__pic"><img src="${response.data.avatar}" style="width: 50px; height: 50px; border-radius: 50%;"></div>
                            <div class="anime__review__item__text">
                                <h6>${response.data.name} - <span>${response.data.date}</span></h6>
                                <p>${response.data.comment}</p>
                            </div>
                        </div>`;
                    $('#no-review-msg').remove();
                    $('#reviewContainer').prepend(newCommentHtml);
                    $('#reviewContainer .anime__review__item').first().slideDown();
                    var countSpan = $('#reviewCount');
                    var currentCount = parseInt(countSpan.text());
                    if (!isNaN(currentCount)) countSpan.text(currentCount + 1);
                    textarea.val('');
                } else {
                    if(typeof Swal !== 'undefined') Swal.fire('Gagal', response.message, 'error');
                    else alert(response.message);
                }
            },
            error: function() { alert('Terjadi kesalahan koneksi.'); },
            complete: function() { btn.prop('disabled', false).html(originalBtnText); }
        });
    });
});