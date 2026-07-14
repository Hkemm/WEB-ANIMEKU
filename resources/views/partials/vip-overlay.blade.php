<div id="vip-overlay" class="vip-overlay">
    <div class="vip-modal">
        <div class="vip-close"><i class="icon_close"></i></div>
        
        <div class="vip-header">
            <i class="fa fa-crown"></i>
            <h2>GO PREMIUM</h2>
            <p>Nikmati pengalaman nonton anime tanpa batas!</p>
        </div>

        <div class="vip-benefits">
            <ul>
                <li><i class="fa fa-check-circle"></i> Tanpa Iklan Mengganggu</li>
                <li><i class="fa fa-check-circle"></i> Resolusi 4K & Full HD</li>
                <li><i class="fa fa-check-circle"></i> Akses Episode 1 Jam Lebih Awal</li>
                <li><i class="fa fa-check-circle"></i> Download Sepuasnya</li>
            </ul>
        </div>

        <div class="vip-plans">
            <div class="plan-item">
                <span class="plan-name">Bulanan</span>
                <div class="plan-price">Rp 15.000</div>
                <button type="button" class="site-btn" onclick="checkout('bulanan', 15000)">Pilih Paket</button>
            </div>

            <div class="plan-item best-value">
                <div class="badge-best">HEMAT 50%</div>
                <span class="plan-name">Tahunan</span>
                <div class="plan-price">Rp 100.000</div>
                <button type="button" class="site-btn" onclick="checkout('tahunan', 100000)">Pilih Paket</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript"
    src="https://app.sandbox.midtrans.com/snap/snap.js" 
    data-client-key="Mid-client-_HnWFmEfaDl1oRr1"></script>
    

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // --- LOGIC BUKA TUTUP MODAL ---
        const vipBtn = document.getElementById('vip-btn');
        const vipOverlay = document.getElementById('vip-overlay');
        const vipClose = document.querySelector('.vip-close');

        if(vipBtn && vipOverlay && vipClose) {
            vipBtn.addEventListener('click', function(e) {
                e.preventDefault();
                vipOverlay.style.display = 'flex'; 
                setTimeout(() => { vipOverlay.classList.add('active'); }, 10);
            });
            vipClose.addEventListener('click', function() {
                vipOverlay.classList.remove('active');
                setTimeout(() => { vipOverlay.style.display = 'none'; }, 300);
            });
            vipOverlay.addEventListener('click', function(e) {
                if (e.target === vipOverlay) {
                    vipOverlay.classList.remove('active');
                    setTimeout(() => { vipOverlay.style.display = 'none'; }, 300);
                }
            });
        }
    });

    // --- LOGIC PEMBAYARAN ---
    function checkout(paket, harga) {
        alert("Memproses Paket: " + paket + "..."); 

        fetch('/payment/process', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                paket: paket,
                harga: harga
            })
        })
        .then(response => {
            if (response.status === 401) {
                alert("⚠️ Harap LOGIN terlebih dahulu!");
                window.location.href = '/login'; 
                return null;
            }
            return response.json();
        })
        .then(data => {
            if(data && data.snap_token) {
                // Munculkan Pop-up Midtrans
                window.snap.pay(data.snap_token, {
                    onSuccess: function(result){
                        alert("✅ Pembayaran Berhasil!");
                        window.location.reload();
                    },
                    onPending: function(result){
                        alert("⏳ Menunggu pembayaran...");
                    },
                    onError: function(result){
                        alert("❌ Pembayaran Gagal!");
                    },
                    onClose: function(){
                        console.log('Popup ditutup');
                    }
                });
            } else {
                console.error("Error Data:", data);
                if(data.error) {
                    alert("Gagal: " + data.error);
                } else {
                    alert("Gagal memproses transaksi. Cek Console.");
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert("Error koneksi server (Cek apakah Controller sudah diupdate).");
        });
    }
</script>