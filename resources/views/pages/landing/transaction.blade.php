@extends('layouts.landing.main')

@section('style')
<style>
    .nav-pills-wrapper {
        overflow-x: auto;
        white-space: nowrap;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none; /* Firefox */
        -ms-overflow-style: none;  /* Internet Explorer 10+ */
    }
    .nav-pills-wrapper::-webkit-scrollbar { /* WebKit */
        display: none;
    }
    .nav-pills {
        display: flex;
        width: 100%;
        padding: 0;
        margin: 0;
        list-style: none;
    }
    .nav-pills .nav-item {
        flex: 0 0 25%; /* Setiap item mengambil 25% lebar, sehingga 4 item pas dalam satu baris */
        text-align: center;
    }
    .nav-pills .nav-link {
        display: block;
        color: #333;
        border-bottom: 2px solid transparent;
        padding: 0.5rem 0;
        text-decoration: none;
    }
    .nav-pills .nav-link.active {
        background-color: transparent;
        color: #4caf50;
        border-bottom: 2px solid #4caf50;
    }
    .order-card {
        border: 1px solid #e0e0e0;
        border-radius: 10px;
        margin-bottom: 15px;
    }
    .order-status {
        color: #ff9800;
    }
    .btn-pay {
        background-color: #4caf50;
        color: white;
        border: none;
        border-radius: 20px;
        padding: 5px 15px;
    }
    .product-list {
        margin-top: 10px;
    }
    .product-item {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }
    .product-image {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 5px;
        margin-right: 10px;
    }
    .product-details {
        flex-grow: 1;
    }
    .product-name {
        font-weight: bold;
        margin-bottom: 0;
    }
    .product-price {
        font-size: 0.9em;
        color: #666;
    }
    .info-item {
        padding: 8px 0;
        border-bottom: 1px solid #f0f0f0;
    }
    .info-label {
        font-weight: bold;
    }
    .info-value {
        margin-left: 10px;
    }
    .info-item:last-child {
        border-bottom: none;
    }
    
    .info-item {
        padding: 8px 0;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .info-item:last-child {
        border-bottom: none;
    }
    
    .info-label {
        color: #666;
    }
    
    .info-value {
        color: #333;
    }
    
    .text-warning {
        color: #ff9800 !important;
    }
    
    .text-success {
        color: #4caf50 !important;
    }
    
    .text-danger {
        color: #f44336 !important;
    }
    
    .text-secondary {
        color: #666 !important;
    }

    // Tambahan style untuk memperbaiki tampilan
    .transaction-info {
        background-color: #fff;
        border-radius: 8px;
    }
    
    .customer-info {
        padding: 12px 0;
    }
    
    .info-label span {
        font-size: 14px;
    }
    
    .info-value span {
        font-size: 14px;
    }
</style>
@endsection

@section('content')
<div class="container mt-3">
    <div class="bg-white mb-2">
        <div class="d-flex align-items-center">
            <a href="{{ route('home') }}" class="text-success bg-success bg-opacity-10 rounded-circle p-2 d-inline-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                <i class="bi bi-chevron-left"></i>
            </a>
            <p class="fs-2 m-auto mb-0">Daftar Pesanan</p>
        </div>
    </div>

    @if(Auth::user()->role->name == 'driver')
        <div class="nav-pills-wrapper mb-3">
            <ul class="nav nav-pills justify-content-between">
                <li class="nav-item">
                    <a class="nav-link {{ request('status', 'shipped') == 'shipped' ? 'active' : '' }}" href="{{ route('transaction', ['status' => 'shipped']) }}">Dikirim</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('status') == 'delivered' ? 'active' : '' }}" href="{{ route('transaction', ['status' => 'delivered']) }}">Selesai</a>
                </li>
            </ul>
        </div>
    @else
        {{-- Tampilkan navigasi untuk role lain --}}
        <div class="nav-pills-wrapper mb-3">
            <ul class="nav nav-pills">
                <li class="nav-item">
                    <a class="nav-link {{ in_array(request('status', 'all'), ['all', 'pending', 'processing']) ? 'active' : '' }}" href="{{ route('transaction', ['status' => 'all']) }}">Diproses</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('status') == 'shipped' ? 'active' : '' }}" href="{{ route('transaction', ['status' => 'shipped']) }}">Dikirim</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ in_array(request('status'), ['delivered', 'done']) ? 'active' : '' }}" href="{{ route('transaction', ['status' => 'delivered']) }}">Selesai</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('status') == 'cancelled' ? 'active' : '' }}" href="{{ route('transaction', ['status' => 'cancelled']) }}">Dibatalkan</a>
                </li>
            </ul>
        </div>
    @endif
    <div class="order-list">
        @foreach($transactions as $transaction)
        <div class="order-card p-3">
            <div class="d-flex justify-content-between mb-2">
                <span>
                    <span class="fw-bold text-dark">Kode Transaksi: </span>
                    <span id="transactionCode{{ $transaction->id }}">{{ $transaction->code }}</span>
                </span>
                <span>
                    <i class="bi bi-clipboard copy-icon" onclick="copyTransactionCode('{{ $transaction->id }}')"></i>
                </span>
            </div>
            
            @if($transaction->notes)
            <div class="card bg-light mb-3">
                <div class="card-body">
                    <h6 class="card-title fw-bold text-dark mb-2">Catatan Pesanan:</h6>
                    <p class="card-text mb-0">{{ $transaction->notes }}</p>
                </div>
            </div>
            @endif

            <div class="card bg-light mb-3">
                <div class="card-body">
                    <h6 class="card-title fw-bold text-dark mb-2">Alamat Pengiriman:</h6>
                    <p class="card-text mb-0">{{ $transaction->address }}</p>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-start">
                <div class="transaction-info w-100">
                    <!-- Info Pelanggan -->
                    <div class="customer-info mb-3">
                        <div class="info-item d-flex mb-2">
                            <div class="info-label" style="width: 140px;">
                                <span class="fw-bold text-dark">Pemesan</span>
                            </div>
                            <div class="info-value flex-grow-1">
                                <span class="text-secondary">{{ $transaction->user->name }}</span>
                            </div>
                        </div>
                        
                        <!-- Status -->
                        <div class="info-item d-flex mb-2">
                            <div class="info-label" style="width: 140px;">
                                <span class="fw-bold text-dark">Status Transaksi</span>
                            </div>
                            <div class="info-value">
                                <span class="text-warning">
                                    @if($transaction->status == 'pending' || $transaction->status == 'processing')
                                        Diproses
                                    @elseif($transaction->status == 'shipped')
                                        Dikirim
                                    @elseif($transaction->status == 'delivered')
                                        Diterima
                                    @elseif($transaction->status == 'done')
                                        Selesai
                                    @elseif($transaction->status == 'cancelled')
                                        Dibatalkan
                                    @else
                                        {{ ucfirst($transaction->status) }}
                                    @endif
                                </span>
                            </div>
                        </div>

                        <div class="info-item d-flex mb-2">
                            <div class="info-label" style="width: 140px;">
                                <span class="fw-bold text-dark">Status Pembayaran</span>
                            </div>
                            <div class="info-value">
                                @if($transaction->payment && $transaction->payment->status == 'success')
                                    <span class="text-success">Sudah Lunas</span>
                                @else
                                    <span class="text-danger">Belum Lunas</span>
                                @endif
                            </div>
                        </div>

                        <!-- Rincian Biaya -->
                        <div class="info-item d-flex mb-2">
                            <div class="info-label" style="width: 140px;">
                                <span class="fw-bold text-dark">Ongkir</span>
                            </div>
                            <div class="info-value">
                                <span class="text-secondary">Rp {{ number_format($transaction->shipping_price, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        @if($transaction->additional_cost > 0)
                        <div class="info-item d-flex mb-2">
                            <div class="info-label" style="width: 140px;">
                                <span class="fw-bold text-dark">Biaya Tambahan</span>
                            </div>
                            <div class="info-value">
                                <span class="text-secondary">Rp {{ number_format($transaction->additional_cost, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        @endif

                        <div class="info-item d-flex mb-2">
                            <div class="info-label" style="width: 140px;">
                                <span class="fw-bold text-dark">Total Bill</span>
                            </div>
                            <div class="info-value">
                                <span class="fw-bold text-success">Rp {{ number_format($transaction->total_price + $transaction->shipping_price + $transaction->additional_cost, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="product-list border-top pt-2">
                @foreach($transaction->details as $detail)
                <div class="product-item">
                    <img src="{{ $detail->variant->product->thumbnail }}" alt="{{ $detail->variant->product->name }}" class="product-image">
                    <div class="product-details">
                        <p class="product-name">{{ $detail->variant->product->name }}</p>
                        <p class="product-variant-name">
                            {{ $detail->variant->name }}
                        </p>
                        <p class="product-price">
                            {{ $detail->quantity }}x Rp {{ number_format($detail->variant->price, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="d-flex justify-content-between">
                @if(Auth::user()->role->name == 'user' && $transaction->status != 'cancelled' && $transaction->status == 'pending')
                <form action="{{ route('transaction.updateStatus', $transaction->id) }}" method="POST" class="" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan transaksi ini?')">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="cancelled">
                    <button type="submit" class="btn btn-danger btn-sm mt-2">Cancel</button>
                </form>
                @endif
                @if($transaction->status == 'delivered' && $transaction->payment->status == 'success')
                <form action="{{ route('transaction.markAsDone', $transaction->id) }}" method="POST" class="" onsubmit="return confirm('Apakah Anda yakin ingin menandai transaksi ini selesai?')">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-success btn-sm mt-2">Tandai Selesai</button>
                </form>
                @endif
                @if ($transaction->payment && Auth::user()->role->name == 'driver' && $transaction->payment->status == 'pending')
                <form action="{{ route('transaction.pay', $transaction->id) }}" method="POST" class="">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-primary btn-sm mt-2">Bayar</button>
                </form>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>

<script>
function copyTransactionCode(transactionId) {
    var codeElement = document.getElementById('transactionCode' + transactionId);
    var code = codeElement.innerText;
    
    navigator.clipboard.writeText(code).then(function() {
        // Opsional: Tambahkan feedback visual bahwa kode telah disalin
        alert('Kode transaksi berhasil disalin!');
    }).catch(function(err) {
        console.error('Gagal menyalin teks: ', err);
    });
}
</script>
@endsection