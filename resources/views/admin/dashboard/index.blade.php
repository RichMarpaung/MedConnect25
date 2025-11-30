@extends('layouts.admin') {{-- Pastikan ini extend layout admin Anda --}}

@section('content')
    <h1 class="h3 mb-4">Dashboard</h1>

    <div class="row g-4">
        {{-- Kartu Tenaga Medis --}}
        <div class="col-md-4">
            <div class="card shadow-sm border-start border-primary border-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs fw-bold text-primary text-uppercase mb-1">
                                Tenaga Medis
                            </div>
                            <div class="h5 mb-0 fw-bold text-gray-800">{{ $jumlahTenagaMedis }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-md fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kartu Layanan --}}
        <div class="col-md-4">
            <div class="card shadow-sm border-start border-success border-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs fw-bold text-success text-uppercase mb-1">
                                Jumlah Layanan
                            </div>
                            <div class="h5 mb-0 fw-bold text-gray-800">{{ $jumlahLayanan }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-notes-medical fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kartu Reservasi --}}
        <div class="col-md-4">
            <div class="card shadow-sm border-start border-info border-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs fw-bold text-info text-uppercase mb-1">
                                Reservasi (Dijadwalkan)
                            </div>
                            <div class="h5 mb-0 fw-bold text-gray-800">{{ $jumlahReservasi }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Anda bisa tambahkan tabel reservasi terbaru di sini --}}

@endsection
