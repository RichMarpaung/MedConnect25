<?php

namespace App\Livewire;

use App\Models\Dokter;
use App\Models\Jadwal;
use App\Models\Layanan;       // <-- Menggunakan Model 'Layanan'
use App\Models\Reservation;   // <-- Menggunakan Model 'Reservation'
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class BookingForm extends Component
{
    public $currentStep = 1;

    // Data dari database
    public $layanans;
    public $dokters = [];
    public $jadwalForDay;

    // Data pilihan user
    public $selectedLayananId;
    public $selectedDokterId;
    public $selectedTanggal;

    // Data untuk Step 3
    public $namaPasien;
    public $noTelp;

    // Info & Error
    public $kuotaTersisa;
    public $errorMessage;

    /**
     * Dijalankan saat komponen pertama kali dimuat.
     */
    public function mount()
    {
        $this->layanans = Layanan::where('is_aktif', true)->get();
        $this->dokters = new \Illuminate\Database\Eloquent\Collection();

        $this_user = Auth::user();
        $this->namaPasien = $this_user->name;
        $this->noTelp = $this_user->nomor_telepon;
    }

    /**
     * (Hook) Dijalankan OTOMATIS setiap kali $selectedLayananId berubah.
     */
    public function updatedSelectedLayananId($layananId)
    {
        $this->dokters = Dokter::with(['user', 'jadwal'])
            ->where('layanan_id', $layananId)
            ->get();
        $this->reset(['selectedDokterId', 'selectedTanggal', 'jadwalForDay', 'errorMessage', 'kuotaTersisa']);
    }

    /**
     * (Hook) Dijalankan OTOMATIS setiap kali $selectedDokterId berubah.
     */
    public function updatedSelectedDokterId($dokterId)
    {
        $this->reset(['selectedTanggal', 'jadwalForDay', 'errorMessage', 'kuotaTersisa']);
    }

    /**
     * (Hook) Dijalankan OTOMATIS setiap kali $selectedTanggal (tanggal) berubah.
     */
    public function updatedSelectedTanggal($tanggal)
    {
        $this->reset(['jadwalForDay', 'errorMessage', 'kuotaTersisa']);
        if (!$tanggal) return;

        // ===================================
        // ### PERBAIKAN 1: VALIDASI TANGGAL ###
        // ===================================
        // 1. Validasi tanggal (minimal H+0 / hari ini)
        if (Carbon::parse($tanggal)->isBefore(Carbon::today())) {
            $this->errorMessage = 'Tanggal tidak boleh kurang dari hari ini.';
            return;
        }

        // 2. Ubah tanggal menjadi nama hari
        $dayName = Carbon::parse($tanggal)->locale('id')->dayName;

        // 3. Cari jadwal dokter di hari tersebut
        $this->jadwalForDay = Jadwal::where('dokter_id', $this->selectedDokterId)
                                  ->where('hari', $dayName)
                                  ->first();

        // 4. Jika tidak ada jadwal
        if (!$this->jadwalForDay) {
            $this->errorMessage = "Dokter ini tidak praktek pada hari $dayName.";
        } else {

            // ===================================
            // ### PERBAIKAN 2: VALIDASI JAM ###
            // ===================================
            // 5. Jika booking untuk HARI INI, cek jam praktek
            if (Carbon::parse($tanggal)->isToday()) {
                // Ambil jam selesai praktek, misal: '17:00:00'
                $jamSelesai = $this->jadwalForDay->jam_selesai;

                // Cek jika jam sekarang SUDAH MELEWATI jam selesai praktek
                if (Carbon::now()->isAfter(Carbon::parse($jamSelesai))) {
                    $this->errorMessage = "Maaf, jam praktek dokter untuk hari ini telah berakhir.";
                    $this->reset(['jadwalForDay']); // Hapus jadwal agar tidak bisa lanjut
                    return;
                }
            }

            // 6. Cek sisa kuota (logika lama, dipindah ke bawah)
            $reservasiCount = Reservation::where('dokter_id', $this->selectedDokterId)
                                      ->where('tanggal_reservasi', $tanggal)
                                      ->where('status', 'dijadwalkan')
                                      ->count();

            $this->kuotaTersisa = $this->jadwalForDay->kuota_pasien - $reservasiCount;

            if ($this->kuotaTersisa <= 0) {
                $this->errorMessage = "Maaf, kuota untuk tanggal {$tanggal} sudah penuh.";
            }
        }
    }

    /**
     * Navigasi ke langkah berikutnya
     */
    public function nextStep()
    {
        if ($this->currentStep == 1) {
            $this->validate(['selectedLayananId' => 'required']);
        }
        if ($this->currentStep == 2) {
            $this->validate([
                'selectedDokterId' => 'required',
                'selectedTanggal' => 'required',
                'jadwalForDay' => 'required',
                'kuotaTersisa' => 'numeric|min:1'
            ], [
                'jadwalForDay.required' => 'Jadwal dokter tidak ditemukan atau jam praktek sudah berakhir.',
                'kuotaTersisa.min' => 'Kuota untuk tanggal ini sudah habis.'
            ]);
        }
        if ($this->currentStep < 3) $this->currentStep++;
    }

    /**
     * Navigasi ke langkah sebelumnya
     */
    public function prevStep()
    {
        if ($this->currentStep > 1) $this->currentStep--;
    }

    /**
     * Aksi submit booking terakhir
     */
    public function submitBooking()
    {
        $this->validate([
            'namaPasien' => 'required|string',
            'noTelp' => 'required|string',
        ]);

        // Cek kuota sekali lagi
        $reservasiCount = Reservation::where('dokter_id', $this->selectedDokterId)
                                  ->where('tanggal_reservasi', $this->selectedTanggal)
                                  ->where('status', 'dijadwalkan')
                                  ->count();

        if ($reservasiCount >= $this->jadwalForDay->kuota_pasien) {
            $this->addError('kuota', 'Maaf, kuota sudah habis selagi Anda mengisi form.');
            return;
        }

        // Dapatkan nomor antrian
        $nomorAntrian = Reservation::where('dokter_id', $this->selectedDokterId)
                                ->where('tanggal_reservasi', $this->selectedTanggal)
                                ->whereIn('status', ['dijadwalkan', 'pending_payment'])
                                ->count() + 1;

        // Buat Reservasi
        $reservasi = Reservation::create([
            'pasien_id' => Auth::id(),
            'dokter_id' => $this->selectedDokterId,
            'jadwal_id' => $this->jadwalForDay->id,
            'tanggal_reservasi' => $this->selectedTanggal,
            'nomor_antrian' => $nomorAntrian,
            'status' => 'pending_payment',
        ]);

        // Arahkan ke halaman pembayaran
        return redirect()->route('payment.show', $reservasi->id);
    }

    /**
     * Render tampilan (file blade)
     */
    public function render()
    {
        return view('livewire.booking-form');
    }
}
