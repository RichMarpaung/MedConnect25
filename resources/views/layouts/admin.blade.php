<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - MedConnect</title>

   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    {{-- TAMBAHKAN INI --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-iconpicker/1.10.0/css/bootstrap-iconpicker.min.css"/>

    <link rel="stylesheet" href="{{ asset('css/admin-style.css') }}">
    @livewireStyles
</head>
<body>

<div class="d-flex">
    {{-- =================================== --}}
    {{-- SIDEBAR (Kiri) --}}
    {{-- =================================== --}}
    <nav class="sidebar bg-primary text-white">
        <div class="sidebar-header">
            <a class="navbar-brand fw-bold fs-4" href="{{ route('admin.dashboard') }}">MedConnect</a>
        </div>

        {{-- ### MULAI PERUBAHAN MENU ### --}}
        <ul class="nav flex-column sidebar-nav">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                   href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.tenaga-medis') ? 'active' : '' }}"
                   href="{{ route('admin.tenaga-medis') }}">
                    <i class="fas fa-user-md me-2"></i> Tenaga Medis
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.layanan.index') ? 'active' : '' }}"
                   href="{{ route('admin.layanan.index') }}">
                    <i class="fas fa-notes-medical me-2"></i> Layanan
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.pasien.index') ? 'active' : '' }}"
                   href="{{ route('admin.pasien.index') }}">
                    <i class="fas fa-user-injured me-2"></i> Pasien
                </a>
            </li>
            <li class="nav-item">
                {{-- PERBARUI BARIS INI --}}
                <a class="nav-link {{ request()->routeIs('admin.pembayaran.index') ? 'active' : '' }}"
                   href="{{ route('admin.pembayaran.index') }}">
                    <i class="fas fa-credit-card me-2"></i> Pembayaran
                </a>
            </li>
           <li class="nav-item">
                {{-- PERBARUI BARIS INI --}}
                <a class="nav-link {{ request()->routeIs('admin.survey.index') ? 'active' : '' }}"
                   href="{{ route('admin.survey.index') }}">
                    <i class="fas fa-smile-beam me-2"></i> Survey Kepuasan
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.faq.index') ? 'active' : '' }}"
                   href="{{ route('admin.faq.index') }}">
                    <i class="fas fa-question-circle me-2"></i> FAQ
                </a>
            </li>
        </ul>
        {{-- ### AKHIR PERUBAHAN MENU ### --}}

        <div class="sidebar-logout">
            <a class="nav-link" href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt me-2"></i> Log out
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </nav>

    {{-- =================================== --}}
    {{-- KONTEN UTAMA (Kanan) --}}
    {{-- =================================== --}}
    <main class="content-container flex-grow-1 p-4">

        {{-- Di sinilah konten Livewire kita akan dimuat --}}
        @yield('content')

    </main>
</div>
@livewireScripts
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

{{-- TAMBAHKAN INI --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-iconpicker/1.10.0/js/bootstrap-iconpicker.bundle.min.js"></script>

@stack('scripts')
</body>
</html>
