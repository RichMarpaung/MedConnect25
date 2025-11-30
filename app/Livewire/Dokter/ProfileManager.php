<?php

namespace App\Livewire\Dokter;

use Livewire\Component;
use App\Models\User;
use App\Models\Dokter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

class ProfileManager extends Component
{
    use WithFileUploads;

    // Properti Model
    public User $user;
    public Dokter $dokter;

    // Properti Form User
    public $name;
    public $email;
    public $nomor_telepon;

    // Properti Form Dokter
    public $deskripsi_pengalaman;

    // Properti Upload Foto
    public $foto_profil; // Untuk file upload baru
    public $existing_foto_profil; // Untuk preview foto lama

    // Properti Password
    public $password;
    public $password_confirmation;

    public function mount()
    {
        $this->user = Auth::user();
        $this->dokter = Auth::user()->dokterProfile; // Sesuai Model User Anda

        // Isi form dari data yang ada
        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->nomor_telepon = $this->user->nomor_telepon;

        $this->deskripsi_pengalaman = $this->dokter->deskripsi_pengalaman;
        $this->existing_foto_profil = $this->dokter->foto_profil;
    }

    public function saveProfile()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->user->id,
            'nomor_telepon' => 'nullable|string',
            'deskripsi_pengalaman' => 'nullable|string|max:1000',
            'foto_profil' => 'nullable|image|max:2048', // 2MB Max
        ]);

        // Update User
        $this->user->name = $this->name;
        $this->user->email = $this->email;
        $this->user->nomor_telepon = $this->nomor_telepon;
        $this->user->save();

        // Update Profil Dokter
        $dokterData = [
            'deskripsi_pengalaman' => $this->deskripsi_pengalaman,
        ];

        // Logika Upload Foto
        if ($this->foto_profil) {
            // Hapus foto lama jika ada
            if ($this->existing_foto_profil) {
                Storage::disk('public')->delete($this->existing_foto_profil);
            }
            // Simpan foto baru
            $path = $this->foto_profil->store('foto-profil', 'public');
            $dokterData['foto_profil'] = $path;

            // Update preview
            $this->existing_foto_profil = $path;
            $this->foto_profil = null; // Kosongkan file input
        }

        $this->dokter->update($dokterData);

        session()->flash('message', 'Profil berhasil diperbarui.');
    }

    public function savePassword()
    {
        $this->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $this->user->password = Hash::make($this->password);
        $this->user->save();

        $this->reset(['password', 'password_confirmation']);
        session()->flash('message_password', 'Password berhasil diubah.');
    }

    public function render()
    {
        return view('livewire.dokter.profile-manager');
    }
}
