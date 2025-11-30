<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Dokter;
use App\Models\Jadwal;

class JadwalManager extends Component
{
    public Dokter $dokter; // Menerima data dokter dari view

    // Untuk form tambah baru
    public $hari;
    public $jam_mulai;
    public $jam_selesai;
    public $kuota_pasien = 10; // Default

    // Untuk menampilkan jadwal yang ada
    public $jadwals;

    protected $rules = [
        'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
        'jam_mulai' => 'required|date_format:H:i',
        'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
        'kuota_pasien' => 'required|integer|min:1',
    ];

    /**
     * Dijalankan saat komponen dimuat
     */
    public function mount(Dokter $dokter)
    {
        $this->dokter = $dokter;
        $this->loadJadwals();
    }

    /**
     * Muat ulang data jadwal
     */
    public function loadJadwals()
    {
        $this->jadwals = $this->dokter->jadwal()->orderBy('hari')->get();
    }

    /**
     * Reset form tambah
     */
    public function resetForm()
    {
        $this->reset(['hari', 'jam_mulai', 'jam_selesai', 'kuota_pasien']);
    }

    /**
     * Simpan jadwal baru
     */
    public function saveJadwal()
    {
        $this->validate();

        $this->dokter->jadwal()->create([
            'hari' => $this->hari,
            'jam_mulai' => $this->jam_mulai,
            'jam_selesai' => $this->jam_selesai,
            'kuota_pasien' => $this->kuota_pasien,
        ]);

        session()->flash('message', 'Jadwal baru berhasil ditambahkan.');
        $this->loadJadwals();
        $this->resetForm();
    }

    /**
     * Hapus jadwal
     */
    public function deleteJadwal($jadwalId)
    {
        try {
            Jadwal::findOrFail($jadwalId)->delete();
            session()->flash('message', 'Jadwal berhasil dihapus.');
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menghapus jadwal. Mungkin terkait dengan reservasi.');
        }

        $this->loadJadwals();
    }

    public function render()
    {
        return view('livewire.admin.jadwal-manager');
    }
}
