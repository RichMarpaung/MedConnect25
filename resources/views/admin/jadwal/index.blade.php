@extends('layouts.admin') {{-- Extend layout admin Anda --}}

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Manajemen Jadwal</h1>
            {{-- Tampilkan nama dokter yang sedang di-edit --}}
            <p class="text-muted mb-0">Untuk: <strong>{{ $dokter->user->name }}</strong></p>
        </div>
        <a href="{{ route('admin.tenaga-medis') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
        </a>
    </div>

    {{-- Memanggil komponen Livewire dan mengirim data dokter --}}
    @livewire('admin.jadwal-manager', ['dokter' => $dokter])

@endsection
