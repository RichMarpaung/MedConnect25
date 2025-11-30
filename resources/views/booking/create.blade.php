@extends('layouts.app') {{-- Asumsi Anda punya layout utama --}}

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                {{-- Panggil Komponen Livewire di sini --}}
                @livewire('booking-form')

            </div>
        </div>
    </div>
@endsection
