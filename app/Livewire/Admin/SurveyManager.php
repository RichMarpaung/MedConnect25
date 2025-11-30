<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Pertanyaan; // Pastikan Model 'Pertanyaan' sudah ada
use Livewire\WithPagination;

class SurveyManager extends Component
{
    use WithPagination;

    // Properti Form
    public $pertanyaan_id;
    public $kategori;
    public $pertanyaan_text; // Saya ubah nama variabel agar tidak bentrok dengan nama model
    public $is_aktif = true;

    // Properti UI
    public $isModalOpen = false;
    public $isEditMode = false;

    // List Kategori Statis (Bisa ditambah)
    public $kategoriList = [
        'A. Sikap & Pelayanan Dokter',
        'B. Kejelasan Informasi & Komunikasi',
        'C. Kompetensi Profesional',
        'D. Waktu & Efisiensi',
        'E. Keseluruhan Pelayanan',
    ];

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'kategori' => 'required|string',
        'pertanyaan_text' => 'required|string|min:5',
        'is_aktif' => 'required|boolean',
    ];

    public function render()
    {
        // Ambil data dan kelompokkan berdasarkan kategori
        // Kita ambil semua karena biasanya pertanyaan tidak sampai ratusan
        $pertanyaans = Pertanyaan::orderBy('kategori')->get()->groupBy('kategori');

        return view('livewire.admin.survey-manager', [
            'groupedPertanyaans' => $pertanyaans
        ]);
    }

    private function resetInputFields()
    {
        $this->pertanyaan_id = null;
        $this->kategori = $this->kategoriList[0];
        $this->pertanyaan_text = '';
        $this->is_aktif = true;
        $this->isModalOpen = false;
        $this->isEditMode = false;
    }

    public function create()
    {
        $this->resetInputFields();
        $this->isModalOpen = true;
    }

    public function edit($id)
    {
        $q = Pertanyaan::findOrFail($id);
        $this->pertanyaan_id = $id;
        $this->kategori = $q->kategori;
        $this->pertanyaan_text = $q->pertanyaan;
        $this->is_aktif = $q->is_aktif;

        $this->isEditMode = true;
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->resetInputFields();
    }

    public function save()
    {
        $this->validate();

        Pertanyaan::updateOrCreate(
            ['id' => $this->pertanyaan_id],
            [
                'kategori' => $this->kategori,
                'pertanyaan' => $this->pertanyaan_text,
                'is_aktif' => $this->is_aktif,
                'tipe' => 'rating_1_5' // Default tipe
            ]
        );

        session()->flash('message', $this->isEditMode ? 'Pertanyaan berhasil diperbarui.' : 'Pertanyaan berhasil ditambahkan.');
        $this->closeModal();
    }

    public function delete($id)
    {
        // Cek apakah pertanyaan sudah pernah dijawab (relasi ke jawaban)
        $q = Pertanyaan::withCount('jawaban')->findOrFail($id);

        if($q->jawaban_count > 0) {
            session()->flash('error', 'Tidak bisa dihapus karena sudah ada data jawaban dari pasien. Silakan non-aktifkan saja.');
            return;
        }

        $q->delete();
        session()->flash('message', 'Pertanyaan berhasil dihapus.');
    }

    // Fungsi cepat untuk toggle status aktif/non-aktif
    public function toggleStatus($id)
    {
        $q = Pertanyaan::findOrFail($id);
        $q->is_aktif = !$q->is_aktif;
        $q->save();
    }
}
