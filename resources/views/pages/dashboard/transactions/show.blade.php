@extends('layouts.dashboard.main')

@section('content')
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">Detail Transaksi</h5>
      <a href="{{ route('dashboard.transaction.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
    </div>
    <div class="card-body">
      <div class="row mb-3">
        <div class="col-md-6">
          <h6>Informasi Transaksi</h6>
          <p><strong>ID Transaksi:</strong> {{ $transaction->id }}</p>
          <p><strong>Tanggal:</strong> {{ $transaction->created_at->format('d M Y H:i') }}</p>
          <p><strong>Status:</strong> {{ ucfirst($transaction->status) }}</p>
          <p><strong>Total Harga:</strong> Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</p>
          <p><strong>Ongkos Kirim:</strong> Rp {{ number_format($transaction->shipping_price, 0, ',', '.') }}</p>
          <p><strong>Biaya Tambahan:</strong> Rp {{ number_format($transaction->additional_cost, 0, ',', '.') }}</p>
        </div>
        <div class="col-md-6">
          <h6>Informasi Pelanggan</h6>
          <p><strong>Nama:</strong> {{ $transaction->user->name }}</p>
          <p><strong>Email:</strong> {{ $transaction->user->email }}</p>
          <p><strong>Alamat:</strong> {{ $transaction->address ?? '***' }}</p>
          <!-- Tambahkan informasi pelanggan lainnya jika ada -->
        </div>
      </div>

      <div class="row mb-4">
        <div class="col-12">
          <h6>Catatan Pesanan</h6>
          <div class="card bg-light">
            <div class="card-body">
              <p class="mb-0">{{ $transaction->notes ?? 'Tidak ada catatan' }}</p>
            </div>
          </div>
        </div>
      </div>

      <div class="row mb-4">
        <div class="col-12">
          <h6>Update Biaya Tambahan</h6>
          <form action="{{ route('dashboard.transaction.updateAdditionalCost', $transaction->id) }}" method="POST" class="d-flex align-items-center">
            @csrf
            @method('PATCH')
            <div class="input-group" style="width: 300px;">
              <span class="input-group-text">Rp</span>
              <input type="number" class="form-control" name="additional_cost" value="{{ $transaction->additional_cost }}" min="0">
            </div>
            <button type="submit" class="btn btn-primary ms-2">Update Biaya</button>
          </form>
          <small class="text-muted mt-2 d-block">
            <i class="bi bi-info-circle"></i>
            Biaya tambahan akan ditambahkan ke total transaksi dan akan diinformasikan ke pelanggan.
          </small>
        </div>
      </div>

      <h6>Detail Produk</h6>
      <div class="table-responsive">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Produk</th>
              <th>Variant</th>
              <th>Harga</th>
              <th>Jumlah</th>
              <th>Harga Modal</th>
              <th>Subtotal</th>
            </tr>
          </thead>
          <tbody>
            @foreach($transaction->details as $detail)
            <tr>
              <td>{{ $detail->variant->product->name }}</td>
              <td>{{ $detail->variant->name }}</td>
              <td>Rp {{ number_format($detail->price, 0, ',', '.') }}</td>
              <td>{{ $detail->quantity }}</td>
              <td>Rp {{ number_format($detail->capital_price, 0, ',', '.') }}</td>
              <td>Rp {{ number_format($detail->price * $detail->quantity, 0, ',', '.') }}</td>
            </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr>
              <td colspan="5" class="text-end"><strong>Biaya Layanan</strong></td>
              <td><strong>Rp {{ number_format($transaction->app_fee, 0, ',', '.') }}</strong></td>
            </tr>
            <tr>
              <td colspan="5" class="text-end"><strong>Total</strong></td>
              <td><strong>Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</strong></td>
            </tr>
            <tr>
              <td colspan="5" class="text-end"><strong>Ongkos Kirim</strong></td>
              <td><strong>Rp {{ number_format($transaction->shipping_price, 0, ',', '.') }}</strong></td>
            </tr>
            <tr>
              <td colspan="5" class="text-end"><strong>Biaya Tambahan</strong></td>
              <td><strong>Rp {{ number_format($transaction->additional_cost, 0, ',', '.') }}</strong></td>
            </tr>
            <tr>
              <td colspan="5" class="text-end"><strong>Total Keseluruhan</strong></td>
              <td><strong>Rp {{ number_format($transaction->total_price + $transaction->shipping_price + $transaction->additional_cost, 0, ',', '.') }}</strong></td>
            </tr>
          </tfoot>
        </table>
      </div>

      <div class="mt-4">
        <h6>Update Status</h6>
        <form action="{{ route('dashboard.transaction.updateStatus', $transaction->id) }}" method="POST" class="d-flex align-items-center">
          @csrf
          @method('PATCH')
          <select class="form-select me-2" name="status" style="width: auto;">
            <option value="pending" {{ $transaction->status == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="processing" {{ $transaction->status == 'processing' ? 'selected' : '' }}>Processing</option>
            <option value="shipped" {{ $transaction->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
            {{-- <option value="delivered" {{ $transaction->status == 'delivered' ? 'selected' : '' }}>Delivered</option> --}}
            <option value="cancelled" {{ $transaction->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
          </select>
          <button type="submit" class="btn btn-primary">Update Status</button>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- / Content -->
@endsection
