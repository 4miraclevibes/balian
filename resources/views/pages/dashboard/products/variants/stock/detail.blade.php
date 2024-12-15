@extends('layouts.dashboard.main')

@section('content')
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">Detail Stok Produk {{ $variantStock->productVariant->name }}</h5>
      <a href="{{ route('dashboard.product.variant.stock.index', $variantStock->productVariant->id) }}" class="btn btn-secondary btn-sm">Kembali</a>
    </div>
  </div>
  <div class="card mt-2">
    <div class="table-responsive text-nowrap p-3">
      <table class="table" id="stockTable">
        <thead>
          <tr class="text-nowrap table-dark">
            <th class="text-white">No</th>
            <th class="text-white">Harga Modal</th>
            <th class="text-white">Harga Jual</th>
            <th class="text-white">Status</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($variantStock->stockDetails as $stockDetail)
          <tr>
            <th scope="row">{{ $loop->iteration }}</th>
            <td>{{ $stockDetail->capital_price }}</td>
            <td>{{ $stockDetail->price }}</td>
            <td>{{ $stockDetail->status }}</td>
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
    $('#stockTable').DataTable();
  });
</script>
@endsection