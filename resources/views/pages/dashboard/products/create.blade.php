@extends('layouts.dashboard.main')

@section('content')
<div class="card container p-3">
    <h3 class="mb-3 text-center">Buat Produk Baru</h3>
    <form action="{{ route('dashboard.product.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="name" class="form-label">Nama</label>
                <input type="text" class="form-control form-control-sm" id="name" name="name" required>
            </div>
            <div class="col-md-6 d-none">
                <label for="slug" class="form-label">Slug</label>
                <input type="text" class="form-control form-control-sm" id="slug" name="slug" required>
            </div>
            <div class="col-md-6">
                <label for="category_id" class="form-label">Kategori</label>
                <select class="form-select form-select-sm" id="category_id" name="category_id" required>
                    <option value="">Pilih Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-check form-switch col-md-6 mt-3 mx-3">
                <input class="form-check-input" type="checkbox" role="switch" id="is_sayur" name="is_sayur" checked>
                <label class="form-check-label" for="is_sayur">Sayur</label>
            </div>
            <div class="col-md-6 mt-3">
                <label for="price" class="form-label">Harga Modal</label>
                <input type="number" class="form-control form-control-sm" id="price" name="price" required>
            </div>
            <div class="col-md-6 mt-3">
                <label for="thumbnail" class="form-label">Thumbnail</label>
                <input type="file" class="form-control form-control-sm" id="thumbnail" name="thumbnail" accept="image/*">
            </div>
            <div id="sell_price_container" class="col-md-6 mt-3">
                <label for="sell_price" class="form-label">Harga Jual</label>
                <input type="number" class="form-control form-control-sm" id="sell_price" name="sell_price">
            </div>
            <div class="col-md-6 mt-3">
                <label for="delivery_type" class="form-label">Tipe Pengiriman</label>
                <select class="form-select form-select-sm" id="delivery_type" name="delivery_type" required>
                    <option value="instant">Instant</option>
                    <option value="process">Proses Dulu</option>
                </select>
            </div>
            <div class="col-md-12 mt-3">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea class="form-control form-control-sm" id="description" name="description" rows="3"></textarea>
            </div>
        </div>
        <button type="submit" class="btn btn-sm btn-primary">Buat</button>
        <a href="{{ route('dashboard.product.index') }}" class="btn btn-sm btn-secondary">Batal</a>
    </form>
</div>
@endsection

@push('scripts')
<script>
    // Script untuk menghasilkan slug otomatis dari nama
    document.getElementById('name').addEventListener('input', function() {
        let slug = this.value.toLowerCase().replace(/ /g, '-').replace(/[^\w-]+/g, '');
        document.getElementById('slug').value = slug;
    });

    document.addEventListener('DOMContentLoaded', function() {
        const isSayurCheckbox = document.getElementById('is_sayur');
        const sellPriceContainer = document.getElementById('sell_price_container');

        // Function untuk mengatur visibility
        function toggleSellPrice() {
            sellPriceContainer.style.display = isSayurCheckbox.checked ? 'none' : 'block';
        }

        // Jalankan saat pertama kali load
        toggleSellPrice();

        // Jalankan setiap kali checkbox berubah
        isSayurCheckbox.addEventListener('change', toggleSellPrice);
    });
</script>
@endpush