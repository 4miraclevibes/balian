@extends('layouts.landing.main')

@section('style')
<style>
    .profile-header {
        text-align: center;
        margin-bottom: 30px;
    }
    .profile-image {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background-color: #e8f5e9;
        margin: 0 auto 15px;
        overflow: hidden;
    }
    .profile-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .profile-name {
        font-size: 1.2rem;
        font-weight: bold;
        margin-bottom: 5px;
    }
    .profile-email {
        color: #888;
    }
    .profile-menu-item {
        display: flex;
        align-items: center;
        padding: 15px 0;
        border-bottom: 1px solid #eee;
    }
    .profile-menu-item i {
        font-size: 1.2rem;
        margin-right: 15px;
        color: #4caf50;
    }
    .profile-menu-item span {
        flex-grow: 1;
    }
    .profile-menu-item::after {
        content: '>';
        color: #888;
    }
    .early-access-link {
        word-break: break-all;
        font-size: 0.9rem;
        color: #4caf50;
    }
    .copy-button {
        padding: 5px 10px;
        background-color: #4caf50;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 0.8rem;
    }
    .copy-button:hover {
        background-color: #45a049;
    }
    .modal-body {
        font-size: 0.9rem;
    }
    .modal-body ol {
        padding-left: 20px;
    }
    .modal-body img {
        max-width: 100%;
        height: auto;
        margin-bottom: 15px;
        width: 300px; /* Atur ukuran sesuai kebutuhan */
    }
</style>
@endsection

@section('content')
<div class="container mt-3">
    <div class="bg-white mb-3">
        <div class="d-flex align-items-center">
            <a href="{{ route('home') }}" class="text-success bg-success bg-opacity-10 rounded-circle p-2 d-inline-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                <i class="bi bi-chevron-left"></i>
            </a>
            <p class="fs-3 m-auto mb-0">Account Center</p>
        </div>
    </div>

    <div class="profile-header">
        <div class="profile-image">
            <img src="{{ asset('assets/landing/images/avatar.png') }}" alt="Profile Picture">
        </div>
        <div class="profile-name">{{ Auth::user()->name }}</div>
        <div class="profile-email">{{ Auth::user()->email }}</div>
    </div>

    <div class="profile-menu">
        <a href="#" class="profile-menu-item text-decoration-none text-dark">
            <i class="bi bi-person"></i>
            <span>Detail Profil</span>
        </a>
        <a href="{{ route('user.addresses') }}" class="profile-menu-item text-decoration-none text-dark">
            <i class="bi bi-geo-alt"></i>
            <span>Alamat Saya</span>
        </a>
        <a href="#" class="profile-menu-item text-decoration-none text-dark">
            <i class="bi bi-shield-lock"></i>
            <span>Privasi dan Keamanan</span>
        </a>
        <a href="{{ route('faq') }}" class="profile-menu-item text-decoration-none text-dark">
            <i class="bi bi-question-circle"></i>
            <span>Bantuan</span>
        </a>
        <a href="#" class="profile-menu-item text-decoration-none text-dark">
            <i class="bi bi-file-text"></i>
            <span>Syarat dan Ketentuan</span>
        </a>
        <button class="profile-menu-item text-decoration-none text-dark border-0 bg-transparent w-100 text-start" data-bs-toggle="modal" data-bs-target="#earlyAccessModal">
            <i class="bi bi-google-play"></i>
            <span>Early Access PlayStore</span>
        </button>
        <a href="#" class="profile-menu-item text-decoration-none text-dark" id="logoutLink">
            <i class="bi bi-box-arrow-right"></i>
            <span>Keluar</span>
        </a>
    </div>
</div>

<!-- Modal Early Access -->
<div class="modal fade" id="earlyAccessModal" tabindex="-1" aria-labelledby="earlyAccessModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="earlyAccessModalLabel">Panduan Early Access PlayStore</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Untuk mengakses versi early access aplikasi SOD di PlayStore, ikuti langkah-langkah berikut:</p>
        <ol>
          <li>Pastikan Anda menggunakan akun Google yang terdaftar: <strong>{{ Auth::user()->email }}</strong></li>
          <li>Klik link berikut untuk mengakses halaman early access: 
            <a href="https://play.google.com/apps/internaltest/4701084007459227187" target="_blank">Early Access SOD</a>
          </li>
          <li>Anda akan melihat halaman seperti gambar di bawah ini:</li>
          <div class="text-center">
            <img src="https://filemanager.layananberhentikuliah.com/storage/files/AB4Xv2EaEKJodmKn5jWxTrFXfluC9JdZucxAI0fu.jpg" alt="Early Access Screenshot" class="img-fluid">
          </div>
          <li>Jika Anda belum menginstal aplikasi, klik "download it on Google Play" untuk mengunduh dan menginstal.</li>
          <li>Jika Anda sudah menginstal aplikasi sebelumnya, Anda akan menerima pembaruan ke versi internal test secara otomatis.</li>
          <li>Tunggu beberapa saat hingga pembaruan tersedia di PlayStore Anda.</li>
          <li>Buka aplikasi SOD dan nikmati fitur-fitur terbaru!</li>
        </ol>
        <p><strong>Catatan:</strong> Pastikan untuk menggunakan email yang terdaftar ({{ Auth::user()->email }}) saat membuka link early access di browser Anda. Jika Anda mengalami kesulitan, coba logout dari akun Google lain dan gunakan hanya akun ini.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        <button type="button" class="btn btn-primary" onclick="copyLink()">Salin Link</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const logoutLink = document.getElementById('logoutLink');
    
    logoutLink.addEventListener('click', function(e) {
        e.preventDefault();
        
        if (confirm('Apakah Anda yakin ingin keluar?')) {
            // Buat form untuk logout
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("logout") }}';
            
            // Tambahkan CSRF token
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            form.appendChild(csrfToken);
            
            // Tambahkan form ke body dan submit
            document.body.appendChild(form);
            form.submit();
        }
    });
});

function copyLink() {
    var linkText = "https://play.google.com/apps/internaltest/4701084007459227187";
    navigator.clipboard.writeText(linkText).then(function() {
        alert("Link early access berhasil disalin!");
    }, function(err) {
        console.error('Gagal menyalin link: ', err);
    });
}
</script>
@endsection
