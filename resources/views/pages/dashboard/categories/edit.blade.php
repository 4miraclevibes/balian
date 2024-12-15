@extends('layouts.dashboard.main')

@section('content')
<div class="card container p-3">
    <h3 class="mb-3 text-center">Edit Kategori</h3>
    <form action="{{ route('dashboard.category.update', $category->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="name" class="form-label">Nama</label>
                <input type="text" class="form-control form-control-sm" id="name" name="name" value="{{ $category->name }}" required>
            </div>
            <div class="col-md-6">
                <label for="slug" class="form-label">Slug</label>
                <input type="text" class="form-control form-control-sm" id="slug" name="slug" value="{{ $category->slug }}" required>
            </div>
            <div class="col-md-6 mt-3">
                <label for="image" class="form-label">Gambar Kategori</label>
                <input type="file" class="form-control form-control-sm" id="image" name="image" accept="image/*">
                @if($category->image)
                <div class="mt-2">
                    <label class="form-label">Gambar Saat Ini:</label>
                    <img src="{{ $category->image }}" alt="{{ $category->name }}" class="d-block" style="max-width: 200px; max-height: 200px;">
                </div>
                @endif
            </div>
            <div class="col-md-6 mt-3">
                <label for="banner" class="form-label">Banner Kategori</label>
                <input type="file" class="form-control form-control-sm" id="banner" name="banner" accept="image/*">
                @if($category->banner)
                <div class="mt-2">
                    <label class="form-label">Banner Saat Ini:</label>
                    <img src="{{ $category->banner }}" alt="{{ $category->name }} banner" class="d-block" style="max-width: 200px; max-height: 200px;">
                </div>
                @endif
            </div>
        </div>
        <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
        <a href="{{ route('dashboard.category.index') }}" class="btn btn-sm btn-secondary">Batal</a>
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