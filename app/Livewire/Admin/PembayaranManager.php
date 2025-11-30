<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Reservation;
use Livewire\WithPagination;

class PembayaranManager extends Component
{
    use WithPagination;

    public $search = '';
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        // Ambil data reservasi dengan relasi pasien dan dokter
        $pembayarans = Reservation::with(['pasien', 'dokter.user'])
            ->where(function($query) {
                // Cari berdasarkan nama pasien atau ID reservasi
                $query->whereHas('pasien', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                })
                ->orWhere('id', 'like', '%' . $this->search . '%');
            })
            // Urutkan: Pending di atas, baru yang sudah lunas, lalu tanggal terbaru
            ->orderByRaw("FIELD(status, 'pending_payment', 'dijadwalkan', 'selesai', 'dibatalkan')")
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.admin.pembayaran-manager', [
            'pembayarans' => $pembayarans
        ]);
    }

    /**
     * Verifikasi Pembayaran Manual
     * (Mengubah status dari Pending -> Dijadwalkan)
     */
    public function verifikasi($id)
    {
        $reservasi = Reservation::findOrFail($id);

        if ($reservasi->status == 'pending_payment') {
            $reservasi->update(['status' => 'dijadwalkan']);
            session()->flash('message', 'Pembayaran berhasil diverifikasi. Status reservasi kini Dijadwalkan.');
        }
    }
}
