<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang di MedConnect</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <div class="container-fluid ps-md-0">
        <div class="row g-0">
            <div class="d-none d-md-flex col-md-4 col-lg-6 bg-image">
                <img src="{{ asset('images/g4.png') }}" alt="">
            </div>

            <div class="col-md-8 col-lg-6">
                <div class="login d-flex align-items-center py-5">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-9 col-lg-8 mx-auto">
                                <a class="navbar-brand fw-bold fs-2 text-primary mb-4 d-block" href="{{ route('home') }}">MedConnect</a>

                                {{-- ================== --}}
                                {{-- FORM LOGIN --}}
                                {{-- ================== --}}
                                <div id="login-form">
                                    <h3 class="login-heading mb-4">Selamat Datang Kembali!</h3>

                                    @error('email')
                                    <div class="alert alert-danger" role="alert">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                    @if (session('success'))
                                        <div class="alert alert-success" role="alert">
                                            {{ session('success') }}
                                        </div>
                                    @endif

                                    <form method="POST" action="{{ route('login.submit') }}">
                                        @csrf
                                        <div class="form-floating mb-3">
                                            <input type="email" class="form-control" id="loginEmail" name="email" placeholder="nama@contoh.com" value="{{ old('email') }}" required>
                                            <label for="loginEmail">Alamat Email</label>
                                        </div>

                                        {{-- PERBAIKAN: Tombol lihat password untuk Login --}}
                                        <div class="form-floating mb-3 position-relative">
                                            <input type="password" class="form-control" id="loginPassword" name="password" placeholder="Password" required>
                                            <label for="loginPassword">Password</label>
                                            <span class="password-toggle-icon">
                                                <i class="fas fa-eye"></i>
                                            </span>
                                        </div>

                                        <div class="d-grid">
                                            <button class="btn btn-lg btn-primary btn-login text-uppercase fw-bold mb-2" type="submit">Masuk</button>
                                            <div class="text-center">
                                                <p class="small">Belum punya akun? <a href="#" id="show-register">Buat akun</a></p>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                {{-- ================== --}}
                                {{-- FORM REGISTER --}}
                                {{-- ================== --}}
                                <div id="register-form" style="display: none;">
                                    <h3 class="login-heading mb-4">Buat Akun Baru</h3>

                                    <form method="POST" action="{{ route('register.submit') }}">
                                        @csrf
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="regNama" name="name" placeholder="Nama Lengkap" value="{{ old('name') }}" required>
                                            <label for="regNama">Nama Lengkap</label>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="regEmail" name="email" placeholder="nama@contoh.com" value="{{ old('email') }}" required>
                                            <label for="regEmail">Alamat Email</label>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- ### 1. FIELD NOMOR TELEPON DITAMBAHKAN ### --}}
                                        <div class="form-floating mb-3">
                                            <input type="tel" class="form-control @error('nomor_telepon') is-invalid @enderror" id="regNomorTelepon" name="nomor_telepon" placeholder="0812345678" value="{{ old('nomor_telepon') }}" required>
                                            <label for="regNomorTelepon">Nomor Telepon</label>
                                            @error('nomor_telepon')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- ### 2. FIELD PASSWORD DIPERBARUI DENGAN IKON ### --}}
                                        <div class="form-floating mb-3 position-relative">
                                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="regPassword" name="password" placeholder="Password" required>
                                            <label for="regPassword">Password</label>
                                            <span class="password-toggle-icon">
                                                <i class="fas fa-eye"></i>
                                            </span>
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- ### 3. FIELD KONFIRMASI DIPERBARUI DENGAN IKON ### --}}
                                        <div class="form-floating mb-3 position-relative">
                                            <input type="password" class="form-control" id="regPasswordConfirm" name="password_confirmation" placeholder="Konfirmasi Password" required>
                                            <label for="regPasswordConfirm">Konfirmasi Password</label>
                                            <span class="password-toggle-icon">
                                                <i class="fas fa-eye"></i>
                                            </span>
                                        </div>

                                        <div class="d-grid">
                                            <button class="btn btn-lg btn-primary btn-login text-uppercase fw-bold mb-2" type="submit">Daftar</button>
                                            <div class="text-center">
                                                <p class="small">Sudah punya akun? <a href="#" id="show-login">Masuk di sini</a></p>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="text-center mt-4">
                                    <a href="{{ route('home') }}" class="text-decoration-none"><i class="fas fa-arrow-left me-2"></i>Kembali ke Beranda</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const loginForm = document.getElementById('login-form');
        const registerForm = document.getElementById('register-form');
        const showRegister = document.getElementById('show-register');
        const showLogin = document.getElementById('show-login');

        showRegister.addEventListener('click', function(e) {
            e.preventDefault();
            loginForm.style.display = 'none';
            registerForm.style.display = 'block';
        });

        showLogin.addEventListener('click', function(e) {
            e.preventDefault();
            registerForm.style.display = 'none';
            loginForm.style.display = 'block';
        });

        // Script untuk tetap menampilkan form register jika ada error validasi
        @if ($errors->any() && session('show_register'))
            loginForm.style.display = 'none';
            registerForm.style.display = 'block';
        @endif

        // ===================================
        // ### 4. JAVASCRIPT UNTUK IKON MATA ###
        // ===================================
        document.querySelectorAll('.password-toggle-icon').forEach(item => {
            item.addEventListener('click', function (e) {
                // 'this' adalah <span> yang diklik
                // 'this.parentElement' adalah <div> 'form-floating'
                // 'querySelector('input')' adalah input password di dalamnya
                const input = this.parentElement.querySelector('input');
                const icon = this.querySelector('i');

                // Ubah tipe input
                if (input.type === "password") {
                    input.type = "text";
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    input.type = "password";
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        });
    </script>
</body>
</html>
