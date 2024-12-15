@extends('layouts.dashboard.main')

@section('content')
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card">
    <div class="card-header">
      <div class="d-flex justify-content-between">
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addAssetModal">Tambah Asset</button>
      </div>
    </div>
  </div>
  <div class="card mt-2">
    <h5 class="card-header">Tabel Asset</h5>
    <div class="table-responsive text-nowrap p-3">
      <table class="table" id="example">
        <thead>
          <tr class="text-nowrap table-dark">
            <th class="text-white">No</th>
            <th class="text-white">Tipe Logo</th>
            <th class="text-white">Gambar</th>
            <th class="text-white">Status</th>
            <th class="text-white">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($assets as $asset)
          <tr>
            <th scope="row">{{ $loop->iteration }}</th>
            <td>
              <span class="badge bg-primary">
                {{ str_replace('-', ' ', ucwords($asset->name)) }}
              </span>
            </td>
            <td>
              <img src="{{ $asset->image }}" alt="Asset" style="max-width: 150px;">
            </td>
            <td>
              <span class="badge bg-{{ $asset->is_active ? 'success' : 'danger' }}">
                {{ $asset->is_active ? 'Aktif' : 'Tidak Aktif' }}
              </span>
            </td>
            <td>
              <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editAssetModal{{ $asset->id }}">Edit</button>
              <form action="{{ route('dashboard.asset.destroy', $asset->id) }}" method="POST" style="display:inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus asset ini?')">Hapus</button>
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

<!-- Modal Tambah Asset -->
<div class="modal fade" id="addAssetModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Asset</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('dashboard.asset.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label for="name" class="form-label">Tipe Logo</label>
            <select class="form-select" id="name" name="name" required>
              <option value="" selected disabled>Pilih tipe logo</option>
              <option value="logo-mark">Logo Mark</option>
              <option value="combination-mark">Combination Mark</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="image" class="form-label">Gambar Asset</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
          </div>
        </div>
        <div class="mb-3 p-4">
          <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" checked>
            <label class="form-check-label" for="is_active">
              Status Aktif
            </label>
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

<!-- Modal Edit Asset -->
@foreach($assets as $asset)
<div class="modal fade" id="editAssetModal{{ $asset->id }}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Asset</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('dashboard.asset.update', $asset->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="modal-body">
          <div class="mb-3">
            <label for="name{{ $asset->id }}" class="form-label">Tipe Logo</label>
            <select class="form-select" id="name{{ $asset->id }}" name="name" required>
              <option value="logo-mark" {{ $asset->name === 'logo-mark' ? 'selected' : '' }}>Logo Mark</option>
              <option value="combination-mark" {{ $asset->name === 'combination-mark' ? 'selected' : '' }}>Combination Mark</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="image" class="form-label">Gambar Asset</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/*">
            <small class="text-muted">Biarkan kosong jika tidak ingin mengubah gambar</small>
            <div class="mt-2">
              <img src="{{ $asset->image }}" alt="Current Asset" style="max-width: 200px;">
            </div>
          </div>
          <div class="mb-3 p-4">
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" role="switch" id="is_active{{ $asset->id }}" name="is_active" {{ $asset->is_active ? 'checked' : '' }}>
              <label class="form-check-label" for="is_active{{ $asset->id }}">
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
