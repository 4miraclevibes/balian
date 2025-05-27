@extends('layouts.dashboard.main')

@section('content')
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card">
    <div class="card-header">
      <div class="d-flex justify-content-between">
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addBannerModal">Tambah Banner</button>
      </div>
    </div>
  </div>
  <div class="card mt-2">
    <h5 class="card-header">Tabel Banner</h5>
    <div class="table-responsive text-nowrap p-3">
      <table class="table" id="example">
        <thead>
          <tr class="text-nowrap table-dark">
            <th class="text-white">No</th>
            <th class="text-white">Gambar</th>
            <th class="text-white">Status</th>
            <th class="text-white">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($banners as $banner)
          <tr>
            <th scope="row">{{ $loop->iteration }}</th>
            <td>
              <img src="{{ $banner->image }}" alt="Banner" style="max-width: 150px;">
            </td>
            <td>
              <span class="badge bg-{{ $banner->is_active ? 'success' : 'danger' }}">
                {{ $banner->is_active ? 'Aktif' : 'Tidak Aktif' }}
              </span>
            </td>
            <td>
              <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editBannerModal{{ $banner->id }}">Edit</button>
              <form action="{{ route('dashboard.banner.destroy', $banner->id) }}" method="POST" style="display:inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus banner ini?')">Hapus</button>
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

<!-- Modal Tambah Banner -->
<div class="modal fade" id="addBannerModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Banner</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('dashboard.banner.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label for="image" class="form-label">Gambar Banner</label>
            <input type="file" class="form-control" id="image" name="files[]" accept="image/*" required>
          </div>
          <div class="mb-3">
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" checked>
              <label class="form-check-label" for="is_active">
                Status Aktif
              </label>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Edit Banner -->
@foreach($banners as $banner)
<div class="modal fade" id="editBannerModal{{ $banner->id }}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Banner</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('dashboard.banner.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="modal-body">
          <div class="mb-3">
            <label for="image" class="form-label">Gambar Banner</label>
            <input type="file" class="form-control" id="image" name="files[]" accept="image/*">
            <small class="text-muted">Biarkan kosong jika tidak ingin mengubah gambar</small>
            <div class="mt-2">
              <img src="{{ $banner->image }}" alt="Current Banner" style="max-width: 200px;">
            </div>
          </div>
          <div class="mb-3">
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" role="switch" id="is_active{{ $banner->id }}" name="is_active" {{ $banner->is_active ? 'checked' : '' }}>
              <label class="form-check-label" for="is_active{{ $banner->id }}">
                Status Aktif
              </label>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endforeach
@endsection
