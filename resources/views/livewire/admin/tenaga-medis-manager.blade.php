<div>
    <h1 class="h3 mb-4">Manajemen Tenaga Medis</h1>

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

    <div class="card shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Daftar Tenaga Medis</h5>
            <div class="d-flex">
                <input type="text" class="form-control me-2" placeholder="Cari Nama..." wire:model.live="search">
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
                            <th scope="col">No</th>
                            <th scope="col">Foto</th> {{-- <-- KOLOM BARU --}}
                            <th scope="col">Nama</th>
                            <th scope="col">Spesialisasi</th>
                            <th scope="col">Kontak</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dokters as $index => $dokter)
                            <tr>
                                <td>{{ $dokters->firstItem() + $index }}</td>
                                <td>
                                    {{-- Tampilkan Foto Profil --}}
                                    @if ($dokter->foto_profil)
                                        <img src="{{ asset('storage/' . $dokter->foto_profil) }}"
                                            alt="{{ $dokter->user->name }}" class="rounded-circle"
                                            style="width: 45px; height: 45px; object-fit: cover;">
                                    @else
                                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center"
                                            style="width: 45px; height: 45px;">
                                            <i class="fas fa-user text-muted"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $dokter->user->name }}</strong><br>
                                    <small class="text-muted">{{ $dokter->user->email }}</small>
                                </td>
                                <td>{{ $dokter->layanan?->nama_layanan ?? 'N/A' }}</td>
                                <td>{{ $dokter->user->nomor_telepon ?? '-' }}</td>
                                <td>
                                    {{-- ### TOMBOL BARU ### --}}
                                    <a href="{{ route('admin.tenaga-medis.show', $dokter->id) }}"
                                        class="btn btn-sm btn-info" >
                                        Show
                                    </a>
                                    {{-- ### AKHIR TOMBOL BARU ### --}}

                                    <button class="btn btn-sm btn-warning" wire:click="edit({{ $dokter->id }})">
                                        Edit
                                    </button>
<a href="{{ route('admin.jadwal.index', $dokter->id) }}" class="btn btn-sm btn-success">
        Jadwal
    </a>
                                    <button class="btn btn-sm btn-danger" wire:click="delete({{ $dokter->id }})"
                                        wire:confirm="Anda yakin ingin menghapus {{ $dokter->user->name }}? Ini juga akan menghapus user login-nya.">
                                        Hapus
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4"> {{-- colspan jadi 6 --}}
                                    <p class="mb-0 text-muted">Data tidak ditemukan.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($dokters->hasPages())
            <div class="card-footer bg-white">
                {{ $dokters->links() }}
            </div>
        @endif
    </div>

    {{-- ====================================== --}}
    {{-- ### MODAL UNTUK CREATE & EDIT ### --}}
    {{-- ====================================== --}}
    @if ($isModalOpen)
        <div class="modal fade show" tabindex="-1" style="display: block;" aria-modal="true" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $isEditMode ? 'Edit Tenaga Medis' : 'Tambah Tenaga Medis' }}</h5>
                        <button type="button" class="btn-close" wire:click="closeModal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        {{-- Form sekarang di-trigger oleh 'save' --}}
                        <form wire:submit.prevent="save">
                            <div class="row g-3">
                                {{-- Kolom Kiri (Form) --}}
                                <div class="col-md-8">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                                            <input type="text"
                                                class="form-control @error('nama_lengkap') is-invalid @enderror"
                                                id="nama_lengkap" wire:model="nama_lengkap">
                                            @error('nama_lengkap')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="email" class="form-label">Email (untuk login)</label>
                                            <input type="email"
                                                class="form-control @error('email') is-invalid @enderror" id="email"
                                                wire:model="email">
                                            @error('email')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                id="password" wire:model="password"
                                                {{ $isEditMode ? 'placeholder=Kosongkan jika tidak diubah' : '' }}>
                                            @error('password')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="nomor_telepon" class="form-label">Kontak (No. Telepon)</label>
                                            <input type="text"
                                                class="form-control @error('nomor_telepon') is-invalid @enderror"
                                                id="nomor_telepon" wire:model="nomor_telepon">
                                            @error('nomor_telepon')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="layanan_id" class="form-label">Spesialisasi (Layanan)</label>
                                            <select class="form-select @error('layanan_id') is-invalid @enderror"
                                                id="layanan_id" wire:model="layanan_id">
                                                <option value="">Pilih Layanan...</option>
                                                @foreach ($layanans as $layanan)
                                                    <option value="{{ $layanan->id }}">{{ $layanan->nama_layanan }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('layanan_id')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="nomor_izin_praktek" class="form-label">Nomor Izin
                                                Praktek</label>
                                            <input type="text"
                                                class="form-control @error('nomor_izin_praktek') is-invalid @enderror"
                                                id="nomor_izin_praktek" wire:model="nomor_izin_praktek">
                                            @error('nomor_izin_praktek')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- Kolom Kanan (Upload Foto) --}}
                                <div class="col-md-4">
                                    <label for="foto_profil" class="form-label">Foto Profil</label>

                                    {{-- Preview Foto --}}
                                    <div class="mb-2 text-center">
                                        @if ($foto_profil)
                                            {{-- Preview foto baru --}}
                                            <img src="{{ $foto_profil->temporaryUrl() }}" class="img-thumbnail"
                                                style="width: 150px; height: 150px; object-fit: cover;">
                                        @elseif ($existing_foto_profil)
                                            {{-- Foto lama (saat edit) --}}
                                            <img src="{{ asset('storage/' . $existing_foto_profil) }}"
                                                class="img-thumbnail"
                                                style="width: 150px; height: 150px; object-fit: cover;">
                                        @else
                                            {{-- Placeholder --}}
                                            <div class="img-thumbnail d-flex align-items-center justify-content-center bg-light"
                                                style="width: 150px; height: 150px;">
                                                <i class="fas fa-image fa-3x text-muted"></i>
                                            </div>
                                        @endif
                                    </div>

                                    <input type="file"
                                        class="form-control @error('foto_profil') is-invalid @enderror"
                                        id="foto_profil" wire:model="foto_profil">
                                    @error('foto_profil')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror

                                    {{-- Loading indicator --}}
                                    <div wire:loading wire:target="foto_profil" class="text-primary small mt-1">
                                        Mengunggah foto...
                                    </div>
                                </div>

                                {{-- Deskripsi (bawah) --}}
                                <div class="col-12">
                                    <label for="deskripsi_pengalaman" class="form-label">Profil Singkat /
                                        Pengalaman</label>
                                    <textarea class="form-control @error('deskripsi_pengalaman') is-invalid @enderror" id="deskripsi_pengalaman"
                                        wire:model="deskripsi_pengalaman" rows="3"></textarea>
                                    @error('deskripsi_pengalaman')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeModal">Batal</button>
                        {{-- Tombol simpan sekarang memicu 'save' --}}
                        <button type="button" class="btn btn-primary" wire:click="save">
                            <span wire:loading.remove wire:target="save">
                                {{ $isEditMode ? 'Simpan Perubahan' : 'Simpan' }}
                            </span>
                            <span wire:loading wire:target="save">
                                Menyimpan...
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-backdrop fade show"></div>
    @endif
</div>
