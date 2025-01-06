@extends('layouts.landing.main')

@section('style')
<style>
    .quantity-control {
        display: flex;
        align-items: center;
        background-color: #e8f5e9;
        border-radius: 20px;
        padding: 2px 4px;
        margin-left: auto;
    }
    .quantity-btn {
        background: none;
        border: none;
        font-size: 1.2rem;
        color: #4caf50;
        padding: 0 8px;
        cursor: pointer;
        height: 32px;
        width: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .quantity-input {
        background: none;
        border: none;
        text-align: center;
        width: 35px;
        font-size: 1rem;
        font-weight: bold;
    }
    .order-info {
        background-color: #4caf50;
        color: white;
        border-radius: 10px;
        padding: 15px;
    }
    .order-button {
        background-color: #4caf50;
        color: white;
        border: none;
        border-radius: 25px;
        padding: 10px;
        width: 100%;
        font-weight: bold;
    }
    .card {
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    textarea#orderNotes {
        resize: none;
        border-radius: 8px;
        font-size: 14px;
    }
    textarea#orderNotes:focus {
        box-shadow: 0 0 0 0.2rem rgba(255,255,255,0.25);
    }

    .shipping-method-btn {
    min-width: 150px;
    }

    .shipping-method-btn .btn {
        width: 100%;
        height: 100%;
        text-align: left;
        padding: 10px;
        border-radius: 10px;
    }

    .btn-check:checked + .btn-outline-success {
        background-color: #4caf50;
        color: white;
    }
</style>
@endsection

