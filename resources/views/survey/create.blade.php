@extends('layouts.app')
@section('content')
    @livewire('pasien.isi-survey', ['reservasi' => $reservasi])
@endsection
