<div>
    <form wire:submit.prevent="saveRekamMedis">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white">
                <h5 class="mb-0">Catatan SOAP</h5>
            </div>
            <div class="card-body p-4">

                @if($existingRecord)
                    <div class="alert alert-info">
                        Anda sedang mengedit rekam medis yang sudah ada.
                    </div>
                @endif

                {{-- Subjektif --}}
                <div class="mb-3">
                    <label for="subjektif" class="form-label fs-5 fw-bold">S (Subjektif)</label>
                    <p class="text-muted small my-0">Keluhan utama yang disampaikan pasien.</p>
                    <textarea class="form-control @error('subjektif') is-invalid @enderror"
                              id="subjektif" rows="4" wire:model="subjektif"
                              placeholder="Cth: Pasien datang dengan keluhan demam 3 hari..."></textarea>
                    @error('subjektif') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>

                <hr>

                {{-- Objektif --}}
                <div class="mb-3">
                    <label for="objektif" class="form-label fs-5 fw-bold">O (Objektif)</label>
                    <p class="text-muted small my-0">Hasil pemeriksaan fisik oleh dokter (Tanda vital, dll).</p>
                    <textarea class="form-control @error('objektif') is-invalid @enderror"
                              id="objektif" rows="4" wire:model="objektif"
                              placeholder="Cth: Kesadaran: Compos Mentis, Tensi: 120/80, Suhu: 38.5°C..."></textarea>
                    @error('objektif') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>

                <hr>

                {{-- Assessment --}}
                <div class="mb-3">
                    <label for="assessment" class="form-label fs-5 fw-bold">A (Assessment)</label>
                    <p class="text-muted small my-0">Diagnosa kerja berdasarkan S dan O.</p>
                    <textarea class="form-control @error('assessment') is-invalid @enderror"
                              id="assessment" rows="3" wire:model="assessment"
                              placeholder="Cth: Demam Tifoid, Observasi Febris"></textarea>
                    @error('assessment') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>

                <hr>

                {{-- Plan --}}
                <div class="mb-3">
                    <label for="plan" class="form-label fs-5 fw-bold">P (Plan)</label>
                    <p class="text-muted small my-0">Rencana penanganan, terapi, resep obat, atau edukasi.</p>
                    <textarea class="form-control @error('plan') is-invalid @enderror"
                              id="plan" rows="5" wire:model="plan"
                              placeholder="Cth: 1. Cek Lab Darah Lengkap. 2. Paracetamol 3x500mg. 3. Istirahat cukup..."></textarea>
                    @error('plan') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>

            </div>
            <div class="card-footer bg-white text-end">
                <button type="submit" class="btn btn-primary btn-lg">
                    <span wire:loading.remove wire:target="saveRekamMedis">
                        <i class="fas fa-save me-2"></i> Simpan Rekam Medis & Selesaikan
                    </span>
                    <span wire:loading wire:target="saveRekamMedis">
                        Menyimpan...
                    </span>
                </button>
            </div>
        </div>
    </form>
</div>
