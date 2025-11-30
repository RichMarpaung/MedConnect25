<div>
    <div class="row g-4">
        {{-- Kolom Kiri: Info Profil & Password --}}
        <div class="col-lg-8">
            {{-- Form Info Profil --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Informasi Profil</h5>
                </div>
                <div class="card-body">
                    @if (session()->has('message'))
                        <div class="alert alert-success">{{ session('message') }}</div>
                    @endif

                    <form wire:submit.prevent="saveProfile">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" wire:model="name">
                            @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" wire:model="email">
                            @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="nomor_telepon" class="form-label">Nomor Telepon</label>
                            <input type="text" class="form-control @error('nomor_telepon') is-invalid @enderror" id="nomor_telepon" wire:model="nomor_telepon">
                            @error('nomor_telepon') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi_pengalaman" class="form-label">Deskripsi / Pengalaman Singkat</label>
                            <textarea class="form-control @error('deskripsi_pengalaman') is-invalid @enderror" id="deskripsi_pengalaman" rows="4" wire:model="deskripsi_pengalaman"></textarea>
                            @error('deskripsi_pengalaman') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan Profil</button>
                    </form>
                </div>
            </div>

            {{-- Form Ganti Password --}}
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Ganti Password</h5>
                </div>
                <div class="card-body">
                    @if (session()->has('message_password'))
                        <div class="alert alert-success">{{ session('message_password') }}</div>
                    @endif

                    <form wire:submit.prevent="savePassword">
                        <div class="mb-3">
                            <label for="password" class="form-label">Password Baru</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" wire:model="password">
                            @error('password') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" class="form-control" id="password_confirmation" wire:model="password_confirmation">
                        </div>
                        <button type="submit" class="btn btn-primary">Ganti Password</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Foto Profil --}}
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Foto Profil</h5>
                </div>
                <div class="card-body text-center">
                    {{-- Preview Foto --}}
                    <div class="mb-3">
                        @if ($foto_profil)
                            <img src="{{ $foto_profil->temporaryUrl() }}" class="rounded-circle img-thumbnail" style="width: 200px; height: 200px; object-fit: cover;">
                        @elseif ($existing_foto_profil)
                            <img src="{{ asset('storage/' . $existing_foto_profil) }}" class="rounded-circle img-thumbnail" style="width: 200px; height: 200px; object-fit: cover;">
                        @else
                            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center" style="width: 200px; height: 200px;">
                                <i class="fas fa-user-md fa-5x text-muted"></i>
                            </div>
                        @endif
                    </div>

                    <div wire:loading wire:target="foto_profil" class="text-primary small mb-2">
                        Mengunggah foto...
                    </div>

                    <label for="foto_profil_input" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-upload me-1"></i> Ganti Foto
                    </label>
                    <input type="file" id="foto_profil_input" class="d-none" wire:model="foto_profil">
                    @error('foto_profil') <span class="d-block text-danger small mt-2">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>
    </div>
</div>
