@extends('layouts.app')

@section('content')
<div class="container py-5">

    {{-- Menampilkan pesan sukses/error --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @elseif (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">

        {{-- ====================================== --}}
        {{-- KOLOM KIRI (Info Profil) --}}
        {{-- ====================================== --}}
        <div class="col-lg-4">
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center">
                    <i class="fas fa-user-circle fa-5x text-primary mb-3"></i>
                    <h4 class="card-title">{{ $user->name }}</h4>
                    <p class="text-muted mb-1">{{ $user->email }}</p>
                    <p class="text-muted mb-0">{{ $user->nomor_telepon ?? 'No. Telepon belum diatur' }}</p>
                </div>
            </div>
        </div>

        {{-- ====================================== --}}
        {{-- KOLOM KANAN (Riwayat Reservasi) --}}
        {{-- ====================================== --}}
        <div class="col-lg-8">
            <h4 class="mb-3">Riwayat Reservasi Saya</h4>

            <div class="card shadow-sm">
                {{-- Header List (Hanya tampil di Desktop) --}}
                <div class="card-body p-3 d-none d-md-block border-bottom">
                    <div class="row g-3 fw-bold text-muted small text-uppercase">
                        <div class="col-md-5">Reservasi</div>
                        <div class="col-md-2">Antrian</div>
                        <div class="col-md-2">Status</div>
                        <div class="col-md-3 text-end">Aksi</div>
                    </div>
                </div>

                {{-- Daftar Reservasi --}}
                <div class="list-group list-group-flush">

                    @forelse ($reservasiHistory as $reservasi)
                        <div class="list-group-item p-3">
                            <div class="row g-3 align-items-center">

                                {{-- Kolom 1: Info Dokter --}}
                                <div class="col-md-5">
                                    <small class="fw-bold text-muted d-md-none">Reservasi:</small>
                                    <h5 class="mb-1">{{ $reservasi->dokter?->user?->name ?? 'N/A' }}</h5>
                                    <p class="mb-1 text-muted small">{{ $reservasi->dokter?->layanan?->nama_layanan ?? '-' }}</p>
                                    <small class="text-dark">
                                        {{ \Carbon\Carbon::parse($reservasi->tanggal_reservasi)->isoFormat('dddd, D MMMM YYYY') }}
                                    </small>
                                </div>

                                {{-- Kolom 2: Antrian --}}
                                <div class="col-6 col-md-2">
                                    <small class="fw-bold text-muted d-md-none">Antrian:</small>
                                    <div><span class="badge bg-primary fs-6">{{ $reservasi->nomor_antrian }}</span></div>
                                </div>

                                {{-- Kolom 3: Status --}}
                                <div class="col-6 col-md-2">
                                    <small class="fw-bold text-muted d-md-none">Status:</small>
                                    <div>
                                        @if($reservasi->status == 'dijadwalkan')
                                            <span class="badge bg-info">Dijadwalkan</span>
                                        @elseif($reservasi->status == 'pending_payment')
                                            <span class="badge bg-warning">Menunggu Pembayaran</span>
                                        @elseif($reservasi->status == 'selesai')
                                            <span class="badge bg-success">Selesai</span>
                                        @elseif($reservasi->status == 'dibatalkan')
                                            <span class="badge bg-danger">Dibatalkan</span>
                                        @endif
                                    </div>
                                </div>

                                {{-- Kolom 4: Aksi (LOGIKA UTAMA) --}}
                                <div class="col-12 col-md-3 text-md-end mt-3 mt-md-0">

                                    @if($reservasi->status == 'pending_payment')
                                        {{-- Jika belum bayar --}}
                                        <div class="d-grid d-md-block">
                                            <a href="{{ route('payment.show', $reservasi->id) }}" class="btn btn-sm btn-success mb-2 mb-md-0">
                                                <i class="fas fa-wallet me-1"></i> Bayar
                                            </a>
                                            <form action="{{ route('reservation.cancel', $reservasi->id) }}" method="POST" onsubmit="return confirm('Batalkan reservasi ini?');" class="d-grid d-md-inline-block">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="fas fa-times me-1"></i> Batal
                                                </button>
                                            </form>
                                        </div>

                                    @elseif($reservasi->status == 'selesai')
                                        {{-- Jika sudah selesai --}}
                                        <div class="d-grid d-md-block gap-2">

                                            @if(!$reservasi->ulasan)
                                                {{-- Belum isi survei: Tombol Survei MUNCUL, Rekam Medis MATI --}}
                                                <a href="{{ route('survey.create', $reservasi->id) }}" class="btn btn-sm btn-warning text-dark mb-1 w-100">
                                                    <i class="fas fa-star me-1"></i> Isi Survei
                                                </a>
                                                <button class="btn btn-sm btn-outline-secondary w-100" disabled title="Isi survei untuk membuka rekam medis">
                                                    <i class="fas fa-lock me-1"></i> Rekam Medis
                                                </button>
                                            @else
                                                {{-- Sudah isi survei: Tombol Rekam Medis AKTIF --}}
                                                <a href="{{ route('medical-record.show', $reservasi->id) }}" class="btn btn-sm btn-info text-white w-100">
                                                    <i class="fas fa-file-medical me-1"></i> Rekam Medis
                                                </a>
                                            @endif

                                        </div>

                                    @elseif($reservasi->status == 'dijadwalkan')
                                        {{-- Jika sudah lunas --}}
                                        <div class="d-grid d-md-block">
                                            <a href="{{ route('booking.download', $reservasi->id) }}" class="btn btn-sm btn-secondary">
                                                <i class="fas fa-download me-1"></i> Unduh Tiket
                                            </a>
                                        </div>
                                    @else
                                        {{-- Dibatalkan --}}
                                        <span class="text-muted d-none d-md-block">-</span>
                                    @endif
                                </div>

                            </div>
                        </div>
                    @empty
                        <div class="list-group-item p-5 text-center">
                            <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Riwayat Kosong</h5>
                            <p>Anda belum memiliki riwayat reservasi.</p>
                            <a href="{{ route('booking.create') }}" class="btn btn-primary mt-2">Buat Reservasi Pertama Anda</a>
                        </div>
                    @endforelse

                </div>

                {{-- Paginasi --}}
                @if($reservasiHistory->hasPages())
                <div class="card-footer bg-white">
                    {{ $reservasiHistory->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
