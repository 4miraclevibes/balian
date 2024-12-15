@extends('layouts.dashboard.main')

@section('content')
<div class="card container p-3">
    <h3 class="mb-3 text-center">Tambah Varian Produk Baru</h3>
    <a href="{{ route('dashboard.product.variant.index', $product->id) }}" class="btn btn-secondary btn-sm">Kembali</a>
    <form action="{{ route('dashboard.product.variant.store', $product->id) }}" method="POST">
        @csrf
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="name" class="form-label">Nama Varian</label>
                <input type="text" class="form-control form-control-sm" id="name" name="name" required>
            </div>
            <div class="col-md-6" id="capital_price_container">
                <label for="price" class="form-label">Harga Modal</label>
                <input type="number" class="form-control form-control-sm" id="price" name="price">
            </div>
            <div id="sell_price_container" class="col-md-6">
                <label for="sell_price" class="form-label">Harga Jual</label>
                <input type="number" class="form-control form-control-sm" id="sell_price" name="sell_price">
            </div>
            <div class="form-check form-switch mt-3 mx-3">
                <input class="form-check-input" type="checkbox" role="switch" id="is_sayur" name="is_sayur" checked>
                <label class="form-check-label" for="is_sayur">Sayur</label>
            </div>
        </div>
        <button type="submit" class="btn btn-sm btn-primary">Tambah Varian</button>
        <a href="{{ route('dashboard.product.variant.index', $product->id) }}" class="btn btn-sm btn-secondary">Batal</a>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const isSayurCheckbox = document.getElementById('is_sayur');
        const sellPriceContainer = document.getElementById('sell_price_container');
        const capitalPriceContainer = document.getElementById('capital_price_container');
        // Function untuk mengatur visibility
        function toggleSellPrice() {
            sellPriceContainer.style.display = isSayurCheckbox.checked ? 'none' : 'block';
            capitalPriceContainer.style.display = isSayurCheckbox.checked ? 'block' : 'none';
        }

        // Jalankan saat pertama kali load
        toggleSellPrice();

        // Jalankan setiap kali checkbox berubah
        isSayurCheckbox.addEventListener('change', toggleSellPrice);
    });
</script>
@endpush