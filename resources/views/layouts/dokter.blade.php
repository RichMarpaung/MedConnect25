<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dokter Dashboard - MedConnect</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    {{-- Kita akan gunakan CSS Admin yang sama karena tampilannya mirip --}}
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
            <a class="navbar-brand fw-bold fs-4" href="{{ route('dokter.dashboard') }}">MedConnect</a>
        </div>

        <ul class="nav flex-column sidebar-nav">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('dokter.dashboard') ? 'active' : '' }}"
                   href="{{ route('dokter.dashboard') }}">
                    <i class="fas fa-list-ul me-2"></i> List Pasien
                </a>
            </li>
           <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('dokter.riwayat') ? 'active' : '' }}"
                   href="{{ route('dokter.riwayat') }}"> {{-- Ganti '#' --}}
                    <i class="fas fa-history me-2"></i> Riwayat Pasien
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('dokter.profile') ? 'active' : '' }}"
                   href="{{ route('dokter.profile') }}"> {{-- Ganti '#' --}}
                    <i class="fas fa-user-circle me-2"></i> Profile
                </a>
            </li>
        </ul>

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

        {{-- Konten dari 'index' atau 'periksa' akan dimuat di sini --}}
        @yield('content')

    </main>
</div>

@livewireScripts
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')

</body>
</html>
