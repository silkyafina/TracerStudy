<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tracer Study | Universitas Harkat Negeri</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('images/logo-univ2.png') }}">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/front.css') }}">
</head>
<body>

<!-- ================= NAVBAR ================= -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top navbar-custom">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="#">
            <img src="{{ asset('images/logo-univ2.png') }}" class="logo">
            <div>
                <div class="brand-title">Tracer Study</div>
                <div class="brand-subtitle">Universitas Harkat Negeri</div>
            </div>
        </a>

        <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navMain">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navMain">
            <ul class="navbar-nav ms-auto align-items-center gap-3">
                <li class="nav-item"><a class="nav-link" href="#beranda">Beranda</a></li>
                <li class="nav-item"><a class="nav-link" href="#tentang">Tentang</a></li>
                <li class="nav-item"><a class="nav-link" href="#berita">Berita</a></li>

                

                <li class="nav-item dropdown">
                    <a class="btn btn-maroon dropdown-toggle text-white" href="#" data-bs-toggle="dropdown">
                        Login
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('alumni.login') }}">Login Alumni</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.login') }}">Login Admin</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- ================= HERO SECTION ================= -->
<section class="hero-section" id="beranda">
    <div class="hero-overlay"></div>
    
    <div class="container hero-content">
        <h1>
            Selamat Datang<br>
            Di Website <span>Tracer Study</span>
        </h1>

        <p>Universitas Harkat Negeri</p>

        <div class="hero-action">
            <a href="#panduan" class="btn btn-outline-maroon">
                Panduan Pengisian
            </a>
            <a href="{{ route('alumni.login') }}" class="btn btn-maroon">
                Isi Survey
            </a>
        </div>
    </div>
</section>

<!-- ================= APA ITU TRACER STUDY ================= -->
<section class="section" id="tentang">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-md-6">
                <h3 class="section-title">
                    Apa itu <span>Tracer Study</span>?
                </h3>
                <p class="section-text">
                    Tracer study, atau penelusuran karir alumni, merupakan suatu metode penelitian yang umumnya dilakukan oleh perguruan tinggi untuk melacak jejak dan perkembangan karir alumni setelah mahasiswa menyelesaikan studi. Tujuan utama dari Tracer study adalah untuk memahami sejauh mana lulusan perguruan tinggi telah berhasil menerapkan pengetahuan dan keterampilan yang mereka peroleh selama masa studi, serta untuk mendapatkan umpan balik konstruktif yang dapat digunakan untuk meningkatkan kualitas pendidikan di perguruan tinggi tersebut.
                </p>
            </div>

            <div class="col-md-6">
                <div class="info-box">
                    Mendukung peningkatan mutu pendidikan dan akreditasi perguruan tinggi 
                    melalui evaluasi berkala terhadap kinerja alumni di dunia kerja.
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ================= PANDUAN PENGISIAN ================= -->
<section class="panduan-section" id="panduan">
    <div class="container">
        <h3 class="text-center text-white mb-5">
            Panduan Pengisian Tracer Study
        </h3>

        <div class="row g-4">
            <div class="col-lg-3 col-md-6 col-12">
                <div class="panduan-card">
                    <div class="step">1</div>
                    <p>Klik tombol Isi Survey di halaman utama</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-12">
                <div class="panduan-card">
                    <div class="step">2</div>
                    <p>Login menggunakan akun Alumni Anda</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-12">
                <div class="panduan-card">
                    <div class="step">3</div>
                    <p>Isi seluruh kuesioner dengan lengkap</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-12">
                <div class="panduan-card">
                    <div class="step">4</div>
                    <p>Submit data dan selesai</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ================= BERITA TERBARU ================= -->
