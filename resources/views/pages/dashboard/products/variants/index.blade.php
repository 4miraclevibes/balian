@extends('layouts.dashboard.main')

@section('content')
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">Daftar Varian Produk {{ $product->name }}</h5>
      <a href="{{ route('dashboard.product.variant.create', $product->id) }}" class="btn btn-primary btn-sm">Tambah Varian</a>
      <a href="{{ route('dashboard.product.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
    </div>
  </div>
  <div class="card mt-2">
    <div class="table-responsive text-nowrap p-3">
      <table class="table" id="variantTable">
        <thead>
          <tr class="text-nowrap table-dark">
            <th class="text-white">No</th>
            <th class="text-white">Nama Varian</th>
            <th class="text-white">Harga</th>
            <th class="text-white">Harga Modal</th>
            <th class="text-white">Status</th>
            <th class="text-white">Stok</th>
            <th class="text-white">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($product->variants as $variant)
          <tr>
            <th scope="row">{{ $loop->iteration }}</th>
            <td>{{ $variant->name }}</td>
            <td>Rp {{ number_format($variant->price, 0, ',', '.') }}</td>
            <td>
              @if($variant->variantStocks->first() && $variant->variantStocks->first()->stockDetails->first())
                Rp {{ number_format($variant->variantStocks->first()->stockDetails->first()->capital_price, 0, ',', '.') }}
              @else
                -
              @endif
            </td>
            <td>
              @if($variant->is_visible)
                <span class="badge bg-success">Aktif</span>
              @else
                <span class="badge bg-danger">Tidak Aktif</span>
              @endif
            </td>
            <td>{{ $variant->getAvailableStockCount() }}</td>
            <td>
              <a href="{{ route('dashboard.product.variant.edit', $variant->id) }}" class="btn btn-warning btn-sm">Edit</a>
              <a href="{{ route('dashboard.product.variant.stock.index', $variant->id) }}" class="btn btn-info btn-sm">Stok</a>
              <form action="{{ route('dashboard.product.variant.destroy', $variant->id) }}" method="POST" style="display:inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus varian ini?')">Hapus</button>
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

@section('scripts')
<script>
  $(document).ready(function() {
    $('#variantTable').DataTable();
  });
</script>
@endsection