@section('content')
<form action="{{ route('transaction.store') }}" method="POST" id="orderForm">
    @csrf
    <input type="hidden" name="total_price" id="hiddenTotal">
    <input type="hidden" name="shipping_price" id="hiddenShippingPrice">
    <input type="hidden" name="app_fee" id="hiddenAppFee">
    <div class="container mt-3">
        <div class="d-flex justify-content-between mb-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="selectAll" checked>
                <label class="form-check-label" for="selectAll">Pilih Semua</label>
            </div>
            <button type="button" id="deleteButton" class="btn btn-link text-danger p-0">Hapus</button>
        </div>

        <div class="cart-items">
            @foreach($carts as $index => $cart)
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row align-items-center">
                        <!-- Kolom 1: Checkbox, Gambar, dan Info Produk -->
                        <div class="col-7">
                            <div class="d-flex align-items-center">
                                <div class="form-check">
                                    <input class="form-check-input item-checkbox" type="checkbox" name="checked_items[]" value="{{ $cart->id }}" data-index="{{ $index }}" checked>
                                </div>
                                <img src="{{ $cart->variant->product->thumbnail }}" alt="{{ $cart->variant->product->name }}" class="img-fluid ms-2" style="width: 60px; height: 60px; object-fit: cover;">
                                <div class="ms-3">
                                    <h6 class="mb-0">{{ $cart->variant->product->name }}</h6>
                                    <small class="text-muted">{{ $cart->variant->name }}</small> <br>
                                    <small class="text-muted">Stok: {{ $cart->variant->getAvailableStockCount() }}</small>
                                    <p class="mb-0 fw-bold">Rp {{ number_format($cart->variant->price, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Kolom 2: Badge dan Quantity -->
                        <div class="col-5">
                            <div class="d-flex flex-column justify-content-between" style="height: 100%; min-height: 80px;">
                                <div class="text-end">
                                    @if($cart->variant->product->delivery_type == 'instant')
                                        <span class="badge bg-success" style="font-size: 0.65rem; padding: 0.35em 0.8em;">
                                            <i class="bi bi-lightning-fill"></i> Instant
                                        </span>
                                    @else
                                        <span class="badge bg-warning" style="font-size: 0.65rem; padding: 0.35em 0.8em;">
                                            <i class="bi bi-clock-history"></i> Proses
                                        </span>
                                    @endif
                                </div>
                                <div class="quantity-control align-self-end">
                                    <button type="button" class="quantity-btn minus" data-index="{{ $index }}">-</button>
                                    <input type="text" class="quantity-input" name="quantities[{{ $cart->id }}]" value="{{ $cart->quantity }}" readonly>
                                    <button type="button" class="quantity-btn plus" data-index="{{ $index }}">+</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mb-3">
            <label for="orderNotes" class="form-label" style="color: #4caf50;">Catatan Pesanan</label>
            <textarea
                class="form-control"
                id="orderNotes"
                name="notes"
                rows="8"
                placeholder="Contoh: Tolong pilihkan sayur yang masih segar, Mohon pisahkan sayur dan bumbu, Pilih telur yang utuh, dll."
                style="background-color: #f8f9fa; border: 1px solid #e0e0e0;"
            ></textarea>

            <div class="border rounded p-3 mt-2 bg-light">
                <i class="bi bi-info-circle text-primary"></i>
                <small>
                    <strong>Catatan:</strong><br>
                    • Anda dapat menambahkan permintaan produk yang tidak tersedia di katalog kami<br>
                    • Apabila ada permintaan khusus yang memerlukan biaya tambahan, akan diinformasikan oleh admin dan tidak termasuk dalam total pembayaran saat ini
                </small>
            </div>
{{-- 
            <div class="border rounded p-3 mt-2 bg-light">
                <i class="bi bi-info-circle text-primary"></i>
                <small>
                    <strong>Info Waktu Pengiriman (Khusus Pesanan Proses):</strong><br>
                    • Pesan 00:00 - 12:00 → Diantar besok pagi (5:30 - 10:00)<br>
                    • Pesan 12:00 - 24:00 → Diantar besok siang (15:30 - 18:00)
                </small>
            </div> --}}
        </div>

        <div class="mb-3">
            <label class="form-label" style="color: #4caf50;">Metode Pengiriman</label>
            <div class="row g-2">
                @foreach($shippingMethods as $method)
                    <div class="col-6">
                        <div class="shipping-method-btn">
                            <input type="radio" 
                                   class="btn-check" 
                                   name="shipping_method" 
                                   id="shipping_{{ $method->id }}" 
                                   value="{{ $method->id }}"
                                   {{ $loop->first ? 'checked' : '' }}>
                            <label class="btn btn-outline-success" for="shipping_{{ $method->id }}">
                                <div class="d-flex flex-column">
                                    <strong>{{ $method->name }}</strong>
                                    <small>Rp {{ number_format($method->cost, 0, ',', '.') }}</small>
                                    <small class="text-muted">{{ $method->description }}</small>
                                </div>
                            </label>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="order-info mt-4 mb-3">
            <h6 class="mb-3">Order Info</h6>
            <div class="d-flex justify-content-between mb-2">
                <span>Subtotal</span>
                <span id="subtotal">Rp0</span>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <span>Biaya Ongkos Kirim</span>
                <span>Rp0</span>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <span>Biaya Layanan</span>
                <span id="totalShipping">Rp0</span>
            </div>
            <input type="hidden" id="appFee" value="0">
            <hr>
            <div class="d-flex justify-content-between fw-bold">
                <span>Total</span>
                <span id="total">Rp0</span>
            </div>
        </div>
        @if(Auth::user()->userAddress->where('status', 'active')->count() > 0)
        <button type="submit" class="order-button mb-5" id="orderButton" disabled>
            Pesan Sekarang <i class="bi bi-arrow-right"></i>
        </button>
        @else
        <a href="{{ route('user.addresses') }}" class="btn btn-success w-100 mb-5">
            Belanja Sekarang <i class="bi bi-arrow-right"></i>
        </a>
        @endif
    </div>
</form>

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let items = {!! json_encode($carts->map(function($cart) {
        return [
            'id' => $cart->id,
            'quantity' => $cart->quantity,
            'variant' => [
                'id' => $cart->variant->id,
                'price' => $cart->variant->price,
                'stock' => $cart->variant->getAvailableStockCount()
            ]
        ];
    })) !!};
    let shippingCost = {!! json_encode($shipping_price) !!};
    let appFee = {!! json_encode($app_fee) !!};
    const orderButton = document.getElementById('orderButton');

    console.log('Items:', items);
    console.log('Shipping Cost:', shippingCost);
    console.log('App Fee:', appFee);

    let shippingMethods = {!! json_encode($shippingMethods) !!};
    
    // Fungsi untuk memperbarui biaya pengiriman
    function updateShippingCost() {
        let selectedMethod = document.querySelector('input[name="shipping_method"]:checked');
        if (selectedMethod) {
            let method = shippingMethods.find(m => m.id == selectedMethod.value);
            appFee = method.cost;
            document.getElementById('totalShipping').textContent = `Rp${shippingCost.toLocaleString('id-ID')}`;
            updateTotal();
        }
    }

    // Event listener untuk perubahan metode pengiriman
    document.querySelectorAll('input[name="shipping_method"]').forEach(radio => {
        radio.addEventListener('change', updateShippingCost);
    });

    // Inisialisasi biaya pengiriman
    updateShippingCost();

    // Fungsi untuk memperbarui kuantitas
    function updateQuantity(index, change) {
        if (items[index] && items[index].quantity !== undefined) {
            let newQuantity = Math.max(1, items[index].quantity + change);
            let availableStock = items[index].variant.stock;

            if (newQuantity <= availableStock) {
                items[index].quantity = newQuantity;
                let quantityInput = document.querySelectorAll('.quantity-input')[index];
                if (quantityInput) {
                    quantityInput.value = items[index].quantity;
                }
                updateTotal();
            } else {
                alert('Jumlah melebihi stok yang tersedia');
            }
        }
    }

    // Fungsi untuk memperbarui total
    function updateTotal() {
        let subtotal = 0;
        let anyItemChecked = false;
        items.forEach((item, index) => {
            let checkbox = document.querySelectorAll('.item-checkbox')[index];
            if (checkbox && checkbox.checked) {
                anyItemChecked = true;
                subtotal += item.variant.price * item.quantity;
            }
        });
        let totalShipping = shippingCost + appFee;
        let total = subtotal + totalShipping;

        document.getElementById('subtotal').textContent = `Rp${subtotal.toLocaleString('id-ID')}`;
        document.getElementById('totalShipping').textContent = `Rp${totalShipping.toLocaleString('id-ID')}`;
        document.getElementById('total').textContent = `Rp${total.toLocaleString('id-ID')}`;
        document.getElementById('hiddenTotal').value = total;
        document.getElementById('hiddenShippingPrice').value = shippingCost;
        document.getElementById('hiddenAppFee').value = appFee;

        orderButton.disabled = !anyItemChecked;
    }

    // Event listeners
    document.querySelectorAll('.minus').forEach((btn, index) => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            updateQuantity(index, -1);
        });
    });

    document.querySelectorAll('.plus').forEach((btn, index) => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            updateQuantity(index, 1);
        });
    });

    document.querySelectorAll('.item-checkbox').forEach((checkbox) => {
        checkbox.addEventListener('change', updateTotal);
    });

    document.getElementById('selectAll').addEventListener('change', function() {
        let checkboxes = document.querySelectorAll('.item-checkbox');
        checkboxes.forEach(cb => cb.checked = this.checked);
        updateTotal();
    });

    // Inisialisasi
    updateTotal();

    document.getElementById('deleteButton').addEventListener('click', function(e) {
        e.preventDefault();
        let checkedItems = document.querySelectorAll('.item-checkbox:checked');
        if (checkedItems.length === 0) {
            alert('Pilih setidaknya satu item untuk dihapus');
            return;
        }
        if (confirm('Apakah Anda yakin ingin menghapus item yang dipilih?')) {
            let form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("cart.destroy") }}';
            form.innerHTML = `@csrf @method('DELETE')`;
            checkedItems.forEach(item => {
                let input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'items[]';
                input.value = item.value;
                form.appendChild(input);
            });
            document.body.appendChild(form);
            form.submit();
        }
    });
});
</script>
@endsection

@endsection
