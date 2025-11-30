@extends('layouts.dokter')

@section('content')
    <h1 class="h3 mb-4">Pengaturan Profil</h1>

    {{-- Panggil komponen Livewire untuk form profil --}}
    @livewire('dokter.profile-manager')
@endsection
