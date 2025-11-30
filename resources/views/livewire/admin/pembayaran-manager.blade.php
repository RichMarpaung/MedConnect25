<div>
    <h1 class="h3 mb-4">Manajemen Pembayaran</h1>

    {{-- Pesan Sukses --}}
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
            <h5 class="mb-0 text-primary fw-bold">Riwayat Transaksi</h5>

            <div class="input-group" style="width: 300px;">
                <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-muted"></i></span>
                <input type="text" class="form-control border-start-0 ps-0"
                       placeholder="Cari ID atau Nama Pasien..."
                       wire:model.live="search">
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-muted text-uppercase small fw-bold">
                        <tr>
                            <th class="ps-4">ID TRX</th>
                            <th>Tanggal</th>
                            <th>Pasien</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pembayarans as $data)
                            <tr>
                                <td class="ps-4 fw-bold text-primary">#{{ $data->id }}</td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="fw-bold">{{ \Carbon\Carbon::parse($data->created_at)->format('d M Y') }}</span>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($data->created_at)->format('H:i') }}</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar rounded-circle bg-light text-dark d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px;">
                                            {{ substr($data->pasien->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="fw-bold">{{ $data->pasien->name }}</div>
                                            <div class="small text-muted">Dr. {{ $data->dokter->user->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="fw-bold">Rp 20.000</span>
                                    <br><small class="text-muted">Registrasi</small>
                                </td>
                                <td>
                                    @if($data->status == 'pending_payment')
                                        <span class="badge bg-warning text-dark">Belum Dibayar</span>
                                    @elseif($data->status == 'dijadwalkan')
                                        <span class="badge bg-success">Lunas</span>
                                    @elseif($data->status == 'selesai')
                                        <span class="badge bg-secondary">Selesai</span>
                                    @elseif($data->status == 'dibatalkan')
                                        <span class="badge bg-danger">Batal</span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    @if($data->status == 'pending_payment')
                                        <button class="btn btn-sm btn-outline-success"
                                                wire:click="verifikasi({{ $data->id }})"
                                                wire:confirm="Apakah Anda yakin ingin memverifikasi pembayaran ini secara manual? Status akan berubah menjadi Lunas (Dijadwalkan).">
                                            <i class="fas fa-check-double me-1"></i> Verifikasi Manual
                                        </button>
                                    @else
                                        <span class="text-muted small"><i class="fas fa-lock"></i></span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="fas fa-file-invoice-dollar fa-3x mb-3 opacity-50"></i>
                                    <p class="mb-0">Belum ada data transaksi.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($pembayarans->hasPages())
            <div class="card-footer bg-white border-top-0 pt-3 pb-3">
                {{ $pembayarans->links() }}
            </div>
        @endif
    </div>
</div>
