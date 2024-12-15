@extends('layouts.landing.main')

@section('content')
<div class="d-flex flex-column min-vh-50">
    <div class="bg-white">
        <div class="d-flex align-items-center">
            <a href="{{ route('home') }}" class="text-success bg-success bg-opacity-10 rounded-circle p-2 d-inline-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                <i class="bi bi-chevron-left"></i>
            </a>
            <p class="fs-2 m-auto mb-0">Keranjang Belanja</p>
        </div>
    </div>
    
    <div class="flex-grow-1 d-flex flex-column justify-content-center align-items-center p-4">
        <div class="mb-4 text-center">
            <img src="{{ asset('assets/landing/images/cartEmpty.png') }}" alt="Keranjang Kosong" class="img-fluid" style="max-width: 200px;">
        </div>
        <p class="fs-6 fw-semibold mb-1">Yah Keranjangnya Kosong</p>
        <p class="fs-7 text-muted mb-4">Yuk Belanja Sekarang</p>
        <a href="{{ route('home') }}" class="btn btn-success py-2 px-4 rounded-pill" style="font-size: 0.9rem;">
            Belanja Sekarang
        </a>
    </div>
</div>
@endsection