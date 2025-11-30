<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Layanan;
use Illuminate\Support\Str;
use Livewire\WithPagination;
// Kita tidak perlu 'On' lagi
// use Livewire\Attributes\On;

class LayananManager extends Component
{
    use WithPagination;

    // Properti Form
    public $layanan_id;
    public $nama_layanan, $deskripsi, $slug, $icon, $is_aktif = true;

    // Properti UI
    public $search = '';
    public $isModalOpen = false;
    public $isEditMode = false;
    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'nama_layanan' => 'required|string|min:3|max:255',
        'deskripsi' => 'nullable|string',
        'icon' => 'nullable|string', // Kembali ke validasi string
        'is_aktif' => 'required|boolean',
    ];

    // HAPUS FUNGSI #[On('icon-changed')]

    public function render()
    {
        $layanans = Layanan::where('nama_layanan', 'like', '%'.$this->search.'%')
                           ->orderBy('id', 'desc')
                           ->paginate(10);

        return view('livewire.admin.layanan-manager', [
            'layanans' => $layanans
        ]);
    }

    private function resetInputFields()
    {
        $this->layanan_id = null;
        $this->nama_layanan = '';
        $this->deskripsi = '';
        $this->slug = '';
        $this->icon = '';
        $this->is_aktif = true;
        $this->isEditMode = false;
    }

    public function create()
    {
        $this->resetInputFields();
        $this->isModalOpen = true;
        // Hapus dispatch event
    }

    public function edit($id)
    {
        $layanan = Layanan::findOrFail($id);
        $this->layanan_id = $id;
        $this->nama_layanan = $layanan->nama_layanan;
        $this->deskripsi = $layanan->deskripsi;
        $this->slug = $layanan->slug;
        $this->icon = $layanan->icon;
        $this->is_aktif = $layanan->is_aktif;
        $this->isModalOpen = true;
        $this->isEditMode = true;
        // Hapus dispatch event
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->resetInputFields();
    }

    public function save()
    {
        $this->validate();
        $generatedSlug = Str::slug($this->nama_layanan);

        Layanan::updateOrCreate(
            ['id' => $this->layanan_id],
            [
                'nama_layanan' => $this->nama_layanan,
                'deskripsi' => $this->deskripsi,
                'slug' => $generatedSlug,
                'icon' => $this->icon, // Langsung ambil dari $this->icon
                'is_aktif' => $this->is_aktif,
            ]
        );

        session()->flash('message',
            $this->isEditMode ? 'Layanan berhasil diperbarui.' : 'Layanan baru berhasil ditambahkan.');

        $this->closeModal();
    }

    public function delete($id)
    {
        $layanan = Layanan::withCount('dokter')->findOrFail($id);
        if($layanan->dokter_count > 0) {
            session()->flash('error', 'Layanan ini tidak bisa dihapus karena sedang digunakan oleh '.$layanan->dokter_count.' dokter.');
            return;
        }
        $layanan->delete();
        session()->flash('message', 'Layanan berhasil dihapus.');
    }
}
