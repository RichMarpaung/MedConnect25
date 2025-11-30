
<div>
    <div class="text-center mb-5">
        <a href="{{ route('home') }}" class="text-decoration-none d-inline-block mb-3">
            <i class="fas fa-arrow-left me-2"></i>Kembali ke Beranda
        </a>
        <h2>Buat Janji Temu</h2>
        <p class="text-muted">Ikuti langkah-langkah di bawah ini untuk memesan jadwal Anda.</p>
    </div>

    <div class="card shadow-lg booking-card">
        <div class="card-body p-4 p-md-5">

            {{-- Bagian progress bar ini kita buat dinamis berdasarkan $currentStep --}}
            <div class="progress-bar-container mb-5">
                <div class="progress-bar-step @if($currentStep >= 1) active @endif">
                    <div class="step-icon"><i class="fas fa-notes-medical"></i></div>
                    <p>Layanan</p>
                </div>
                <div class="progress-bar-line"></div>
                <div class="progress-bar-step @if($currentStep >= 2) active @endif">
                    <div class="step-icon"><i class="fas fa-calendar-alt"></i></div>
                    <p>Jadwal</p>
                </div>
                <div class="progress-bar-line"></div>
                <div class="progress-bar-step @if($currentStep == 3) active @endif">
                    <div class="step-icon"><i class="fas fa-user"></i></div>
                    <p>Data Diri</p>
                </div>
            </div>

            {{-- Form di-submit ke method 'submitBooking' --}}
            <form wire:submit.prevent="submitBooking">

                {{-- ====================================== --}}
                {{-- ### LANGKAH 1: PILIH LAYANAN ### --}}
                {{-- ====================================== --}}
                <div class="form-step @if($currentStep == 1) active @endif">
                    <h4 class="text-center mb-4">Langkah 1: Pilih Layanan (Spesialisasi)</h4>
                    <div class="row g-3">

                        {{-- Loop dari database --}}
                        @foreach($layanans as $layanan)
                        <div class="col-md-6">
                            {{--
                                wire:click: Memperbarui $selectedLayananId di controller.
                                class: Menjadi 'active' jika ID-nya dipilih.
                            --}}
                            <div
                                class="selection-card @if($selectedLayananId == $layanan->id) active @endif"
                                wire:click="$set('selectedLayananId', {{ $layanan->id }})">
                                <i class="{{ $layanan->icon  }} fa-2x"></i> {{-- Ganti ikon jika perlu --}}
                                <span>{{ $layanan->nama_layanan }}</span>
                            </div>
                        </div>
                        @endforeach

                        @error('selectedLayananId') <span class="text-danger small">{{ $message }}</span> @enderror

                    </div>
                    <div class="text-end mt-4">
                        {{-- Tombol Lanjut, panggil method 'nextStep' --}}
                        <button type="button" class="btn btn-primary" wire:click="nextStep">
                            Lanjut <i class="fas fa-arrow-right ms-2"></i>
                        </button>
                    </div>
                </div>

                {{-- ====================================== --}}
                {{-- ### LANGKAH 2: PILIH JADWAL ### --}}
                {{-- ====================================== --}}
                <div class="form-step @if($currentStep == 2) active @endif">
                    <h4 class="text-center mb-4">Langkah 2: Pilih Jadwal & Dokter</h4>

                    {{-- 1. Pilih Dokter --}}
                    <div class="mb-4">
                        <label class="form-label">Pilih Dokter</label>
                        <div class="row g-3">
                            @forelse($dokters as $dokter)
                            <div class="col-md-6">
                                <div
    class="selection-card @if($selectedDokterId == $dokter->id) active @endif"
    wire:click="$set('selectedDokterId', {{ $dokter->id }})">

    <i class="fas fa-user-doctor fa-2x"></i>

    {{-- Grup untuk Nama dan Hari --}}
    <div class="ms-2 text-start">

        {{-- Nama Dokter --}}
        <span class="d-block fw-bold">{{ $dokter->user->name }}</span>

        {{-- Keterangan Hari --}}
        <small class="text-muted" style="font-size: 0.8rem; line-height: 1.2;">
            @if($dokter->jadwal->isNotEmpty())
                {{-- Menggabungkan semua hari unik --}}
                {{ $dokter->jadwal->pluck('hari')->unique()->implode(', ') }}
            @else
                Jadwal belum tersedia
            @endif
        </small>

    </div>
</div>
                            </div>
                            @empty
                            <p class="text-muted">Pilih layanan di langkah 1 untuk melihat dokter.</p>
                            @endforelse
                        </div>
                        @error('selectedDokterId') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    {{-- 2. Pilih Tanggal (Hanya tampil jika dokter sudah dipilih) --}}
                    @if($selectedDokterId)
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="tanggalKunjungan" class="form-label">Tanggal Kunjungan</label>
                            {{-- wire:model.live: Otomatis update $selectedTanggal saat diubah --}}
                            <input type="date" class="form-control" id="tanggalKunjungan" wire:model.live="selectedTanggal">
                        </div>
                    </div>

                    {{--
                        3. Tampilkan Info Jadwal & Kuota (Dihapus input jam)
                        Bagian ini akan tampil otomatis jika tanggal valid
                    --}}
                    <div wire:loading wire:target="updatedSelectedTanggal">
                        <p class="text-muted">Mengecek jadwal dan kuota...</p>
                    </div>

                    @if ($errorMessage)
                        <div class="alert alert-danger">{{ $errorMessage }}</div>
                    @elseif ($jadwalForDay && $kuotaTersisa > 0)
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle me-2"></i>
                            Jadwal tersedia pada hari {{ $jadwalForDay->hari }}.<br>
                            Jam Praktek: <strong>{{ \Carbon\Carbon::parse($jadwalForDay->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwalForDay->jam_selesai)->format('H:i') }}</strong><br>
                            Sisa Kuota Hari Ini: <strong>{{ $kuotaTersisa }}</strong>
                        </div>
                    @endif
                    @error('kuotaTersisa') <span class="text-danger small">Kuota tidak tersedia.</span> @enderror
                    @endif

                    <div class="d-flex justify-content-between mt-4">
                        <button type="button" class="btn btn-outline-secondary" wire:click="prevStep">
                            <i class="fas fa-arrow-left me-2"></i> Kembali
                        </button>
                        <button type="button" class="btn btn-primary" wire:click="nextStep">
                            Lanjut <i class="fas fa-arrow-right ms-2"></i>
                        </button>
                    </div>
                </div>

                {{-- ====================================== --}}
                {{-- ### LANGKAH 3: DATA DIRI ### --}}
                {{-- ====================================== --}}
                <div class="form-step @if($currentStep == 3) active @endif">
                    <h4 class="text-center mb-4">Langkah 3: Lengkapi Data Diri</h4>

                    {{-- Tampilkan ringkasan --}}
                    <div class="alert alert-light mb-4">
    <strong>Layanan:</strong> {{ $layanans->firstWhere('id', $selectedLayananId)->nama_layanan ?? 'N/A' }} <br>
    <strong>Dokter:</strong> {{ $dokters->firstWhere('id', $selectedDokterId)->user->name ?? 'N/A' }} <br>
    <strong>Tanggal:</strong> {{ $selectedTanggal ? \Carbon\Carbon::parse($selectedTanggal)->isoFormat('dddd, D MMMM YYYY') : 'N/A' }}
</div>

                    {{-- Bind data ke properti Livewire --}}
                    <div class="mb-3">
                        <label for="namaPasien" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="namaPasien" wire:model="namaPasien" required>
                        @error('namaPasien') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="noTelp" class="form-label">No. Telepon/WhatsApp</label>
                        <input type="tel" class="form-control" id="noTelp" wire:model="noTelp" required>
                        @error('noTelp') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <button type="button" class="btn btn-outline-secondary" wire:click="prevStep">
                            <i class="fas fa-arrow-left me-2"></i> Kembali
                        </button>
                        <button type="submit" class="btn btn-primary">
                            {{-- Tampilkan spinner saat loading --}}
                            <span wire:loading.remove wire:target="submitBooking">
                                Konfirmasi Booking <i class="fas fa-check ms-2"></i>
                            </span>
                            <span wire:loading wire:target="submitBooking">
                                Memproses...
                            </span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

