<style>
    .forgot-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.9);
        z-index: 99999;
        justify-content: center;
        align-items: center;
        backdrop-filter: blur(5px);
    }

    .forgot-box {
        background: #0b0c2a;
        width: 400px;
        padding: 30px;
        border-radius: 10px;
        border: 1px solid #e53637;
        text-align: center;
        position: relative;
        box-shadow: 0 0 20px rgba(229, 54, 55, 0.3);
    }

    .forgot-close {
        position: absolute;
        top: 10px;
        right: 15px;
        color: #fff;
        cursor: pointer;
        font-size: 20px;
    }

    .forgot-box h4 {
        color: #fff;
        margin-bottom: 20px;
        font-weight: 700;
    }

    .forgot-step {
        display: none;
    }

    .forgot-step.active {
        display: block;
    }

    .forgot-box input {
        width: 100%;
        height: 45px;
        margin-bottom: 15px;
        padding-left: 15px;
        border-radius: 5px;
        border: none;
        background: #ffffff;
    }

    .forgot-btn {
        width: 100%;
        padding: 12px;
        background: #e53637;
        color: white;
        border: none;
        font-weight: bold;
        cursor: pointer;
        text-transform: uppercase;
    }
</style>

<div id="forgotOverlay" class="forgot-overlay">
    <div class="forgot-box">
        <div class="forgot-close" onclick="closeForgotModal()">&#10005;</div>
        
        <div id="step1" class="forgot-step active">
            <h4>Lupa Password?</h4>
            <p style="color: #b7b7b7; font-size: 13px;">Masukkan email Anda untuk menerima kode OTP.</p>
            <input type="email" id="forgotEmail" placeholder="Email Anda...">
            <button class="forgot-btn" onclick="sendOtp()">Kirim Kode OTP</button>
        </div>

        <div id="step2" class="forgot-step">
            <h4>Reset Password</h4>
            <p style="color: #b7b7b7; font-size: 13px;">Cek email Anda dan masukkan kode OTP.</p>
            <input type="text" id="otpCode" placeholder="Kode OTP (6 Digit)">
            <input type="password" id="newPassword" placeholder="Password Baru">
            <button class="forgot-btn" onclick="resetPassword()">Simpan Password</button>
        </div>
    </div>
</div>

<script>
    function openForgotModal() {
        $('#forgotOverlay').fadeIn().css('display', 'flex');
    }

    function closeForgotModal() {
        $('#forgotOverlay').fadeOut();
        setTimeout(() => {
            $('#step1').addClass('active');
            $('#step2').removeClass('active');
            $('#forgotEmail').val('');
            $('#otpCode').val('');
            $('#newPassword').val('');
        }, 300);
    }

    function sendOtp() {
        var email = $('#forgotEmail').val();
        var btn = $('#step1 button');

        if(!email) {
            Swal.fire('Error', 'Harap isi email terlebih dahulu!', 'error');
            return;
        }

        btn.text('Mengirim...').prop('disabled', true);

        $.ajax({
            url: '/forgot-password/send-otp',
            type: 'POST',
            data: { email: email, _token: $('meta[name="csrf-token"]').attr('content') },
            success: function(res) {
                if(res.status == 'success') {
                    Swal.fire('Terkirim!', res.message, 'success');
                    $('#step1').removeClass('active');
                    $('#step2').addClass('active');
                } else {
                    Swal.fire('Gagal', res.message, 'error');
                }
            },
            error: function() {
                Swal.fire('Error', 'Terjadi kesalahan sistem.', 'error');
            },
            complete: function() {
                btn.text('Kirim Kode OTP').prop('disabled', false);
            }
        });
    }

    function resetPassword() {
        var email = $('#forgotEmail').val();
        var otp = $('#otpCode').val();
        var pass = $('#newPassword').val();
        var btn = $('#step2 button');

        if(!otp || !pass) {
            Swal.fire('Error', 'Mohon lengkapi data!', 'error');
            return;
        }

        btn.text('Memproses...').prop('disabled', true);

        $.ajax({
            url: '/forgot-password/reset',
            type: 'POST',
            data: { 
                email: email, 
                otp: otp, 
                password: pass, 
                _token: $('meta[name="csrf-token"]').attr('content') 
            },
            success: function(res) {
                if(res.status == 'success') {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: res.message,
                        icon: 'success'
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire('Gagal', res.message, 'error');
                }
            },
            error: function() {
                Swal.fire('Error', 'Gagal mereset password.', 'error');
            },
            complete: function() {
                btn.text('Simpan Password').prop('disabled', false);
            }
        });
    }
</script>