@extends('layouts.admin')

@section('content')

    {{-- Panggil komponen Livewire untuk manajemen pasien --}}
    @livewire('admin.pasien-manager')

@endsection
