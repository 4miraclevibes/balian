@extends('layouts.landing.main')

@section('style')
<style>
    .address-card, .order-summary {
        background-color: #f8f9fa;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 20px;
    }
    .address-card i {
        font-size: 1.2rem;
    }
    .address-card p {
        margin-left: 1.7rem; /* Sesuaikan dengan lebar ikon */
    }
    .order-summary {
        margin-bottom: 20px;
    }
    .product-item {
        background-color: #e8f5e9;
        border-radius: 10px;
        padding: 10px;
        height: 100%;
    }
    .product-image {
        width: 100%;
        height: auto;
        object-fit: cover;
        border-radius: 5px;
    }
    .btn-pay {
        background-color: #4caf50;
        color: white;
        border: none;
        border-radius: 25px;
        padding: 10px;
        width: 100%;
        font-weight: bold;
    }
</style>
@endsection

@section('content')
<div class="container mt-3">
    <div class="d-flex align-items-center mb-3">
        <a href="#" class="text-decoration-none text-dark">
            <i class="bi bi-chevron-left fs-4"></i>
        </a>
        <h5 class="mb-0 ms-2">Checkout</h5>
    </div>

    <div class="address-card">
        <div class="d-flex justify-content-between align-items-start mb-2">
            <div class="d-flex align-items-center">
                <i class="bi bi-geo-alt-fill text-success me-2"></i>
                <span class="fw-bold">Alamat Pengiriman</span>
            </div>
            <a href="#" class="text-success text-decoration-none">Ganti Alamat</a>
        </div>
        <p class="mb-1"><strong>Rumah: Dika Alkadri</strong></p>
        <p class="mb-0 small">Komplek Lubuk Gading II, Blok O no.10, RT.3 RW.9,
        Kel. Batang Kabung, Koto Tangah, Kota Padang,
        Sumatera Barat, ID 25171</p>
    </div>

    <div class="order-summary mb-3">
        <div class="d-flex align-items-center mb-2">
            <i class="bi bi-receipt text-success me-2"></i>
            <h6 class="mb-0">Rincian Pesanan</h6>
        </div>
        <div class="row">
            @php
            $products = [
                ['name' => 'Bayam', 'price' => 16000, 'weight' => '1000g'],
                ['name' => 'Kangkung', 'price' => 8000, 'weight' => '500g'],
                ['name' => 'Brokoli', 'price' => 8000, 'weight' => '500g'],
                ['name' => 'Jamur', 'price' => 8000, 'weight' => '500g'],
            ];
            @endphp

            @foreach($products as $product)
            <div class="col-3">
                <div class="product-item text-center">
                    <img src="{{ asset('assets/landing/images/product.jpg') }}" alt="{{ $product['name'] }}" class="product-image mb-2">
                    <p class="mb-0 fw-bold">Rp{{ number_format($product['price'], 0, ',', '.') }}</p>
                    <p class="mb-0 text-muted small">{{ $product['weight'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="payment-summary">
        <h6 class="mb-3">Ringkasan Pembayaran</h6>
        <div class="d-flex justify-content-between mb-2">
            <span>Subtotal (4 Produk)</span>
            <span>Rp40.000</span>
        </div>
        <div class="d-flex justify-content-between mb-2">
            <span>Biaya Pengiriman</span>
            <span>Rp5.000</span>
        </div>
        <hr>
        <div class="d-flex justify-content-between fw-bold">
            <span>Total Pembayaran</span>
            <span>Rp45.000</span>
        </div>
    </div>

    <button class="btn-pay mt-3 mb-5">
        Bayar Sekarang <i class="bi bi-arrow-right"></i>
    </button>
</div>
@endsection