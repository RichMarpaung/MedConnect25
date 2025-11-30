@extends('layouts.dokter')

@section('content')
    <h1 class="h3 mb-0">Dashboard Dokter</h1>
    <p class="text-muted">Selamat Datang, {{ $user->name }}</p>

    <hr>

    {{-- Panggil komponen Livewire untuk daftar antrian --}}
    @livewire('dokter.antrian-manager')
@endsection
