@extends('layouts.admin') {{-- HARUS extend layout admin baru Anda --}}

@section('content')

    {{-- Baris ini akan memanggil seluruh komponen (form + tabel) --}}
    @livewire('admin.tenaga-medis-manager')

@endsection
