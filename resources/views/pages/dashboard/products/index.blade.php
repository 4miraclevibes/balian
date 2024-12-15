@extends('layouts.dashboard.main')

@section('content')
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card">
    <div class="card-header">
      <a href="{{ route('dashboard.product.create') }}" class="btn btn-primary btn-sm">Tambah Produk</a>
    </div>
  </div>
  <div class="card mt-2">
    <h5 class="card-header">Tabel Produk</h5>
    <div class="table-responsive text-nowrap p-3">
      <table class="table" id="example">
        <thead>
          <tr class="text-nowrap table-dark">
            <th class="text-white">No</th>
            <th class="text-white">Nama</th>
            <th class="text-white">Kategori</th>
            <th class="text-white">Stok</th>
            <th class="text-white">Varian</th>
            <th class="text-white">Thumbnail</th>
            <th class="text-white">Tipe Pengiriman</th>
            <th class="text-white">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($products as $product)
          <tr>
            <th scope="row">{{ $loop->iteration }}</th>
            <td>{{ $product->name }}</td>
            <td>{{ $product->category->name }}</td>
            <td>
              @php
                  $totalStock = $product->variants->sum(function ($variant) {
                      return $variant->getTotalAvailableStockAttribute();
                  });
              @endphp
              {{ $totalStock }}
            </td>
            <td>
              {{ $product->variants->count() }}
            </td>
            <td>
              @if($product->thumbnail)
                <img src="{{ $product->thumbnail }}" alt="{{ $product->name }}" style="max-width: 50px; max-height: 50px;">
              @else
                Tidak ada gambar
              @endif
            </td>
            <td>
              @if($product->delivery_type == 'instant')
                <span class="badge bg-success">
                  <i class="bx bx-package me-1"></i>
                  Instant
                </span>
              @else
                <span class="badge bg-warning">
                  <i class="bx bx-time-five me-1"></i>
                  Proses Dulu
                </span>
              @endif
            </td>
            <td>
              <a href="{{ route('dashboard.product.edit', $product->id) }}" class="btn btn-warning btn-sm">Edit</a>
              <a href="{{ route('dashboard.product.image.index', $product->id) }}" class="btn btn-info btn-sm">Gambar</a>
              <a href="{{ route('dashboard.product.variant.index', $product->id) }}" class="btn btn-primary btn-sm">Varian</a>
              <form action="{{ route('dashboard.product.destroy', $product->id) }}" method="POST" style="display:inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">Hapus</button>
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