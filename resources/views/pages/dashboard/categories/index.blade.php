@extends('layouts.dashboard.main')

@section('content')
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card">
    <div class="card-header">
      <a href="{{ route('dashboard.category.create') }}" class="btn btn-primary btn-sm">Tambah Kategori</a>
    </div>
  </div>
  <div class="card mt-2">
    <h5 class="card-header">Tabel Kategori</h5>
    <div class="table-responsive text-nowrap p-3">
      <table class="table" id="example">
        <thead>
          <tr class="text-nowrap table-dark">
            <th class="text-white">No</th>
            <th class="text-white">Nama</th>
            <th class="text-white">Slug</th>
            <th class="text-white">Gambar</th>
            <th class="text-white">Banner</th>
            <th class="text-white">Jumlah Produk</th>
            <th class="text-white">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($categories as $category)
          <tr>
            <th scope="row">{{ $loop->iteration }}</th>
            <td>{{ $category->name }}</td>
            <td>{{ $category->slug }}</td>
            <td>
              @if($category->image)
                <img src="{{ $category->image }}" alt="{{ $category->name }}" style="max-width: 50px; max-height: 50px;">
              @else
                Tidak ada gambar
              @endif
            </td>
            <td>
              @if($category->banner)
                <img src="{{ $category->banner }}" alt="{{ $category->name }} banner" style="max-width: 50px; max-height: 50px;">
              @else
                Tidak ada banner
              @endif
            </td>
            <td>{{ $category->products->count() }}</td>
            <td>
              <a href="{{ route('dashboard.category.edit', $category->id) }}" class="btn btn-warning btn-sm">Edit</a>
              <form action="{{ route('dashboard.category.destroy', $category->id) }}" method="POST" style="display:inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">Hapus</button>
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
@endsection