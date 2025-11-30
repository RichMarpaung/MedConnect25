<div>
    <div class="card shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Daftar Pasien Selesai</h5>
            <input type="text" class="form-control" style="width: 300px;"
                   placeholder="Cari nama pasien..." wire:model.live="search">
        </div>

        {{-- Header Tabel (Hanya Desktop) --}}
        <div class="card-body p-3 d-none d-md-block border-bottom">
            <div class="row g-3 fw-bold text-muted small text-uppercase">
                <div class="col-md-3">Tanggal</div>
                <div class="col-md-3">Nama Pasien</div>
                <div class="col-md-4">Assessment (Diagnosa)</div>
                <div class="col-md-2 text-end">Aksi</div>
            </div>
        </div>

        {{-- Daftar Riwayat --}}
        <div class="list-group list-group-flush">
            @forelse($riwayat as $reservasi)
                <div class="list-group-item p-3">
                    <div class="row g-3 align-items-center">

                        {{-- Kolom 1: Tanggal --}}
                        <div class="col-12 col-md-3">
                            <small class="fw-bold text-muted d-md-none">Tanggal:</small>
                            <p class="mb-0 fw-bold">{{ $reservasi->tanggal_reservasi->isoFormat('D MMM YYYY') }}</p>
                        </div>

                        {{-- Kolom 2: Nama Pasien --}}
                        <div class="col-12 col-md-3">
                            <small class="fw-bold text-muted d-md-none">Pasien:</small>
                            <p class="mb-0">{{ $reservasi->pasien->name }}</p>
                        </div>

                        {{-- Kolom 3: Assessment/Diagnosa --}}
                        <div class="col-12 col-md-4">
                            <small class="fw-bold text-muted d-md-none">Diagnosa:</small>
                            <p class="mb-0 text-muted fst-italic">
                                {{-- Ambil 'assessment' dari rekam medis --}}
                                {{ $reservasi->rekamMedis?->assessment ?? '-' }}
                            </p>
                        </div>

                        {{-- Kolom 4: Aksi --}}
                        <div class="col-12 col-md-2 text-md-end mt-3 mt-md-0">
                            {{-- Kita gunakan rute 'periksa' yang sudah ada --}}
                            <a href="{{ route('dokter.periksa', $reservasi->id) }}" class="btn btn-sm btn-outline-info">
                                Lihat Detail
                            </a>
                        </div>

                    </div>
                </div>
            @empty
                <div class="list-group-item p-5 text-center">
                    <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Riwayat pasien masih kosong.</h5>
                </div>
            @endforelse
        </div>

        {{-- Paginasi --}}
        @if($riwayat->hasPages())
        <div class="card-footer bg-white">
            {{ $riwayat->links() }}
        </div>
        @endif
    </div>
</div>
