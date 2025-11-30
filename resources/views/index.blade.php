<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klinik MedConnect - Platform Praktik Dokter Modern</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    {{-- Kita butuh @livewireStyles agar Livewire berfungsi --}}
    @livewireStyles
</head>

<body>

    {{-- ====================================== --}}
    {{-- ### NAVBAR ### --}}
    {{-- ====================================== --}}
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}">MedConnect</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a class="nav-link active" href="{{ route('home') }}">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="#features">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="#services">Layanan</a></li>
                    <li class="nav-item"><a class="nav-link" href="#team">Tim Medis</a></li>

                    {{-- Tombol Booking (selalu tampil) --}}
                    <li class="nav-item ms-lg-2">
                        <a href="{{ route('booking.create') }}" class="btn btn-primary btn-sm">Booking Janji Temu</a>
                    </li>

                    @auth
                        {{-- JIKA SUDAH LOGIN --}}
                        <li class="nav-item dropdown ms-lg-2">
                            <a class="nav-link profile-dropdown-btn dropdown-toggle" href="#"
                                id="navbarDropdownProfile" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownProfile">
                                <li>
                                    <h6 class="dropdown-header">{{ Auth::user()->name }}</h6>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                        <i class="fas fa-user-circle me-2"></i>Profile
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form-nav').submit();">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @else
                        {{-- JIKA BELUM LOGIN --}}
                        <li class="nav-item ms-lg-2">
                            <a class="btn btn-outline-primary btn-sm" href="{{ route('login') }}">Login</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    @auth
        <form method="POST" action="{{ route('logout') }}" id="logout-form-nav" class="d-none">
            @csrf
        </form>
    @endauth

    {{-- HERO SECTION --}}
    <header class="hero-section-v2">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 text-center text-lg-start">
                    <h1 class="display-4 fw-bold text-white mb-4">Perawatan Kesehatan Modern yang Anda Percayai</h1>
                    <p class="lead text-white-75 mb-5">Akses layanan medis berkualitas tinggi dengan mudah. Jadwalkan
                        konsultasi dengan dokter terbaik kami hanya dengan beberapa klik.</p>

                    <a href="{{ route('booking.create') }}" class="btn btn-light btn-lg px-5 py-3 me-3">Buat Janji Temu</a>

                    @guest
                    <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg px-5 py-3">Login Pasien</a>
                    @endguest
                </div>
                <div class="col-lg-6 d-none d-lg-block">
                    <img src="{{ asset('images/g7.jpg') }}" class="img-fluid rounded-3 hero-image"
                        alt="Dokter MedConnect">
                </div>
            </div>
        </div>
    </header>

    {{-- FEATURES --}}
    <section id="features" class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Mengapa Memilih MedConnect?</h2>
                <p class="text-muted">Kami berkomitmen memberikan pengalaman terbaik untuk kesehatan Anda.</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="fas fa-user-md"></i></div>
                        <h5 class="fw-bold mt-3">Dokter Profesional</h5>
                        <p class="text-muted">Tim kami terdiri dari para dokter spesialis yang berpengalaman dan
                            bersertifikat di bidangnya.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="fas fa-microscope"></i></div>
                        <h5 class="fw-bold mt-3">Teknologi Modern</h5>
                        <p class="text-muted">Kami menggunakan peralatan medis terkini untuk diagnosis yang akurat dan
                            penanganan yang efektif.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="fas fa-headset"></i></div>
                        <h5 class="fw-bold mt-3">Layanan Prioritas 24/7</h5>
                        <p class="text-muted">Dukungan pelanggan dan layanan darurat kami siap membantu Anda kapan
                            saja, di mana saja.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- LAYANAN (DYNAMIC) --}}
    <section id="services" class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Layanan Unggulan Kami</h2>
                <p class="text-muted">Menyediakan solusi komprehensif untuk setiap kebutuhan kesehatan Anda.</p>
            </div>
            <div class="row g-4">
                @forelse ($layanans as $layanan)
                <div class="col-md-6 col-lg-4">
                    <div class="service-card">
                        <div class="service-icon"><i class="{{ $layanan->icon ?? 'fas fa-stethoscope' }}"></i></div>
                        <h5 class="fw-bold">{{ $layanan->nama_layanan }}</h5>
                        <p>{{ $layanan->deskripsi ?? 'Deskripsi layanan belum tersedia.' }}</p>
                        <a href="{{ route('booking.create') }}" class="stretched-link"></a>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center">
                    <p class="text-muted">Layanan unggulan akan segera tersedia.</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- TIM MEDIS (DYNAMIC) --}}
    <section id="team" class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Temui Tim Medis Kami</h2>
                <p class="text-muted">Para ahli yang berdedikasi untuk merawat Anda.</p>
            </div>

            <div class="swiper team-slider">
                <div class="swiper-wrapper">
                    @if (isset($dokters) && !$dokters->isEmpty())
                        @foreach ($dokters as $dokter)
                            <div class="swiper-slide">
                                <div class="team-card">
                                    <img src="{{ $dokter->foto_profil ? asset('storage/' . $dokter->foto_profil) : 'https://picsum.photos/200/200?random=' . $dokter->id }}"
                                        class="team-img" alt="{{ $dokter->user->name }}">

                                    <h5 class="fw-bold mt-3">{{ $dokter->user->name }}</h5>
                                    <p class="text-primary fw-semibold">{{ $dokter->layanan?->nama_layanan ?? 'Dokter' }}</p>
                                    <p class="text-muted small">
                                        {{ $dokter->deskripsi_pengalaman ?? 'Seorang dokter profesional yang berdedikasi di MedConnect.' }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col text-center">
                            <p class="text-muted">Tim medis kami akan segera diperbarui.</p>
                        </div>
                    @endif
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section>

    {{-- TESTIMONI --}}
    <section id="testimonials" class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Apa Kata Pasien Kami</h2>
                <p class="text-muted">Kepuasan Anda adalah prioritas utama kami.</p>
            </div>
            <div class="row">
                <div class="col-md-6 mx-auto">
                    <div class="testimonial-card">
                        <p class="testimonial-text">"Pelayanannya sangat cepat dan dokternya ramah. Proses booking
                            online sangat membantu, tidak perlu antre lama lagi. Sangat direkomendasikan!"</p>
                        <div class="testimonial-author">
                            <img src="https://picsum.photos/100/100?random=8" alt="Author">
                            <div>
                                <h6 class="fw-bold mb-0">Andi Setiawan</h6>
                                <small class="text-muted">Pasien Gigi</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ====================================== --}}
    {{-- ### FAQ DINAMIS (DARI DATABASE) ### --}}
    {{-- ====================================== --}}
    <section id="faq" class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Pertanyaan Umum (FAQ)</h2>
                <p class="text-muted">Temukan jawaban cepat untuk pertanyaan Anda.</p>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="accordion" id="faqAccordion">

                        {{-- CEK APAKAH VARIABEL $faqs ADA DAN TIDAK KOSONG --}}
                        @if(isset($faqs) && $faqs->count() > 0)

                            {{-- LOOP DATA FAQ --}}
                            @foreach($faqs as $faq)
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading{{ $faq->id }}">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse{{ $faq->id }}" aria-expanded="false" aria-controls="collapse{{ $faq->id }}">
                                            {{ $faq->pertanyaan }}
                                        </button>
                                    </h2>
                                    <div id="collapse{{ $faq->id }}" class="accordion-collapse collapse"
                                        aria-labelledby="heading{{ $faq->id }}" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body text-muted">
                                            {{ $faq->jawaban }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        @else
                            {{-- TAMPILAN JIKA FAQ KOSONG --}}
                            <div class="text-center p-4 text-muted bg-light rounded border">
                                <i class="fas fa-info-circle me-2"></i> Belum ada pertanyaan umum yang ditambahkan.
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- ====================================== --}}
    {{-- ### AKHIR FAQ DINAMIS ### --}}
    {{-- ====================================== --}}

    <footer class="bg-dark text-white text-center py-4 mt-auto">
        <div class="container">
            <p>&copy; 2025 Klinik MedConnect. All Rights Reserved.</p>
            <div class="social-icons mt-3">
                <a href="#" class="text-white mx-2"><i class="fab fa-facebook-f fa-lg"></i></a>
                <a href="#" class="text-white mx-2"><i class="fab fa-twitter fa-lg"></i></a>
                <a href="#" class="text-white mx-2"><i class="fab fa-instagram fa-lg"></i></a>
                <a href="#" class="text-white mx-2"><i class="fab fa-whatsapp fa-lg"></i></a>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    @livewireScripts
    @stack('scripts')

    <script>
        const swiper = new Swiper('.team-slider', {
            direction: 'horizontal',
            loop: false,
            slidesPerView: 1,
            spaceBetween: 30,
            breakpoints: {
                768: { slidesPerView: 2, spaceBetween: 30 },
                992: { slidesPerView: 3, spaceBetween: 30 }
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
        });
    </script>

</body>
</html>