<section class="section" id="berita">
    <div class="container">
        <h3 class="section-title text-center mb-5">
            Berita Terbaru
        </h3>

        <div class="row g-4">
            <div class="col-lg-4 col-md-6 col-12">
                <div class="card news-card">
                    <div class="card-body">
                        <h6>Tracer Study 2025</h6>
                        <p class="text-muted small mb-3">
                            Pelaksanaan tracer study tahun akademik 2024/2025 telah resmi dibuka 
                            untuk seluruh alumni Universitas Harkat Negeri.
                        </p>
                        <a href="#" class="read-more">Baca selengkapnya</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-12">
                <div class="card news-card">
                    <div class="card-body">
                        <h6>Workshop Alumni</h6>
                        <p class="text-muted small mb-3">
                            Universitas mengadakan workshop pengembangan karir untuk alumni 
                            yang akan dilaksanakan bulan depan.
                        </p>
                        <a href="#" class="read-more">Baca selengkapnya</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-12">
                <div class="card news-card">
                    <div class="card-body">
                        <h6>Hasil Survey 2024</h6>
                        <p class="text-muted small mb-3">
                            Laporan hasil tracer study tahun 2024 menunjukkan peningkatan 
                            signifikan dalam penyerapan tenaga kerja alumni.
                        </p>
                        <a href="#" class="read-more">Baca selengkapnya</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-5">
            <a href="#" class="btn btn-outline-maroon">
                Tampilkan Semua Berita
            </a>
        </div>
    </div>
</section>

<!-- ================= FOOTER ================= -->
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-3 mb-4 mb-md-0">
                <strong>Tracer Study</strong>
                <p class="mt-2">
                    <i class="bi bi-geo-alt-fill text-white me-2"></i>Gedung Student Center<br>
                    <span class="ms-4">Universitas Harkat Negeri</span><br>
                    <span class="ms-4">Jl. Mataram No. 9</span><br>
                    <span class="ms-4">Margadana, Kota Tegal</span>
                </p>
            </div>
            
            <div class="col-md-3 mb-4 mb-md-0">
                <strong>Kontak</strong>
                <p class="mt-2">
                    <i class="bi bi-envelope-fill text-white me-2"></i>
                    <a href="mailto:alumnikarir@harkatnegeri.ac.id" class="text-decoration-none">alumnikarir@harkatnegeri.ac.id</a><br>
                    
                    <i class="bi bi-telephone-fill text-white me-2"></i>
                    <a href="tel:0211234567" class="text-decoration-none">(021) 123-4567</a><br>
                    
                    <i class="bi bi-whatsapp text-white me-2"></i>
                    <a href="https://wa.me/6281511877770" class="text-decoration-none">+62 815-1187-7770</a>
                </p>
            </div>
            
            <div class="col-md-3 mb-4 mb-md-0">
                <strong>Tautan Cepat</strong>
                <p class="mt-2">
                    <i class="bi bi-file-text-fill text-white me-2"></i>
                    <a href="#panduan" class="text-decoration-none">Panduan Pengisian</a><br>
                    
                    <i class="bi bi-clipboard-check-fill text-white me-2"></i>
                    <a href="#" class="text-decoration-none">Isi Survey</a><br>
                    
                    <i class="bi bi-newspaper text-white me-2"></i>
                    <a href="#berita" class="text-decoration-none">Berita</a>
                </p>
            
            </div>

            <div class="col-md-3">
                <strong>Ikuti Kami</strong>
                <div class="social-media">
                    <a href="https://www.facebook.com/univharkatnegeri/?rdid=Nd9UUCakQhdaqH2H" class="social-icon" title="Facebook">
                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </a>
                    <a href="https://www.instagram.com/alumnikarir_harkatnegeri/" class="social-icon" title="Instagram">
                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                    </a>
                    <a href="https://www.youtube.com/@harkatnegeri" class="social-icon" title="YouTube">
                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                        </svg>
                    </a>
                    <a href="https://www.linkedin.com/school/univharkatnegeri/posts/?feedView=all" class="social-icon" title="LinkedIn">
                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <hr>
        <div class="text-center small">
            © 2025 Universitas Harkat Negeri. All Rights Reserved.
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>