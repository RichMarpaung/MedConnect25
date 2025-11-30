@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg text-center">
                <div class="card-body p-4 p-md-5">
                    <i class="fas fa-check-circle fa-4x text-success mb-3"></i>
                    <h2 class="mb-2">Reservasi Dikonfirmasi!</h2>
                    <p class="text-muted">Terima kasih. Reservasi Anda telah berhasil dikonfirmasi.</p>

                    <ul class="list-group list-group-flush text-start my-4">
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>ID Reservasi:</strong>
                            <span>{{ $reservasi->id }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>Nomor Antrian Anda:</strong>
                            <span class="badge bg-primary fs-6">{{ $reservasi->nomor_antrian }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>Dokter:</strong>
                            {{-- Menggunakan nullsafe operator untuk keamanan --}}
                            <span>{{ $reservasi->dokter?->user?->name ?? 'N/A' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>Layanan:</strong>
                            <span>{{ $reservasi->dokter?->layanan?->nama_layanan ?? 'Layanan tidak terdaftar' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>Tanggal:</strong>
                            <span>{{ \Carbon\Carbon::parse($reservasi->tanggal_reservasi)->isoFormat('dddd, D MMMM YYYY') }}</span>
                        </li>
                    </ul>

                    {{-- ### PERUBAHAN DI SINI ### --}}
                    <div class="d-grid gap-2"> {{-- Menggunakan gap-2 untuk memberi jarak --}}

                        {{-- Tombol PDF Baru --}}
                        <a href="{{ route('booking.download', $reservasi->id) }}" class="btn btn-secondary">
                            <i class="fas fa-download me-2"></i>Unduh Tiket PDF
                        </a>

                        <a href="{{ route('home') }}" class="btn btn-primary">Kembali ke Beranda</a>
                    </div>
                    {{-- ### AKHIR PERUBAHAN ### --}}

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
