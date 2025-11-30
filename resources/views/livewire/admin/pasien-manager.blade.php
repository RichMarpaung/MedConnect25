<div>
    <h1 class="h3 mb-4">Manajemen Pasien</h1>

    {{-- Tampilkan pesan sukses/error --}}
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
            <h5 class="mb-0">Daftar Akun Pasien</h5>
            <input type="text" class="form-control" style="width: 300px;"
                   placeholder="Cari nama atau email pasien..." wire:model.live="search">
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Nama Pasien</th>
                            <th>Email</th>
                            <th>No. Telepon</th>
                            <th>Tgl. Bergabung</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pasiens as $pasien)
                        <tr>
                            <td>{{ $pasien->id }}</td>
                            <td>
                                <strong>{{ $pasien->name }}</strong>
                            </td>
                            <td>{{ $pasien->email }}</td>
                            <td>{{ $pasien->nomor_telepon ?? '-' }}</td>
                            <td>{{ $pasien->created_at->isoFormat('D MMM YYYY') }}</td>
                            <td>
                                <button class="btn btn-sm btn-danger"
                                        wire:click="delete({{ $pasien->id }})"
                                        wire:confirm="Anda yakin ingin menghapus pasien {{ $pasien->name }}?">
                                    Hapus
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <p class="mb-0 text-muted">Data pasien tidak ditemukan.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($pasiens->hasPages())
        <div class="card-footer bg-white">
            {{ $pasiens->links() }}
        </div>
        @endif
    </div>
</div>
