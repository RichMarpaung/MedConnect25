<div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Manajemen FAQ</h1>
        <button class="btn btn-primary" wire:click="create()">
            <i class="fas fa-plus me-1"></i> Tambah FAQ
        </button>
    </div>

    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            {{-- List FAQ --}}
            <div class="accordion shadow-sm" id="accordionFaqAdmin">
                @forelse($faqs as $faq)
                    <div class="accordion-item mb-3 border rounded overflow-hidden">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#faq{{ $faq->id }}">
                                <div class="d-flex justify-content-between w-100 align-items-center me-3">
                                    <span class="fw-bold text-dark">
                                        @if(!$faq->is_aktif) <span class="badge bg-secondary me-2">Draft</span> @endif
                                        {{ $faq->pertanyaan }}
                                    </span>
                                    <div class="btn-group">
                                        <button class="btn btn-sm btn-outline-warning border-0" wire:click.stop="edit({{ $faq->id }})">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger border-0"
                                                wire:click.stop="delete({{ $faq->id }})"
                                                wire:confirm="Hapus FAQ ini?">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </button>
                        </h2>
                        <div id="faq{{ $faq->id }}" class="accordion-collapse collapse" data-bs-parent="#accordionFaqAdmin">
                            <div class="accordion-body">
                                {{ $faq->jawaban }}
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="alert alert-secondary text-center">Belum ada data FAQ.</div>
                @endforelse
            </div>

            <div class="mt-3">
                {{ $faqs->links() }}
            </div>
        </div>
    </div>

    {{-- MODAL FORM --}}
    @if($isModalOpen)
    <div class="modal fade show" tabindex="-1" style="display: block; background: rgba(0,0,0,0.5);">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $isEditMode ? 'Edit FAQ' : 'Tambah FAQ' }}</h5>
                    <button type="button" class="btn-close" wire:click="closeModal"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="save">
                        <div class="mb-3">
                            <label class="form-label">Pertanyaan</label>
                            <input type="text" class="form-control @error('pertanyaan') is-invalid @enderror" wire:model="pertanyaan">
                            @error('pertanyaan') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jawaban</label>
                            <textarea class="form-control @error('jawaban') is-invalid @enderror" rows="4" wire:model="jawaban"></textarea>
                            @error('jawaban') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="is_aktif" wire:model="is_aktif">
                            <label class="form-check-label" for="is_aktif">Tampilkan di Website</label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" wire:click="closeModal">Batal</button>
                    <button class="btn btn-primary" wire:click="save">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
