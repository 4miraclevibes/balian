@extends('layouts.dashboard.main')

@section('content')
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card">
    <div class="card-header">
      <div class="d-flex justify-content-between">
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addDistrictModal">Tambah Kecamatan</button>
        <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addSubDistrictModal">Tambah Sub Kecamatan</button>
        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#updateFeeAllModal">Update Fee Semua</button>
      </div>
    </div>
  </div>
  <div class="card mt-2">
    <h5 class="card-header">Tabel Kecamatan</h5>
    <div class="table-responsive text-nowrap p-3">
      <table class="table" id="example">
        <thead>
          <tr class="text-nowrap table-dark">
            <th class="text-white">No</th>
            <th class="text-white">Nama</th>
            <th class="text-white">Sub Kecamatan</th>
            <th class="text-white">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($districts as $district)
          <tr>
            <th scope="row">{{ $loop->iteration }}</th>
            <td>{{ $district->name }}</td>
            <td>{{ $district->subdistricts->count() }}</td>
            <td>
              <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editDistrictModal{{ $district->id }}">Edit</button>
              <form action="{{ route('dashboard.district.destroy', $district->id) }}" method="POST" style="display:inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus kecamatan ini?')">Hapus</button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
  <div class="card mt-2">
    <h5 class="card-header">Tabel Sub Kecamatan</h5>
    <div class="table-responsive text-nowrap p-3">
      <table class="table" id="example1">
        <thead>
          <tr class="text-nowrap table-dark">
            <th class="text-white">No</th>
            <th class="text-white">Nama</th>
            <th class="text-white">Kecamatan</th>
            <th class="text-white">Fee</th>
            <th class="text-white">Status</th>
            <th class="text-white">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($subdistricts as $subdistrict)
          <tr>
            <th scope="row">{{ $loop->iteration }}</th>
            <td>{{ $subdistrict->name }}</td>
            <td>{{ $subdistrict->district->name }}</td>
            <td>Rp. {{ number_format($subdistrict->fee, 0, ',', '.') }}</td>
            <td>
              <span class="badge bg-label-{{ $subdistrict->status == 'active' ? 'success' : 'danger' }}">{{ $subdistrict->status }}</span>
            </td>
            <td>
              <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editSubDistrictModal{{ $subdistrict->id }}">Edit</button>
              <form action="{{ route('dashboard.subdistrict.destroy', $subdistrict->id) }}" method="POST" style="display:inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus sub kecamatan ini?')">Hapus</button>
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

<!-- Modal Tambah Kecamatan -->
<div class="modal fade" id="addDistrictModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Kecamatan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('dashboard.district.store') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label for="name" class="form-label">Nama Kecamatan</label>
            <input type="text" class="form-control" id="name" name="name" required>
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

<!-- Modal Tambah Sub Kecamatan -->
<div class="modal fade" id="addSubDistrictModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Sub Kecamatan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('dashboard.subdistrict.store') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label for="subdistrict_name" class="form-label">Nama Sub Kecamatan</label>
            <input type="text" class="form-control" id="subdistrict_name" name="name" required>
          </div>
          <div class="mb-3">
            <label for="district_id" class="form-label">Kecamatan</label>
            <select class="form-select" id="district_id" name="district_id" required>
              @foreach($districts as $district)
                <option value="{{ $district->id }}">{{ $district->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label for="fee" class="form-label">Biaya</label>
            <input type="number" class="form-control" id="fee" name="fee" required>
          </div>
          <div class="mb-3">
            <label for="description" class="form-label">Deskripsi</label>
            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
          </div>
          <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-select" id="status" name="status" required>
              <option value="active">Aktif</option>
              <option value="inactive">Tidak Aktif</option>
            </select>
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

<!-- Modal Update Fee Semua -->
<div class="modal fade" id="updateFeeAllModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Update Fee Semua Sub Kecamatan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('dashboard.district.updateFeeAll') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label for="new_fee" class="form-label">Fee Baru</label>
            <input type="number" class="form-control" id="new_fee" name="new_fee" required>
            <small class="form-text text-muted">Masukkan nilai fee baru yang akan diterapkan ke semua Sub Kecamatan.</small>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Edit Kecamatan -->
@foreach($districts as $district)
<div class="modal fade" id="editDistrictModal{{ $district->id }}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Kecamatan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('dashboard.district.update', $district->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-body">
          <div class="mb-3">
            <label for="name" class="form-label">Nama Kecamatan</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $district->name }}" required>
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

<!-- Modal Edit Sub Kecamatan -->
@foreach($subdistricts as $subdistrict)
<div class="modal fade" id="editSubDistrictModal{{ $subdistrict->id }}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Sub Kecamatan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('dashboard.subdistrict.update', $subdistrict->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-body">
          <div class="mb-3">
            <label for="subdistrict_name" class="form-label">Nama Sub Kecamatan</label>
            <input type="text" class="form-control" id="subdistrict_name" name="name" value="{{ $subdistrict->name }}" required>
          </div>
          <div class="mb-3">
            <label for="district_id" class="form-label">Kecamatan</label>
            <select class="form-select" id="district_id" name="district_id" required>
              @foreach($districts as $district)
                <option value="{{ $district->id }}" {{ $subdistrict->district_id == $district->id ? 'selected' : '' }}>{{ $district->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label for="fee" class="form-label">Biaya</label>
            <input type="number" class="form-control" id="fee" name="fee" value="{{ $subdistrict->fee }}" required>
          </div>
          <div class="mb-3">
            <label for="description" class="form-label">Deskripsi</label>
            <textarea class="form-control" id="description" name="description" rows="3">{{ $subdistrict->description }}</textarea>
          </div>
          <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-select" id="status" name="status" required>
              <option value="active" {{ $subdistrict->status == 'active' ? 'selected' : '' }}>Aktif</option>
              <option value="inactive" {{ $subdistrict->status == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
            </select>
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
