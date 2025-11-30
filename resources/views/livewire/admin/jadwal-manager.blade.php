<div>
    {{-- Tampilkan pesan sukses/error --}}
    @if (session()->has('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif
    @if (session()->has('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row g-4">
        {{-- Kolom Kiri: Form Tambah Jadwal --}}
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Tambah Jadwal Baru</h5>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="saveJadwal">
                        <div class="mb-3">
                            <label for="hari" class="form-label">Hari</label>
                            <select class="form-select @error('hari') is-invalid @enderror" wire:model="hari">
                                <option value="">Pilih Hari...</option>
                                <option value="Senin">Senin</option>
                                <option value="Selasa">Selasa</option>
                                <option value="Rabu">Rabu</option>
                                <option value="Kamis">Kamis</option>
                                <option value="Jumat">Jumat</option>
                                <option value="Sabtu">Sabtu</option>
                                <option value="Minggu">Minggu</option>
                            </select>
                            @error('hari') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                        <div class_comment="mb-3">
                            <label class_comment="form-label">Jam Praktek</label>
                            <div class="input-group">
                                <input type="time" class="form-control @error('jam_mulai') is-invalid @enderror" wire:model="jam_mulai">
                                <span class="input-group-text">-</span>
                                <input type="time" class="form-control @error('jam_selesai') is-invalid @enderror" wire:model="jam_selesai">
                            </div>
                            @error('jam_mulai') <span class="d-block invalid-feedback">{{ $message }}</span> @enderror
                            @error('jam_selesai') <span class="d-block invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="kuota_pasien" class="form-label">Kuota Pasien</label>
                            <input type="number" class="form-control @error('kuota_pasien') is-invalid @enderror" wire:model="kuota_pasien">
                            @error('kuota_pasien') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <span wire:loading.remove wire:target="saveJadwal">
                                    <i class="fas fa-plus me-1"></i> Tambah Jadwal
                                </span>
                                <span wire:loading wire:target="saveJadwal">
                                    Menyimpan...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Daftar Jadwal Aktif --}}
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Daftar Jadwal Aktif</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Hari</th>
                                    <th>Jam Mulai</th>
                                    <th>Jam Selesai</th>
                                    <th>Kuota</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($jadwals as $jadwal)
                                <tr>
                                    <td><strong>{{ $jadwal->hari }}</strong></td>
                                    <td>{{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}</td>
                                    <td>{{ $jadwal->kuota_pasien }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-danger"
                                                wire:click="deleteJadwal({{ $jadwal->id }})"
                                                wire:confirm="Anda yakin ingin menghapus jadwal ini?">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center p-4 text-muted">
                                        Belum ada jadwal yang ditambahkan.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
