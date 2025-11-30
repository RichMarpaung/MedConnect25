@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">

                {{-- ### PERUBAHAN DI CARD HEADER ### --}}
                <div class="card-header bg-white d-flex flex-wrap justify-content-between align-items-center p-4">
                    <div>
                        <h4 class="mb-0">Detail Rekam Medis</h4>
                        <p class="text-muted mb-0">Hasil pemeriksaan Anda</p>
                    </div>
                    {{-- Wrapper untuk tombol --}}
                    <div class="mt-2 mt-md-0">
                        {{-- TOMBOL BARU --}}
                        <a href="{{ route('medical-record.download', $reservasi->id) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-download me-2"></i>Unduh PDF
                        </a>
                        <a href="{{ route('profile.edit') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                </div>
                {{-- ### AKHIR PERUBAHAN ### --}}

                <div class="card-body p-4">

                    @if($rekamMedis)
                        {{-- ... (Sisa kode Anda untuk Info Kunjungan dan SOAP tetap sama) ... --}}
                        <h5 class="mb-3">Data Kunjungan</h5>
                        <ul class="list-group list-group-flush mb-4">
                           {{-- ... (list group item) ... --}}
                        </ul>

                        <h5 class="mt-4 mb-3">Hasil Pemeriksaan (SOAP)</h5>
                        <div class="mb-3">
                            <label class="form-label fw-bold">S (Subjektif - Keluhan Anda)</label>
                            <textarea class="form-control" rows="3" readonly>{{ $rekamMedis->subjektif ?? '-' }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">O (Objektif - Temuan Dokter)</label>
                            <textarea class="form-control" rows="3" readonly>{{ $rekamMedis->objektif ?? '-' }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">A (Assessment - Diagnosa)</label>
                            <textarea class="form-control" rows="2" readonly>{{ $rekamMedis->assessment ?? '-' }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">P (Plan - Rencana & Resep)</label>
                            <textarea class="form-control" rows="4" readonly>{{ $rekamMedis->plan ?? '-' }}</textarea>
                        </div>
                    @else
                        {{-- ... (Tampilan jika rekam medis belum diisi) ... --}}
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
