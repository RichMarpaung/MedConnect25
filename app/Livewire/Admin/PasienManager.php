<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class PasienManager extends Component
{
    use WithPagination;
    public $search = '';
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        // 1. Dapatkan ID role "user" (pasien)
        $userRoleId = DB::table('roles')->where('name', 'user')->value('id');

        // 2. Cari user dengan role tsb
        $pasiens = User::where('role_id', $userRoleId)
                    ->where(function($query) {
                        // Filter berdasarkan nama atau email
                        $query->where('name', 'like', '%'.$this->search.'%')
                              ->orWhere('email', 'like', '%'.$this->search.'%');
                    })
                    ->orderBy('created_at', 'desc')
                    ->paginate(10); // Tampilkan 10 per halaman

        return view('livewire.admin.pasien-manager', [
            'pasiens' => $pasiens
        ]);
    }

    /**
     * Hapus akun pasien
     */
    public function delete($id)
    {
        try {
            $pasien = User::findOrFail($id);

            // Validasi sederhana: pastikan bukan role lain
            if ($pasien->role_id != DB::table('roles')->where('name', 'user')->value('id')) {
                session()->flash('error', 'Tidak dapat menghapus akun ini.');
                return;
            }

            // Hapus user
            $pasien->delete();
            session()->flash('message', 'Akun pasien (ID: '.$id.') berhasil dihapus.');

        } catch (\Exception $e) {
            // Tangkap error jika pasien punya reservasi (foreign key constraint)
            session()->flash('error', 'Gagal menghapus. Pasien ini mungkin masih memiliki data reservasi.');
        }
    }
}
