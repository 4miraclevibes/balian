@extends('layouts.dashboard.main')

@section('content')
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card mt-2">
    <h5 class="card-header">Tabel Transaksi</h5>
    <div class="table-responsive text-nowrap p-3">
      <table class="table" id="example">
        <thead>
          <tr class="text-nowrap table-dark">
            <th class="text-white">No</th>
            <th class="text-white">Aksi</th>
            <th class="text-white">Kode Transaksi</th>
            <th class="text-white">Nama Pengguna</th>
            <th class="text-white">Total Harga</th>
            <th class="text-white">Status</th>
            <th class="text-white">Tanggal</th>
            <th class="text-white">Ongkos Kirim</th>
            <th class="text-white">Biaya Layanan</th>
            <th class="text-white">Status Pembayaran</th>
            <th class="text-white">Alamat</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($transactions as $transaction)
          <tr>
            <th scope="row">{{ $loop->iteration }}</th>
            <td>
              <button type="button" class="btn btn-primary btn-sm" {{ $transaction->status == 'delivered' ? 'disabled' : '' }} data-bs-toggle="modal" data-bs-target="#updateStatusModal{{ $transaction->id }}">
                Update Status
              </button>
              <a href="{{ route('dashboard.transaction.show', $transaction->id) }}" class="btn btn-info btn-sm">Detail</a>
            </td>
            <td>{{ $transaction->code }}</td>
            <td>{{ $transaction->user->name }}</td>
            <td>Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
            <td>{{ $transaction->status }}</td>
            <td>{{ $transaction->created_at->format('d M Y H:i') }}</td>
            <td>Rp {{ number_format($transaction->shipping_price, 0, ',', '.') }}</td>
            <td>Rp {{ number_format($transaction->app_fee, 0, ',', '.') }}</td>
            <td>{{ $transaction->payment->status ?? '***' }}</td>
            <td>{{ $transaction->address ?? '***' }}</td>
          </tr>

          <!-- Modal for updating status -->
          <div class="modal fade" id="updateStatusModal{{ $transaction->id }}" tabindex="-1" aria-labelledby="updateStatusModalLabel{{ $transaction->id }}" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <form action="{{ route('dashboard.transaction.updateStatus', $transaction->id) }}" method="POST">
                  @csrf
                  @method('PATCH')
                  <div class="modal-header">
                    <h5 class="modal-title" id="updateStatusModalLabel{{ $transaction->id }}">Update Status Transaksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <div class="mb-3">
                      <label for="status" class="form-label">Status</label>
                      <select class="form-select" id="status" name="status">
                        <option value="pending" {{ $transaction->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ $transaction->status == 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="shipped" {{ $transaction->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                        {{-- <option value="delivered" {{ $transaction->status == 'delivered' ? 'selected' : '' }}>Delivered</option> --}}
                        <option value="cancelled" {{ $transaction->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
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
        </tbody>
      </table>
    </div>
  </div>
</div>
<!-- / Content -->
@endsection
