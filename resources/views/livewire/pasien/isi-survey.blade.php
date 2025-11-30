<div> {{-- <<< ROOT ELEMENT (PENTING: JANGAN DIHAPUS) --}}

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                {{-- Header Halaman --}}
                <div class="text-center mb-5">
                    <h2 class="fw-bold">Survei Kepuasan Pelayanan</h2>
                    <p class="text-muted">
                        Kunjungan: {{ \Carbon\Carbon::parse($reservasi->tanggal_reservasi)->isoFormat('D MMMM YYYY') }} <br>
                        Dokter: <strong>{{ $reservasi->dokter->user->name }}</strong>
                    </p>
                </div>

                <form wire:submit.prevent="submit">

                    {{-- 1. TAMPILKAN ERROR GLOBAL (Jika ada yang terlewat) --}}
                    @if ($errors->any())
                        <div class="alert alert-danger mb-4">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            Mohon lengkapi semua pertanyaan yang wajib diisi.
                        </div>
                    @endif

                    @php
                        $colors = ['bg-primary-subtle', 'bg-success-subtle', 'bg-warning-subtle', 'bg-info-subtle', 'bg-secondary-subtle'];
                        $i = 0;
                    @endphp

                    {{-- 2. LOOP KATEGORI (A, B, C...) --}}
                    @foreach($groupedPertanyaans as $kategori => $items)
                        <div class="card shadow-sm border-0 mb-4">
                            {{-- Header Kategori dengan warna bergantian --}}
                            <div class="card-header {{ $colors[$i % count($colors)] }} py-3">
                                <h5 class="mb-0 fw-bold text-dark">{{ $kategori }}</h5>
                            </div>

                            <div class="card-body">
                                {{-- 3. LOOP PERTANYAAN --}}
                                @foreach($items as $p)
                                    <div class="mb-4 border-bottom pb-3 last-no-border">
                                        <p class="fw-semibold mb-2">{{ $loop->iteration }}. {{ $p->pertanyaan }}</p>

                                        {{-- Pilihan Radio Button (1-5) --}}
                                        <div class="d-flex flex-wrap gap-3 mt-2">
                                            @foreach([5 => 'Sangat Setuju', 4 => 'Setuju', 3 => 'Cukup', 2 => 'Tidak Setuju', 1 => 'Sangat Tidak Setuju'] as $val => $label)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                           wire:model="answers.{{ $p->id }}"
                                                           id="q{{ $p->id }}_opt{{ $val }}"
                                                           value="{{ $val }}">
                                                    <label class="form-check-label small" for="q{{ $p->id }}_opt{{ $val }}">
                                                        {{ $label }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>

                                        {{-- Pesan Error Per Pertanyaan --}}
                                        @error("answers.{$p->id}")
                                            <span class="text-danger small d-block mt-2">
                                                <i class="fas fa-exclamation-triangle me-1"></i> Wajib diisi
                                            </span>
                                        @enderror
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @php $i++; @endphp
                    @endforeach

                    {{-- 4. KOMENTAR TAMBAHAN --}}
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-body">
                            <label class="form-label fw-bold">Kritik & Saran Tambahan (Opsional)</label>
                            <textarea class="form-control" rows="3" wire:model="komentar_umum" placeholder="Tulis masukan Anda di sini..."></textarea>
                        </div>
                    </div>

                    {{-- 5. TOMBOL SUBMIT DENGAN LOADING STATE --}}
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="submit">
                                <i class="fas fa-paper-plane me-2"></i> Kirim Survei
                            </span>
                            <span wire:loading wire:target="submit">
                                <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                                Mengirim...
                            </span>
                        </button>
                        <a href="{{ route('profile.edit') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>

                </form>
            </div>
        </div>
    </div>

    {{-- CSS KHUSUS --}}
    <style>
        .last-no-border:last-child { border-bottom: none !important; padding-bottom: 0 !important; }
    </style>

</div> {{-- <<< TUTUP ROOT ELEMENT --}}
