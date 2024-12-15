@extends('layouts.dashboard.main')

@section('content')
<div class="card container p-3">
    <h3 class="mb-3 text-center">Edit Varian Produk</h3>
    <a href="{{ route('dashboard.product.variant.index', $variant->product_id) }}" class="btn btn-sm btn-secondary w-25 mb-2">Kembali</a>
    <form action="{{ route('dashboard.product.variant.update', $variant->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="name" class="form-label">Nama Varian</label>
                <input type="text" class="form-control form-control-sm" id="name" name="name" value="{{ $variant->name }}" required>
            </div>
            <div class="col-md-6" id="capital_price_container">
                <label for="price" class="form-label">Harga Modal</label>
                <input type="number" class="form-control form-control-sm" id="price" name="price" value="{{ $variant->variantStocks->first()->stockDetails->first()->capital_price ?? 0 }}" required>
            </div>
            <div id="sell_price_container" class="col-md-6">
                <label for="sell_price" class="form-label">Harga Jual</label>
                <input type="number" class="form-control form-control-sm" id="sell_price" name="sell_price" value="{{ $variant->price }}">
            </div>
            <div class="form-check form-switch mt-3 mx-3">
                <input class="form-check-input" type="checkbox" role="switch" id="is_sayur" name="is_sayur" {{ $variant->is_sayur ? 'checked' : '' }}>
                <label class="form-check-label" for="is_sayur">Sayur</label>
            </div>
            <div class="col-md-6 mt-3">
                <label class="form-label">Status</label>
                <div class="d-flex">
                    <div class="form-check me-3">
                        <input class="form-check-input" type="radio" name="is_visible" id="is_visible_active" value="1" {{ $variant->is_visible ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_visible_active">
                            Aktif
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="is_visible" id="is_visible_inactive" value="0" {{ !$variant->is_visible ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_visible_inactive">
                            Tidak Aktif
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
        <a href="{{ route('dashboard.product.variant.index', $variant->product_id) }}" class="btn btn-sm btn-secondary">Batal</a>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const isSayurCheckbox = document.getElementById('is_sayur');
        const sellPriceContainer = document.getElementById('sell_price_container');
        const capitalPriceContainer = document.getElementById('capital_price_container');
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