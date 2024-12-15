@extends('layouts.dashboard.main')

@section('content')
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">Daftar Stok Produk {{ $variant->name }}</h5>
      <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#tambahStokModal">Tambah Stok</button>
      <a href="{{ route('dashboard.product.variant.index', $variant->product_id) }}" class="btn btn-secondary btn-sm">Kembali</a>
    </div>
  </div>
  <div class="card mt-2">
    <div class="table-responsive text-nowrap p-3">
      <table class="table" id="stockTable">
        <thead>
          <tr class="text-nowrap table-dark">
            <th class="text-white">No</th>
            <th class="text-white">Nama Produk</th>
            <th class="text-white">Stok Masuk</th>
            <th class="text-white">Stok Keluar</th>
            <th class="text-white">Sisa Stok</th>
            <th class="text-white">Uang Keluar</th>
            <th class="text-white">Uang Masuk</th>
            <th class="text-white">Modal / Item</th>
            <th class="text-white">Profit</th>
            <th class="text-white">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($variant->variantStocks as $stock)
          <tr>
            <th scope="row">{{ $loop->iteration }}</th>
            <td>{{ $variant->product->name }} - {{ $variant->name }}</td>
            <td>{{ $stock->stockDetails->count() }}</td>
            <td>{{ $stock->stockDetails->where('status', 'sold')->count() }}</td>
            <td>{{ $stock->stockDetails->where('status', 'ready')->count() }}</td>
            <td>
              Rp {{ number_format($stock->stockDetails->sum('capital_price'), 0, ',', '.') }}
            </td>
            <td>
              Rp {{ number_format($stock->stockDetails->where('status', 'sold')->sum('price'), 0, ',', '.') }}
            </td>
            <td>
              Rp {{ number_format($stock->stockDetails->first()->capital_price, 0, ',', '.') }}
            </td>
            <td>
              Rp {{ number_format($stock->stockDetails->where('status', 'sold')->sum('price') - $stock->stockDetails->sum('capital_price'), 0, ',', '.') }}
            </td>
            <td>
              <a href="{{ route('dashboard.product.variant.stock.detail', $stock->id) }}" class="btn btn-warning btn-sm">Detail</a>
              <form action="{{ route('dashboard.product.variant.stock.destroy', $stock->id) }}" method="POST" style="display:inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus stok ini?')">Hapus</button>
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

<!-- Modal Tambah Stok -->
<div class="modal fade" id="tambahStokModal" tabindex="-1" aria-labelledby="tambahStokModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tambahStokModalLabel">Tambah Stok</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('dashboard.product.variant.stock.store', $variant->id) }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label for="quantity" class="form-label">Jumlah Stok</label>
            <input type="number" class="form-control" id="quantity" name="quantity" required>
          </div>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="capital_price" class="form-label">Harga Modal</label>
            <input type="number" class="form-control" id="capital_price" name="capital_price" required>
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

@section('scripts')
<script>
  $(document).ready(function() {
    $('#stockTable').DataTable();
  });
</script>
@endsection