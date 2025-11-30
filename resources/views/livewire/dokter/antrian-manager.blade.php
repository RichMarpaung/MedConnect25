<div class="card shadow-sm border-0">
    <div class="card-body p-4">
        <h4 class="text-center mb-4">Daftar Antrian Pasien</h4>

        <div class="list-group list-group-flush">
            @forelse($antrianHariIni as $reservasi)
                <div class="list-group-item list-group-item-action p-3 mb-2 rounded border">
                    <div class="d-flex justify-content-between align-items-center">
                        {{-- Info Pasien --}}
                        <div class="fs-5">
                            <span class="badge bg-primary me-2">Antrian {{ $reservasi->nomor_antrian }}</span>
                            <strong>{{ $reservasi->pasien->name }}</strong>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div>
                            {{-- Tombol "Periksa" (sudah benar) --}}
                            <button wire:click="periksa({{ $reservasi->id }})" class="btn btn-sm btn-primary">
                                <i class="fas fa-stethoscope me-1"></i> Periksa
                            </button>

                            {{-- Tombol "Resep Obat" DIHAPUS DARI SINI --}}
                        </div>
                    </div>
                </div>
            @empty
                <div class="list-group-item p-4 text-center">
                    <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                    <h5 class="text-muted">Tidak ada antrian pasien untuk hari ini.</h5>
                </div>
            @endforelse
        </div>
    </div>
</div>
