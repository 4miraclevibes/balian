@extends('layouts.dashboard.main')

@section('content')
<div class="card container p-3">
    <h3 class="mb-3 text-center">Edit Produk</h3>
    <form action="{{ route('dashboard.product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="name" class="form-label">Nama</label>
                <input type="text" class="form-control form-control-sm" id="name" name="name" value="{{ $product->name }}" required>
            </div>
            <div class="col-md-6">
                <label for="slug" class="form-label">Slug</label>
                <input type="text" class="form-control form-control-sm" id="slug" name="slug" value="{{ $product->slug }}" required>
            </div>
            <div class="col-md-6 mt-3">
                <label for="category_id" class="form-label">Kategori</label>
                <select class="form-select form-select-sm" id="category_id" name="category_id" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 mt-3">
                <label for="thumbnail" class="form-label">Thumbnail</label>
                <input type="file" class="form-control form-control-sm" id="thumbnail" name="thumbnail" accept="image/*">
            </div>
            <div class="col-md-6 mt-3">
                <label for="delivery_type" class="form-label">Tipe Pengiriman</label>
                <select class="form-select form-select-sm" id="delivery_type" name="delivery_type" required>
                    <option value="instant" {{ $product->delivery_type == 'instant' ? 'selected' : '' }}>Instant</option>
                    <option value="process" {{ $product->delivery_type == 'process' ? 'selected' : '' }}>Proses Dulu</option>
                </select>
            </div>
            @if($product->thumbnail)
            <div class="col-md-12 mt-3">
                <label class="form-label">Thumbnail Saat Ini:</label>
                <img src="{{ $product->thumbnail }}" alt="{{ $product->name }}" class="d-block" style="max-width: 200px; max-height: 200px;">
            </div>
            @endif
            <div class="col-md-12 mt-3">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea class="form-control form-control-sm" id="description" name="description" rows="3">{{ $product->description }}</textarea>
            </div>
        </div>
        <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
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
</script>
@endpush