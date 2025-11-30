<?php

namespace App\Livewire\Pasien;

use Livewire\Component;
use App\Models\Reservation;
use App\Models\Pertanyaan;
use App\Models\UlasanDokter;
use App\Models\Jawaban;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class IsiSurvey extends Component
{
    public Reservation $reservasi;

    // Menyimpan jawaban user. Format: [ pertanyaan_id => nilai_skor ]
    public $answers = [];
    public $komentar_umum;

    public function mount(Reservation $reservasi)
    {
        $this->reservasi = $reservasi;

        // Validasi Keamanan:
        // 1. Pastikan user adalah pemilik reservasi
        if (Auth::id() !== $reservasi->pasien_id) {
            abort(403);
        }
        // 2. Pastikan reservasi sudah selesai
        if ($reservasi->status !== 'selesai') {
            return redirect()->route('home')->with('error', 'Survei hanya untuk kunjungan yang sudah selesai.');
        }
        // 3. Pastikan belum pernah diisi
        if ($reservasi->ulasan) {
            return redirect()->route('profile.edit')->with('error', 'Anda sudah mengisi survei untuk kunjungan ini.');
        }
    }

    public function submit()
    {
        // Ambil semua ID pertanyaan yang aktif
        $pertanyaanIds = Pertanyaan::where('is_aktif', true)->pluck('id')->toArray();

        // Validasi: Pastikan semua pertanyaan dijawab
        $rules = [];
        foreach ($pertanyaanIds as $id) {
            $rules["answers.$id"] = 'required|integer|min:1|max:5';
        }
        $this->validate($rules, [
            'answers.*.required' => 'Mohon jawab pertanyaan ini.',
        ]);

        DB::transaction(function () {
            // 1. Buat Header Ulasan
            $ulasan = UlasanDokter::create([
                'reservasi_id' => $this->reservasi->id,
                'pasien_id' => $this->reservasi->pasien_id,
                'dokter_id' => $this->reservasi->dokter_id,
                'komentar_umum' => $this->komentar_umum,
            ]);

            // 2. Simpan Detail Jawaban
            foreach ($this->answers as $pertanyaan_id => $skor) {
                Jawaban::create([
                    'ulasan_id' => $ulasan->id,
                    'pertanyaan_id' => $pertanyaan_id,
                    'jawaban_rating' => $skor,
                ]);
            }
        });

        return redirect()->route('profile.edit')->with('success', 'Terima kasih! Ulasan Anda telah dikirim.');
    }

    public function render()
    {
        // Ambil pertanyaan, dikelompokkan berdasarkan kategori
        $pertanyaans = Pertanyaan::where('is_aktif', true)
                        ->orderBy('id') // Atau orderBy('urutan') jika ada column urutan
                        ->get()
                        ->groupBy('kategori');

        return view('livewire.pasien.isi-survey', [
            'groupedPertanyaans' => $pertanyaans
        ]);
    }
}
