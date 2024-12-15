@extends('layouts.landing.main')

@section('style')
<style>
    .breadcrumb {
        font-size: 0.8rem;
    }
    .main-image-container {
        width: 100%;
        height: 400px; /* Tinggi tetap */
        display: flex;
        justify-content: center;
        align-items: center;
        overflow: hidden;
        border-radius: 10px;
    }
    .main-image {
        width: 100%;
        height: 100%;
        object-fit: cover; /* Menggunakan cover untuk mengisi container */
    }
    .thumbnail-images {
        display: flex;
        overflow-x: auto;
        gap: 10px;
        padding: 10px 0;
    }
    .thumbnail {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 5px;
        cursor: pointer;
    }
    .thumbnail.active {
        border: 2px solid #4CAF50;
    }
    .product-title {
        font-size: 1.2rem;
        font-weight: bold;
    }
    .product-price {
        font-size: 1.1rem;
        color: #4CAF50;
        font-weight: bold;
    }
    .btn-add-to-cart {
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 5px;
        padding: 10px 20px;
        width: 100%;
    }
    .variant-options {
        display: flex;
        gap: 10px;
        margin-bottom: 15px;
    }
    .variant-option {
        padding: 8px 15px;
        border: 1px solid #ddd;
        border-radius: 20px;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .variant-option.active {
        background-color: #4CAF50;
        color: white;
        border-color: #4CAF50;
    }
</style>
@endsection

@section('content')
<div class="container mt-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none text-success fw-bold">Back to Home</a></li>
            <li class="breadcrumb-item active fw-bold" aria-current="page">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="product-images mb-3">
        <div class="main-image-container">
            <img src="{{ $product->thumbnail }}" alt="Product" class="main-image" id="mainImage">
        </div>
        <div class="thumbnail-images">
            @foreach ($product->images as $image)
                <img src="{{ $image->image }}" 
                     alt="Thumbnail {{ $image->id }}" 
                     class="thumbnail {{ $image->id == 1 ? 'active' : '' }}"
                     onclick="changeMainImage(this)">
            @endforeach
        </div>
    </div>

    <div class="product-info mb-3">
        <h1 class="product-title">{{ $product->name }}</h1>
        <p class="product-price">Rp <span id="selectedPrice">{{ number_format($product->variants->where('is_visible', 1)->first()->price, 0, ',', '.') }}</span></p>
        <p class="text-muted">{{ $product->description }}</p>
        <p class="text-muted">{{ $product->category->name }}</p>
        
        <h6 class="mb-2">Pilih Varian</h6>
        <div class="variant-options row text-center justify-content-start">
            @foreach($product->variants->where('is_visible', 1) as $variant)
                <div class="variant-option col-3 {{ $loop->first ? 'active' : '' }}" 
                     data-variant-id="{{ $variant->id }}" 
                     data-price="{{ $variant->price }}">
                    {{ $variant->name }} 
                </div>
            @endforeach
        </div>
    </div>
    <div class="empty box" style="height: 50px;"></div>
    <form action="{{ route('cart.store') }}" method="post">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <input type="hidden" name="variant_id" id="selectedVariant" value="{{ $product->variants->first()->id }}">
        <input type="number" style="display: none;" name="quantity" value="1">
        @auth
            @if(Auth::user()->role->name == 'driver')
                <button type="submit" class="btn-add-to-cart disabled" disabled>Add to Cart</button>
            @else
                <button type="submit" class="btn-add-to-cart">Add to Cart</button>
            @endif
        @else
            <button type="submit" class="btn-add-to-cart disabled" disabled>Add to Cart</button>
        @endauth
    </form>
</div>
<div class="empty box" style="height: 50px;"></div>
@endsection

@section('script')
<script>
function changeMainImage(thumbnail) {
    // Ubah gambar utama
    document.getElementById('mainImage').src = thumbnail.src;

    // Hapus kelas 'active' dari semua thumbnail
    document.querySelectorAll('.thumbnail').forEach(thumb => {
        thumb.classList.remove('active');
    });

    // Tambahkan kelas 'active' ke thumbnail yang diklik
    thumbnail.classList.add('active');
}

document.addEventListener('DOMContentLoaded', function() {
    const variantOptions = document.querySelectorAll('.variant-option');
    const selectedPriceElement = document.getElementById('selectedPrice');
    const selectedVariantInput = document.getElementById('selectedVariant');

    variantOptions.forEach(option => {
        option.addEventListener('click', function() {
            // Hapus kelas active dari semua opsi
            variantOptions.forEach(opt => opt.classList.remove('active'));
            // Tambahkan kelas active ke opsi yang dipilih
            this.classList.add('active');
            
            // Update harga yang ditampilkan
            const price = this.getAttribute('data-price');
            selectedPriceElement.textContent = new Intl.NumberFormat('id-ID').format(price);
            
            // Update variant_id yang akan dikirim ke server
            selectedVariantInput.value = this.getAttribute('data-variant-id');
        });
    });
});
</script>
@endsection