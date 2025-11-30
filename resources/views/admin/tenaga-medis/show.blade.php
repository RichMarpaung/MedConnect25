@extends('layouts.admin') {{-- Pastikan extend layout admin Anda --}}

@section('content')
    <h1 class="h3 mb-4">Profil Tenaga Medis</h1>

    <div class="row">
        {{-- Kolom Kiri: Foto & Info Utama --}}
        <div class="col-lg-4">
            <div class="card shadow-sm mb-4">
                {{-- 'text-center' di sini akan menengahkan teks di bawah --}}
                <div class="card-body text-center">

                    {{-- =================================== --}}
                    {{-- ### PERUBAHAN DI SINI ### --}}
                    {{-- =================================== --}}

                    @if($dokter->foto_profil)
                        <img src="{{ asset('storage/' . $dokter->foto_profil) }}" alt="{{ $dokter->user->name }}"
                             {{-- Tambahkan 'mx-auto' untuk menengahkan gambar --}}
                             class="rounded-circle img-thumbnail mb-3 mx-auto"
                             style="width: 150px; height: 150px; object-fit: cover;">
                    @else
                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mb-3 mx-auto"
                             {{-- Tambahkan 'mx-auto' untuk menengahkan placeholder --}}
                             style="width: 150px; height: 150px;">
                            <i class="fas fa-user-md fa-4x text-muted"></i>
                        </div>
                    @endif

                    {{-- =================================== --}}
                    {{-- ### AKHIR PERUBAHAN ### --}}
                    {{-- =================================== --}}

                    <h4 class="card-title mb-1">{{ $dokter->user->name }}</h4>
                    <p class="text-primary fw-bold mb-2">{{ $dokter->layanan?->nama_layanan ?? 'N/A' }}</p>
                    <a href="mailto:{{ $dokter->user->email }}" class="text-muted small">{{ $dokter->user->email }}</a><br>
                    <span class="text-muted small">{{ $dokter->user->nomor_telepon ?? 'Kontak belum diatur' }}</span>
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Detail Info --}}
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Detail Informasi</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong>Nama Lengkap</strong>
                            <span>{{ $dokter->user->name }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong>Email Login</strong>
                            <span>{{ $dokter->user->email }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong>Nomor Kontak</strong>
                            <span>{{ $dokter->user->nomor_telepon ?? '-' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong>Spesialisasi (Layanan)</strong>
                            <span>{{ $dokter->layanan?->nama_layanan ?? '-' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong>Nomor Izin Praktek</strong>
                            <span>{{ $dokter->nomor_izin_praktek }}</span>
                        </li>
                        <li class="list-group-item">
                            <strong>Profil Singkat / Pengalaman</strong>
                            <p class="text-muted mt-1 mb-0">
                                {{ $dokter->deskripsi_pengalaman ?? '-' }}
                            </p>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Jadwal Praktek --}}
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Jadwal Praktek</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Hari</th>
                                    <th>Jam Mulai</th>
                                    <th>Jam Selesai</th>
                                    <th>Kuota</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($dokter->jadwal as $jadwal) {{-- 'jadwal' (singular) sesuai Model Anda --}}
                                    <tr>
                                        <td><strong>{{ $jadwal->hari }}</strong></td>
                                        <td>{{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}</td>
                                        <td>{{ $jadwal->kuota_pasien }} pasien</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted p-3">
                                            Dokter ini belum memiliki jadwal praktek.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4">
        {{-- Link ini kembali ke halaman daftar --}}
        <a href="{{ route('admin.tenaga-medis') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
        </a>
    </div>
@endsection
