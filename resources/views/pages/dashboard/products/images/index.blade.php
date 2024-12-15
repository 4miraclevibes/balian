@extends('layouts.dashboard.main')

@section('content')
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card">
    <div class="card-header">
      <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addImageModal">
        Tambah Gambar Produk
      </button>
    </div>
  </div>
  <div class="card mt-2">
    <h5 class="card-header">Tabel Gambar Produk: {{ $product->name }}</h5>
    <div class="table-responsive text-nowrap p-3">
      <table class="table" id="example">
        <thead>
          <tr class="text-nowrap table-dark">
            <th class="text-white">No</th>
            <th class="text-white">Gambar</th>
            <th class="text-white">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($product->images as $image)
          <tr>
            <th scope="row">{{ $loop->iteration }}</th>
            <td>
              <img src="{{ $image->image }}" alt="Gambar Produk" style="max-width: 100px; max-height: 100px;">
            </td>
            <td>
              <form action="{{ route('dashboard.product.image.destroy', $image->id) }}" method="POST" style="display:inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus gambar ini?')">Hapus</button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
<!-- / Content -->

<!-- Modal -->
<div class="modal fade" id="addImageModal" tabindex="-1" aria-labelledby="addImageModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addImageModalLabel">Tambah Gambar Produk</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('dashboard.product.image.store', $product->id) }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label for="image" class="form-label">URL Gambar</label>
            <input type="url" class="form-control" id="image" name="image" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
