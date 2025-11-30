@extends('layouts.dokter') {{-- Gunakan layout dokter --}}

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Form Pemeriksaan Pasien</h1>
            <p class="text-muted mb-0">
                Pasien: <strong>{{ $reservasi->pasien->name }}</strong> (Antrian: {{ $reservasi->nomor_antrian }})
            </p>
        </div>
        <a href="{{ route('dokter.dashboard') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali ke Antrian
        </a>
    </div>

    {{-- Panggil komponen Livewire untuk form SOAP --}}
    @livewire('dokter.form-rekam-medis', ['reservasi' => $reservasi])

@endsection
