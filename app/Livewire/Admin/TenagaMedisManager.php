<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use App\Models\Dokter;
use App\Models\Layanan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage; // <-- TAMBAHKAN INI
use Livewire\WithPagination;
use Livewire\WithFileUploads; // <-- TAMBAHKAN INI

class TenagaMedisManager extends Component
{
    use WithPagination;
    use WithFileUploads; // <-- TAMBAHKAN INI

    // Properti untuk Form
    public $dokter_id;
    public $user_id;
    public $nama_lengkap, $email, $password, $nomor_telepon;
    public $layanan_id, $nomor_izin_praktek, $deskripsi_pengalaman;

    // Properti untuk Foto Profil
    public $foto_profil; // Untuk upload file baru
    public $existing_foto_profil; // Untuk menampilkan foto lama

    // Properti UI
    public $isModalOpen = false;
    public $search = '';
    public $isEditMode = false;
    protected $paginationTheme = 'bootstrap';

    public $layanans;

    public function mount()
    {
        $this->layanans = Layanan::where('is_aktif', true)->get();
    }

    public function render()
    {
        $dokters = Dokter::with(['user', 'layanan'])
            ->whereHas('user', function ($query) {
                $query->where('name', 'like', '%'.$this->search.'%');
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.admin.tenaga-medis-manager', [
            'dokters' => $dokters
        ]);
    }

    private function resetInputFields()
    {
        $this->dokter_id = null;
        $this->user_id = null;
        $this->nama_lengkap = '';
        $this->email = '';
        $this->password = '';
        $this->nomor_telepon = '';
        $this->layanan_id = '';
        $this->nomor_izin_praktek = '';
        $this->deskripsi_pengalaman = '';
        $this->foto_profil = null; // <-- TAMBAHKAN INI
        $this->existing_foto_profil = null; // <-- TAMBAHKAN INI
        $this->isModalOpen = false;
        $this->isEditMode = false;
    }

    public function create()
    {
        $this->resetInputFields();
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->resetInputFields();
    }

    public function save()
    {
        // 1. Validasi
        $rules = [
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->user_id,
            'nomor_telepon' => 'nullable|string',
            'layanan_id' => 'required|exists:layanans,id',
            'nomor_izin_praktek' => 'required|string|unique:dokters,nomor_izin_praktek,' . $this->dokter_id,
            'deskripsi_pengalaman' => 'nullable|string',
            'foto_profil' => 'nullable|image|max:2048', // Validasi foto (max 2MB)
        ];

        if (!$this->isEditMode) {
            $rules['password'] = 'required|string|min:8';
        }

        $this->validate($rules);

        // Gunakan Transaksi Database
        DB::transaction(function () {
            // 2. Ambil Role Dokter
            $role_dokter_id = DB::table('roles')->where('name', 'dokter')->first()->id;

            // 3. Siapkan data User
            $userData = [
                'name' => $this->nama_lengkap,
                'email' => $this->email,
                'nomor_telepon' => $this->nomor_telepon,
                'role_id' => $role_dokter_id,
            ];

            if (!empty($this->password)) {
                $userData['password'] = Hash::make($this->password);
            }

            // 4. Siapkan data Dokter
            $dokterData = [
                'layanan_id' => $this->layanan_id,
                'nomor_izin_praktek' => $this->nomor_izin_praktek,
                'deskripsi_pengalaman' => $this->deskripsi_pengalaman,
            ];

            // 5. Logika Upload Foto
            if ($this->foto_profil) {
                // Hapus foto lama jika ada (saat edit)
                if ($this->existing_foto_profil) {
                    Storage::disk('public')->delete($this->existing_foto_profil);
                }
                // Simpan foto baru
                $path = $this->foto_profil->store('foto-profil', 'public');
                $dokterData['foto_profil'] = $path;
            }

            // 6. Pisahkan logika Create dan Update
            if ($this->isEditMode) {
                $user = User::find($this->user_id);
                $user->update($userData);

                $dokter = Dokter::find($this->dokter_id);
                $dokterData['user_id'] = $user->id;
                $dokter->update($dokterData);
            } else {
                $user = User::create($userData);
                $dokterData['user_id'] = $user->id;
                Dokter::create($dokterData);
            }
        });

        session()->flash('message',
            $this->isEditMode ? 'Data Tenaga Medis berhasil diperbarui.' : 'Tenaga Medis baru berhasil ditambahkan.');

        $this->closeModal();
    }

    public function edit($id)
    {
        $dokter = Dokter::with('user')->findOrFail($id);

        $this->dokter_id = $dokter->id;
        $this->user_id = $dokter->user_id;

        $this->nama_lengkap = $dokter->user->name;
        $this->email = $dokter->user->email;
        $this->nomor_telepon = $dokter->user->nomor_telepon;
        $this->password = '';

        $this->layanan_id = $dokter->layanan_id;
        $this->nomor_izin_praktek = $dokter->nomor_izin_praktek;
        $this->deskripsi_pengalaman = $dokter->deskripsi_pengalaman;

        $this->existing_foto_profil = $dokter->foto_profil; // <-- Muat path foto lama

        $this->isEditMode = true;
        $this->isModalOpen = true;
    }

    public function delete($id)
    {
        try {
            $dokter = Dokter::findOrFail($id);

            // Hapus foto profil dari storage
            if ($dokter->foto_profil) {
                Storage::disk('public')->delete($dokter->foto_profil);
            }

            // Hapus user (dan dokter akan terhapus via cascade)
            User::findOrFail($dokter->user_id)->delete();

            session()->flash('message', 'Data Tenaga Medis berhasil dihapus.');
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menghapus data. Pastikan data ini tidak terkait dengan reservasi.');
        }
    }
}
