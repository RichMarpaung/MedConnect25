@extends('layouts.dokter')

@section('content')
    <h1 class="h3 mb-4">Riwayat Pasien</h1>

    {{-- Panggil komponen Livewire untuk daftar riwayat --}}
    @livewire('dokter.riwayat-pasien')
@endsection
