<div>
    {{-- Judul Halaman --}}
    <h1 class="h3 mb-4">Manajemen Layanan</h1>

    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Tabel Layanan --}}
    <div class="card shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Daftar Layanan</h5>
            <div class="d-flex">
                <input type="text" class="form-control me-2" placeholder="Cari layanan..." wire:model.live="search">
                <button class="btn btn-primary text-nowrap" wire:click="create()">
                    <i class="fas fa-plus me-1"></i> Tambah Baru
                </button>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Ikon</th>
                            <th>Nama Layanan</th>
                            <th>Deskripsi</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($layanans as $layanan)
                        <tr>
                            <td>{{ $layanan->id }}</td>
                            <td>
                                <i class="{{ $layanan->icon ?? 'fas fa-question-circle' }} fa-2x text-muted"></i>
                            </td>
                            <td>
                                <strong>{{ $layanan->nama_layanan }}</strong><br>
                                <small class="text-muted">/{{ $layanan->slug }}</small>
                            </td>
                            <td>{{ Str::limit($layanan->deskripsi, 50) }}</td>
                            <td>
                                @if($layanan->is_aktif)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Non-Aktif</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-sm btn-warning" wire:click="edit({{ $layanan->id }})">
                                    Edit
                                </button>
                                <button class="btn btn-sm btn-danger"
                                        wire:click="delete({{ $layanan->id }})"
                                        wire:confirm="Anda yakin ingin menghapus layanan ini?">
                                    Hapus
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <p class="mb-0 text-muted">Data layanan tidak ditemukan.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($layanans->hasPages())
        <div class="card-footer bg-white">
            {{ $layanans->links() }}
        </div>
        @endif
    </div>

    {{-- ====================================== --}}
    {{-- ### MODAL (VERSI SEBELUMNYA) ### --}}
    {{-- ====================================== --}}
    @if($isModalOpen)
    <div class="modal fade show" tabindex="-1" style="display: block;" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $isEditMode ? 'Edit Layanan' : 'Tambah Layanan Baru' }}</h5>
                    <button type="button" class="btn-close" wire:click="closeModal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{-- Form dikembalikan ke text field biasa --}}
                    <div>
                        <div class="mb-3">
                            <label for="nama_layanan" class="form-label">Nama Layanan</label>
                            <input type="text" class="form-control @error('nama_layanan') is-invalid @enderror"
                                   id="nama_layanan" wire:model="nama_layanan">
                            @error('nama_layanan') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        {{-- KEMBALIKAN KE TEXT FIELD --}}
                        <div class="mb-3">
                            <label for="icon" class="form-label">Kelas Ikon (Font Awesome)</label>
                            <input type="text" class="form-control @error('icon') is-invalid @enderror"
                                   id="icon" wire:model="icon" placeholder="Contoh: fas fa-stethoscope">
                            @error('icon') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror"
                                      id="deskripsi" wire:model="deskripsi" rows="3"></textarea>
                            @error('deskripsi') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3 form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="is_aktif"
                                   wire:model="is_aktif" checked>
                            <label class="form-check-label" for="is_aktif">Aktifkan Layanan Ini</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="closeModal">Batal</button>
                    <button type="button" class="btn btn-primary" wire:click="save">
                        {{ $isEditMode ? 'Simpan Perubahan' : 'Simpan' }}
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-backdrop fade show"></div>
    @endif
</div>
