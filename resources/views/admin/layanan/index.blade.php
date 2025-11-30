@extends('layouts.admin')

@section('content')

    {{-- Cukup panggil komponen Livewire --}}
    @livewire('admin.layanan-manager')

@endsection

{{-- HAPUS @push('scripts') ... @endpush DARI SINI --}}
