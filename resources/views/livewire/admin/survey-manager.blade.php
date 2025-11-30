<div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Manajemen Pertanyaan Kuesioner</h1>
        <button class="btn btn-primary" wire:click="create()">
            <i class="fas fa-plus me-1"></i> Tambah Pertanyaan
        </button>
    </div>

    {{-- Alert Messages --}}
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Loop Group Kategori --}}
    @foreach($groupedPertanyaans as $kategori => $items)
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light fw-bold text-primary">
                {{ $kategori }}
            </div>
            <div class="list-group list-group-flush">
                @foreach($items as $q)
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-start">
                            <span class="me-3 text-muted">{{ $loop->iteration }}.</span>
                            <div>
                                <span class="{{ $q->is_aktif ? 'text-dark' : 'text-muted text-decoration-line-through' }}">
                                    {{ $q->pertanyaan }}
                                </span>
                                @if(!$q->is_aktif)
                                    <span class="badge bg-secondary ms-2" style="font-size: 0.7em;">Non-Aktif</span>
                                @endif
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            {{-- Toggle Switch Status --}}
                            <div class="form-check form-switch" title="Aktifkan/Non-aktifkan">
                                <input class="form-check-input" type="checkbox"
                                       wire:click="toggleStatus({{ $q->id }})"
                                       {{ $q->is_aktif ? 'checked' : '' }}>
                            </div>

                            <button class="btn btn-sm btn-outline-warning border-0" wire:click="edit({{ $q->id }})">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger border-0"
                                    wire:click="delete({{ $q->id }})"
                                    wire:confirm="Hapus pertanyaan ini?">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach

    {{-- ====================================== --}}
    {{-- ### MODAL UNTUK CREATE & EDIT ### --}}
    {{-- ====================================== --}}
    @if($isModalOpen)
    <div class="modal fade show" tabindex="-1" style="display: block; background: rgba(0,0,0,0.5);" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $isEditMode ? 'Edit Pertanyaan' : 'Tambah Pertanyaan Baru' }}</h5>
                    <button type="button" class="btn-close" wire:click="closeModal"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="save">
                        <div class="mb-3">
                            <label class="form-label">Kategori</label>
                            <select class="form-select @error('kategori') is-invalid @enderror" wire:model="kategori">
                                @foreach($kategoriList as $kat)
                                    <option value="{{ $kat }}">{{ $kat }}</option>
                                @endforeach
                            </select>
                            @error('kategori') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Teks Pertanyaan</label>
                            <textarea class="form-control @error('pertanyaan_text') is-invalid @enderror"
                                      wire:model="pertanyaan_text" rows="3"></textarea>
                            @error('pertanyaan_text') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3 form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="is_aktif_modal" wire:model="is_aktif">
                            <label class="form-check-label" for="is_aktif_modal">Status Aktif</label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="closeModal">Batal</button>
                    <button type="button" class="btn btn-primary" wire:click="save">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
