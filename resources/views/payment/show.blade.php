@extends('layouts.app') {{-- Menggunakan layout utama Anda --}}

@section('content')
<div class.container py-5">
  <div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
      <div class="card shadow-lg text-center payment-card">
        <div class="card-body p-4 p-md-5">
          <a class="navbar-brand fw-bold fs-3 text-primary mb-3 d-block" href="{{ route('home') }}">MedConnect</a>
          <h3 class="mb-2">Konfirmasi Pembayaran</h3>
                    <p class="text-muted">Untuk Reservasi ID: <strong>{{ $reservasi->id }}</strong></p>

                    {{-- QR Code Dibuat Dinamis dengan ID Reservasi dan Harga --}}
          <img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=BAYAR-{{ $reservasi->id }}-{{ $harga }}" alt="Contoh QR Code Pembayaran" class="img-fluid my-4 qris-image">

          <div class="payment-details">
            <h4 class="fw-bold">Total Tagihan Registrasi</h4>

                        {{-- HARGA DINAMIS DARI CONTROLLER --}}
            <h2 class="display-6 text-primary fw-bolder">Rp {{ number_format($harga, 0, ',', '.') }}</h2>

                        <p class="small text-muted mt-3">
                            Anda akan mendapatkan <strong>Nomor Antrian {{ $reservasi->nomor_antrian }}</strong>
                            setelah pembayaran dikonfirmasi.
                        </p>
          </div>

                    {{-- Tombol "Saya Sudah Membayar" sekarang adalah FORM --}}
          <form action="{{ route('payment.confirm', $reservasi->id) }}" method="POST" class="d-grid mt-4">
                        @csrf
                        <button type="submit" class="btn btn-success" id="konfirmasiBtn">Saya Sudah Membayar</button>
                    </form>

          {{-- Pesan sukses (dihapus dari sini, akan pindah ke halaman 'booking.success') --}}
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
