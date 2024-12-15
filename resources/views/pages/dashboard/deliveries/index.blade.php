@extends('layouts.dashboard.main')

@section('content')
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card mt-2">
    <h5 class="card-header">Tabel Pengiriman</h5>
    <div class="table-responsive text-nowrap p-3">
      <table class="table" id="example">
        <thead>
          <tr class="text-nowrap table-dark">
            <th class="text-white">No</th>
            <th class="text-white">Kode Pembayaran</th>
            <th class="text-white">Operator</th>
            <th class="text-white">Driver</th>
            <th class="text-white">Nama Pengguna</th>
            <th class="text-white">Alamat</th>
            <th class="text-white">Total Harga</th>
            <th class="text-white">Ongkos Kirim</th>
            <th class="text-white">Status</th>
            <th class="text-white">Status Pembayaran</th>
            <th class="text-white">Tanggal</th>
            <th class="text-white">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($transactions as $transaction)
          <tr>
            <th scope="row">{{ $loop->iteration }}</th>
            <td>{{ $transaction->payment->code ?? '***' }}</td>
            <td>{{ $transaction->payment->operator ?? '***' }}</td>
            <td>{{ $transaction->payment->user->name ?? '***' }}</td>
            <td>{{ $transaction->user->name }}</td>
            <td>{{ $transaction->address ?? '***' }}</td>
            <td>Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
            <td>Rp {{ number_format($transaction->shipping_price, 0, ',', '.') }}</td>
            <td>{{ $transaction->status }}</td>
            <td>{{ $transaction->payment->status ?? '***' }}</td>
            <td>{{ $transaction->created_at->format('d M Y H:i') }}</td>
            <td>
              <button type="button" class="btn btn-primary btn-sm" {{ $transaction->status == 'delivered' || $transaction->status == 'done' ? 'disabled' : '' }} data-bs-toggle="modal" data-bs-target="#updateStatusModal{{ $transaction->id }}">
                Update Driver
              </button>
              <a href="{{ route('dashboard.transaction.show', $transaction->id) }}" class="btn btn-info btn-sm">Detail</a>
            </td>
          </tr>

          <!-- Modal for updating status -->
          <div class="modal fade" id="updateStatusModal{{ $transaction->id }}" tabindex="-1" aria-labelledby="updateStatusModalLabel{{ $transaction->id }}" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <form action="{{ route('dashboard.payment.store', $transaction->id) }}" method="POST">
                  @csrf
                  @method('POST')
                  <div class="modal-header">
                    <h5 class="modal-title" id="updateStatusModalLabel{{ $transaction->id }}">Update Driver</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <div class="mb-3">
                      <label for="user_id" class="form-label">Driver</label>
                      <select class="form-select" id="user_id" name="user_id">
                        @foreach ($users as $user)
                          <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
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