<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Faq;
use Livewire\WithPagination;

class FaqManager extends Component
{
    use WithPagination;

    public $faq_id, $pertanyaan, $jawaban, $is_aktif = true;
    public $search = '';
    public $isModalOpen = false;
    public $isEditMode = false;
    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'pertanyaan' => 'required|string|min:5',
        'jawaban' => 'required|string|min:10',
        'is_aktif' => 'boolean',
    ];

    public function render()
    {
        $faqs = Faq::where('pertanyaan', 'like', '%' . $this->search . '%')
                   ->orderBy('created_at', 'desc')
                   ->paginate(5);

        return view('livewire.admin.faq-manager', ['faqs' => $faqs]);
    }

    public function create()
    {
        $this->resetInputFields();
        $this->isModalOpen = true;
    }

    public function edit($id)
    {
        $faq = Faq::findOrFail($id);
        $this->faq_id = $id;
        $this->pertanyaan = $faq->pertanyaan;
        $this->jawaban = $faq->jawaban;
        $this->is_aktif = $faq->is_aktif;

        $this->isEditMode = true;
        $this->isModalOpen = true;
    }

    public function save()
    {
        $this->validate();

        Faq::updateOrCreate(
            ['id' => $this->faq_id],
            [
                'pertanyaan' => $this->pertanyaan,
                'jawaban' => $this->jawaban,
                'is_aktif' => $this->is_aktif,
            ]
        );

        session()->flash('message', $this->isEditMode ? 'FAQ diperbarui.' : 'FAQ ditambahkan.');
        $this->closeModal();
    }

    public function delete($id)
    {
        Faq::find($id)->delete();
        session()->flash('message', 'FAQ dihapus.');
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->resetInputFields();
    }

    private function resetInputFields()
    {
        $this->faq_id = null;
        $this->pertanyaan = '';
        $this->jawaban = '';
        $this->is_aktif = true;
        $this->isEditMode = false;
    }
}
