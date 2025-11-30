<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Janji Temu - MedConnect</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="text-center mb-5">
                <a href="index.html" class="text-decoration-none d-inline-block mb-3"><i class="fas fa-arrow-left me-2"></i>Kembali ke Beranda</a>
                <h2>Buat Janji Temu</h2>
                <p class="text-muted">Ikuti langkah-langkah di bawah ini untuk memesan jadwal Anda.</p>
            </div>

            <div class="card shadow-lg booking-card">
                <div class="card-body p-4 p-md-5">
                    <div class="progress-bar-container mb-5">
                        <div class="progress-bar-step active" data-step="1">
                            <div class="step-icon"><i class="fas fa-notes-medical"></i></div>
                            <p>Layanan</p>
                        </div>
                        <div class="progress-bar-line"></div>
                        <div class="progress-bar-step" data-step="2">
                            <div class="step-icon"><i class="fas fa-calendar-alt"></i></div>
                            <p>Jadwal</p>
                        </div>
                        <div class="progress-bar-line"></div>
                        <div class="progress-bar-step" data-step="3">
                            <div class="step-icon"><i class="fas fa-user"></i></div>
                            <p>Data Diri</p>
                        </div>
                    </div>

                    <form id="bookingForm" novalidate>
                        <div class="form-step active">
                            <h4 class="text-center mb-4">Langkah 1: Pilih Layanan</h4>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="selection-card" data-value="Pemeriksaan Umum">
                                        <i class="fas fa-stethoscope fa-2x"></i>
                                        <span>Pemeriksaan Umum</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="selection-card" data-value="Kesehatan Gigi">
                                        <i class="fas fa-tooth fa-2x"></i>
                                        <span>Kesehatan Gigi</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="selection-card" data-value="Laboratorium">
                                        <i class="fas fa-vial fa-2x"></i>
                                        <span>Laboratorium</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="selection-card" data-value="Konsultasi Spesialis">
                                        <i class="fas fa-user-md fa-2x"></i>
                                        <span>Konsultasi Spesialis</span>
                                    </div>
                                </div>
                            </div>
                            <div class="text-end mt-4">
                                <button type="button" class="btn btn-primary btn-next">Lanjut <i class="fas fa-arrow-right ms-2"></i></button>
                            </div>
                        </div>

                        <div class="form-step">
                            <h4 class="text-center mb-4">Langkah 2: Pilih Jadwal & Dokter</h4>
                            <div class="mb-4">
                                <label class="form-label">Pilih Dokter</label>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="selection-card" data-value="Dr. Budi Santoso">
                                            <i class="fas fa-user-doctor fa-2x"></i>
                                            <span>Dr. Budi Santoso</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="selection-card" data-value="Dr. Anisa Putri">
                                            <i class="fas fa-user-doctor fa-2x"></i>
                                            <span>Dr. Anisa Putri</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="tanggalKunjungan" class="form-label">Tanggal Kunjungan</label>
                                    <input type="date" class="form-control" id="tanggalKunjungan" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="jamKunjungan" class="form-label">Jam Kunjungan</label>
                                    <input type="time" class="form-control" id="jamKunjungan" required>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mt-4">
                                <button type="button" class="btn btn-outline-secondary btn-prev"><i class="fas fa-arrow-left me-2"></i> Kembali</button>
                                <button type="button" class="btn btn-primary btn-next">Lanjut <i class="fas fa-arrow-right ms-2"></i></button>
                            </div>
                        </div>

                        <div class="form-step">
                            <h4 class="text-center mb-4">Langkah 3: Lengkapi Data Diri</h4>
                             <div class="mb-3">
                                <label for="namaPasien" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" id="namaPasien" placeholder="Masukkan nama lengkap Anda" required>
                            </div>
                             <div class="mb-3">
                                <label for="noTelp" class="form-label">No. Telepon/WhatsApp</label>
                                <input type="tel" class="form-control" id="noTelp" placeholder="Contoh: 08123456789" required>
                            </div>
                            <div class="d-flex justify-content-between mt-4">
                                <button type="button" class="btn btn-outline-secondary btn-prev"><i class="fas fa-arrow-left me-2"></i> Kembali</button>
                                <button type="submit" class="btn btn-primary">Konfirmasi & Lanjut Bayar <i class="fas fa-check ms-2"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const steps = document.querySelectorAll('.form-step');
        const nextBtns = document.querySelectorAll('.btn-next');
        const prevBtns = document.querySelectorAll('.btn-prev');
        const form = document.getElementById('bookingForm');
        const progressSteps = document.querySelectorAll('.progress-bar-step');

        let currentStep = 0;

        function updateSteps() {
            steps.forEach((step, index) => {
                step.classList.toggle('active', index === currentStep);
            });
            progressSteps.forEach((step, index) => {
                if (index < currentStep + 1) {
                    step.classList.add('active');
                } else {
                    step.classList.remove('active');
                }
            });
        }

        nextBtns.forEach(button => {
            button.addEventListener('click', () => {
                if (currentStep < steps.length - 1) {
                    currentStep++;
                    updateSteps();
                }
            });
        });

        prevBtns.forEach(button => {
            button.addEventListener('click', () => {
                if (currentStep > 0) {
                    currentStep--;
                    updateSteps();
                }
            });
        });

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            // Lakukan validasi akhir di sini jika perlu
            alert('Data Terkirim! Mengarahkan ke halaman pembayaran...');
            window.location.href = 'pembayaran.html';
        });

        // Handle selection cards
        const selectionCards = document.querySelectorAll('.selection-card');
        selectionCards.forEach(card => {
            card.addEventListener('click', () => {
                // Remove active class from sibling cards in the same parent row
                const parentRow = card.closest('.row');
                parentRow.querySelectorAll('.selection-card').forEach(sibling => {
                    sibling.classList.remove('active');
                });
                card.classList.add('active');
            });
        });

        updateSteps();
    });
</script>

</body>
</html>
