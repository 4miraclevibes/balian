@extends('layouts.landing.main')

@section('style')
<style>
    .categories-wrapper {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none;
        -ms-overflow-style: none;
    }

    .categories-wrapper::-webkit-scrollbar {
        display: none;
    }

    .category-item {
        flex: 0 0 auto;
        width: 3.5rem;
        text-align: center;
    }

    .category-item img {
        background-color: white;
        border-radius: 10%;
        padding: 1px;
        width: 3.5rem;
        height: 3.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .category-item p {
        font-size: 0.7rem;
        margin-top: 5px;
    }

    .icon-wrapper {
        background-color: white;
        border-radius: 10%;
        padding: 5px;
        width: 3.5rem;
        height: 3.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .icon-wrapper svg {
        width: 100%;
        height: 100%;
    }

    .card {
        border: none;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .card-img-top {
        height: 120px;
        object-fit: cover;
    }

    .product-thumbnail {
        width: 100%;
        height: 200px;
        object-fit: cover;
        object-position: center;
    }

    .btn-add {
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        padding: 0;
    }

    .wrapper {
        max-width: 480px;
        margin: 0 auto;
        background-color: white;
        padding-bottom: 60px;
    }

    .modal.fade .modal-dialog {
        transform: translateY(100%);
        transition: transform 0.3s ease-out;
    }

    .modal.show .modal-dialog {
        transform: translateY(0);
    }

    .modal-dialog {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        margin: 0;
        max-width: 100%;
    }

    .modal-content {
        border-radius: 1rem 1rem 0 0;
        max-width: 480px; /* Sesuaikan dengan lebar maksimum konten utama */
        margin: 0 auto;
    }

    .variant-button {
        border: 1px solid #ddd;
        background-color: white;
        color: black;
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
    }

    .variant-button.active {
        background-color: #4CAF50;
        color: white;
        border-color: #4CAF50;
    }

    .quantity-control {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background-color: #f0f0f0;
        border-radius: 0.5rem;
        padding: 0.5rem 0.5rem;
        width: 8rem    ;
    }

    .quantity-control button {
        background-color: transparent;
        border: none;
        font-size: 1rem;
        color: #4CAF50;
    }

    .quantity-control input {
        background-color: transparent;
        border: none;
        text-align: center;
        width: 2rem;
        font-size: 1rem;
    }

    .add-to-cart-btn {
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 0.5rem;
        padding: 0.75rem;
        font-size: 1rem;
        width: 100%;
    }

    .install-button {
        position: fixed;
        bottom: 80px;
        right: 20px;
        background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        color: #333;
        border: none;
        border-radius: 16px;
        padding: 12px 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1), 0 1px 3px rgba(0,0,0,0.08);
        z-index: 999;
        display: none;
        gap: 10px;
        font-size: 15px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: 1px solid rgba(0,0,0,0.05);
    }

    .install-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.15);
        background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
    }

    .install-button i.bi-google-play {
        color: #4CAF50;
        font-size: 18px;
    }

    .install-button i.bi-apple {
        color: #333;
        font-size: 20px;
    }

    .install-button::before {
        content: '';
        position: absolute;
        inset: 0;
        border-radius: 16px;
        padding: 1px;
        background: linear-gradient(135deg, rgba(76,175,80,0.2), rgba(0,0,0,0.05));
        -webkit-mask: linear-gradient(#fff 0 0) content-box,
                     linear-gradient(#fff 0 0);
        mask: linear-gradient(#fff 0 0) content-box,
              linear-gradient(#fff 0 0);
        -webkit-mask-composite: xor;
        mask-composite: exclude;
    }

    .search-wrapper {
        position: relative;
    }

    .search-icon {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #6c757d;
    }

    .home-alert {
        position: fixed;
        top: 20px;
        right: 20px;
        max-width: 300px;
        padding: 12px 15px;
        border-radius: 4px;
        font-weight: 500;
        z-index: 9999;
        opacity: 0;
        transform: translateY(-20px);
        transition: all 0.3s ease-in-out;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        background-color: #d4edda;
        color: #155724;
        border-left: 4px solid #28a745;
    }

    .home-alert.show {
        opacity: 1;
        transform: translateY(0);
    }

    .home-alert-content {
        display: flex;
        align-items: center;
        flex-grow: 1;
        margin-right: 10px;
    }

    .home-alert-icon {
        margin-right: 10px;
        font-size: 1.2em;
    }

    .home-alert-message {
        line-height: 1.4;
        font-size: 14px;
    }

    .home-alert-close {
        font-size: 1.2em;
        font-weight: 700;
        line-height: 1;
        color: #000;
        text-shadow: 0 1px 0 #fff;
        opacity: .5;
        cursor: pointer;
        padding-left: 10px;
    }

    .home-alert-close:hover {
        opacity: .75;
    }
</style>
@endsection

@section('content')
<div class="container">
    <section class="banner mb-3">
        <img src="{{ $banners->first()->image }}" alt="Banner" class="w-100 rounded" id="categoryBanner">
    </section>

    <section class="search mb-3">
        <div class="search-wrapper">
            <input type="text" class="form-control" id="searchInput" placeholder="Cari produk..." oninput="searchProducts(this.value)">
            <i class="bi bi-search search-icon"></i>
        </div>
    </section>

    <section class="categories mb-4">
        <h6 class="mb-3">Kategori</h6>
        <div class="categories-wrapper">
            <div class="d-flex">
                <div class="category-item me-3">
                    <a href="javascript:void(0)" onclick="filterProducts('all')" class="text-decoration-none no-loading">
                        <div class="icon-wrapper card category-filter active" data-category="all">
                            <img src="{{ $assets->where('name', 'logo-mark')->first()->image ?? asset('assets/landing/images/logo-balian.png') }}" alt="Semua Kategori" class="w-100">
                        </div>
                        <p class="mb-0 category-text" data-category="all">Semua</p>
                    </a>
                </div>
                @foreach($categories as $category)
                <div class="category-item me-3">
                    <a href="javascript:void(0)" onclick="filterProducts('{{ $category->id }}')" class="text-decoration-none no-loading">
                        <img src="{{ $category->image }}" alt="{{ $category->name }}" class="w-100 card category-filter" data-category="{{ $category->id }}">
                        <p class="mb-0 category-text" data-category="{{ $category->id }}">{{ $category->name }}</p>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="products">
        <h6 class="mb-3">Produk <span id="categoryName" class="text-success">Semua Kategori</span></h6>
        <div class="row g-3" id="productsContainer">
            @foreach($products as $product)
            <div class="col-6 product-item" data-category="{{ $product->category_id }}">
                <div class="card h-100">
                    <a href="{{ route('product.detail', $product->slug) }}">
                        <img src="{{ $product->thumbnail }}" class="card-img-top product-thumbnail" alt="{{ $product->name }}">
                    </a>
                    <div class="card-body p-2 d-flex flex-column">
                        <p class="card-title mb-0 fw-bold" style="font-size: 0.9rem">{{ $product->name }}</p>
                        <p class="card-text text-muted small mb-2" style="font-size: 0.8rem">{{ $product->description }}</p>
                        <div class="mt-auto">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold">Rp {{ number_format($product->variants->first()->price ?? 0, 0, ',', '.') }}</span>
                                <a href="#" class="btn-add text-decoration-none no-loading @auth {{ Auth::user()->role->name == 'user' ? '' : 'disabled' }} @endauth"
                                   data-product-id="{{ $product->id }}"
                                   data-product-name="{{ $product->name }}"
                                   data-product-price="{{ number_format($product->variants->first()->price ?? 0, 0, ',', '.') }}"
                                   data-variants="{{ json_encode($product->variants->map(function($variant) {
                                       return [
                                           'id' => $variant->id,
                                           'name' => $variant->name,
                                           'price' => $variant->price,
                                           'stock' => $variant->getAvailableStockCount()
                                       ];
                                   })) }}">+</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade container" id="addToCartModal" tabindex="-1" aria-labelledby="addToCartModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-bottom">
            <div class="modal-content">
                <div class="modal-body p-4">
                    <div class="d-flex mb-3">
                        <img id="productImage" src="" alt="Product Image" class="me-3" style="width: 80px; height: 80px; object-fit: cover;">
                        <div>
                            <h5 id="productName" class="mb-1"></h5>
                            <p id="productVariants" class="text-muted small mb-1"></p>
                            <p id="productPrice" class="fw-bold mb-0"></p>
                        </div>
                    </div>

                    <div class="mb-3">
                        <p class="mb-2">Pilih Varian</p>
                        <div id="variantButtons" class="d-flex flex-wrap gap-2">
                            <!-- Varian buttons akan ditambahkan secara dinamis menggunakan JavaScript -->
                        </div>
                    </div>

                    <p class="mb-2">Stok: <span id="productStock"></span></p>

                    <div class="mb-3">
                        <p class="mb-2">Pilih Jumlah</p>
                        <div class="quantity-control">
                            <button id="decreaseQuantity">-</button>
                            <input type="number" id="quantity" name="quantity" value="1" min="1" readonly>
                            <button id="increaseQuantity">+</button>
                        </div>
                    </div>

                    <form id="addToCartForm" action="{{ route('cart.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="variant_id" id="variantId">
                        <input type="hidden" name="quantity" id="formQuantity">
                        <button type="submit" class="add-to-cart-btn">Tambah Ke Keranjang</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<button id="installButton" class="install-button">
    <i class="bi bi-google-play"></i>
    <i class="bi bi-apple"></i>
    Install App
</button>
@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const addToCartButtons = document.querySelectorAll('.btn-add');
        const modal = new bootstrap.Modal(document.getElementById('addToCartModal'));
        const quantityInput = document.getElementById('quantity');
        const decreaseBtn = document.getElementById('decreaseQuantity');
        const increaseBtn = document.getElementById('increaseQuantity');
        let currentVariants = [];
        let selectedVariant = null;

        addToCartButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const productId = this.dataset.productId;
                const productName = this.dataset.productName;
                const productImage = this.closest('.card').querySelector('.product-thumbnail').src;
                currentVariants = JSON.parse(this.dataset.variants);

                // Filter varian dengan stok > 0
                currentVariants = currentVariants.filter(variant => variant.stock > 0);

                document.getElementById('productName').textContent = productName;
                document.getElementById('productImage').src = productImage;
                document.getElementById('productVariants').textContent = currentVariants.map(v => v.name).join(', ');

                // Reset quantity
                quantityInput.value = 1;

                // Tambahkan tombol varian
                const variantButtons = document.getElementById('variantButtons');
                variantButtons.innerHTML = '';
                currentVariants.forEach(variant => {
                    const button = document.createElement('button');
                    button.textContent = variant.name;
                    button.classList.add('variant-button');
                    button.onclick = (e) => {
                        e.preventDefault();
                        selectVariant(variant);
                    };
                    variantButtons.appendChild(button);
                });

                // Pilih varian pertama secara default (jika ada)
                if (currentVariants.length > 0) {
                    selectVariant(currentVariants[0]);
                    modal.show();
                } else {
                    alert('Maaf, produk ini sedang tidak tersedia.');
                }
            });
        });

        function selectVariant(variant) {
            selectedVariant = variant;
            document.getElementById('variantId').value = variant.id;
            document.getElementById('productPrice').textContent = `Rp ${variant.price.toLocaleString('id-ID')}`;
            document.getElementById('productStock').textContent = variant.stock;
            document.querySelectorAll('.variant-button').forEach(btn => {
                btn.classList.remove('active');
                if (btn.textContent === variant.name) {
                    btn.classList.add('active');
                }
            });
            updateQuantityControls();
        }

        function updateQuantityControls() {
            const stock = selectedVariant ? selectedVariant.stock : 0;
            const currentQuantity = parseInt(quantityInput.value);
            decreaseBtn.disabled = currentQuantity <= 1;
            increaseBtn.disabled = currentQuantity >= stock;
        }

        decreaseBtn.addEventListener('click', () => {
            if (quantityInput.value > 1) {
                quantityInput.value = parseInt(quantityInput.value) - 1;
                updateQuantityControls();
            }
        });

        increaseBtn.addEventListener('click', () => {
            const stock = selectedVariant ? selectedVariant.stock : 0;
            if (parseInt(quantityInput.value) < stock) {
                quantityInput.value = parseInt(quantityInput.value) + 1;
                updateQuantityControls();
            }
        });

        // Pastikan form ada sebelum menambahkan event listener
        const addToCartForm = document.getElementById('addToCartForm');
        if (addToCartForm) {
            addToCartForm.addEventListener('submit', async function(e) {
                e.preventDefault();

                // Periksa apakah CSRF token ada
                const csrfToken = document.querySelector('meta[name="csrf-token"]');
                if (!csrfToken) {
                    console.error('CSRF token tidak ditemukan');
                    showHomeAlert('Terjadi kesalahan sistem');
                    return;
                }

                // Set quantity ke form sebelum submit
                const formQuantity = document.getElementById('formQuantity');
                const quantity = document.getElementById('quantity');
                if (formQuantity && quantity) {
                    formQuantity.value = quantity.value;
                }

                const formData = new FormData(this);
                try {
                    const response = await fetch(this.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': csrfToken.getAttribute('content')
                        },
                        credentials: 'same-origin'
                    });

                    const result = await response.json();

                    if (response.ok) {
                        const modal = document.getElementById('addToCartModal');
                        if (modal) {
                            const modalInstance = bootstrap.Modal.getInstance(modal);
                            if (modalInstance) modalInstance.hide();
                        }

                        // Update cart badge
                        const cartBadge = document.querySelector('.cart-badge');
                        const cartCount = document.querySelector('.cart-count');

                        if (result.count > 0) {
                            if (!cartBadge) {
                                // Buat badge baru jika belum ada
                                const newBadge = document.createElement('span');
                                newBadge.className = 'position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger cart-badge';
                                newBadge.style.cssText = 'font-size: 0.5rem; margin-left: -1.5rem; margin-top: -0.2rem';

                                const countSpan = document.createElement('span');
                                countSpan.className = 'cart-count';
                                countSpan.textContent = result.count;

                                newBadge.appendChild(countSpan);
                                document.querySelector('.cart-link').appendChild(newBadge);
                            } else {
                                cartCount.textContent = result.count;
                            }
                        }
                        showHomeAlert(result.message || 'Produk berhasil ditambahkan ke keranjang');
                    } else {
                        showHomeAlert(result.message || 'Terjadi kesalahan, silakan coba lagi');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    showHomeAlert('Terjadi kesalahan pada sistem');
                }
            });
        }
    });

    let deferredPrompt;

    window.addEventListener('beforeinstallprompt', (e) => {
        // Prevent Chrome 67 and earlier from automatically showing the prompt
        e.preventDefault();
        // Stash the event so it can be triggered later.
        deferredPrompt = e;
        // Show the install button
        document.getElementById('installButton').style.display = 'flex';
    });

    document.getElementById('installButton').addEventListener('click', async () => {
        if (deferredPrompt) {
            // Show the install prompt
            deferredPrompt.prompt();
            // Wait for the user to respond to the prompt
            const { outcome } = await deferredPrompt.userChoice;
            // We no longer need the prompt. Clear it up.
            deferredPrompt = null;
            // Hide the install button
            document.getElementById('installButton').style.display = 'none';
        }
    });

    // Hide the install button if app is already installed
    window.addEventListener('appinstalled', () => {
        document.getElementById('installButton').style.display = 'none';
    });

    function searchProducts(keyword) {
        keyword = keyword.toLowerCase().trim();
        const products = document.querySelectorAll('.product-item');

        products.forEach(product => {
            const productName = product.querySelector('.card-title').textContent.toLowerCase();
            const productDesc = product.querySelector('.card-text').textContent.toLowerCase();

            // Cek apakah produk sesuai dengan kategori yang aktif
            const categoryId = document.querySelector('.category-filter.border-success').dataset.category;
            const matchCategory = categoryId === 'all' || product.dataset.category === categoryId;

            // Cek apakah produk sesuai dengan keyword pencarian
            const matchSearch = productName.includes(keyword) || productDesc.includes(keyword);

            // Tampilkan produk jika sesuai dengan kategori dan keyword
            if (matchCategory && matchSearch) {
                product.style.display = '';
            } else {
                product.style.display = 'none';
            }
        });
    }

    // Tambahkan debounce untuk mengurangi frekuensi pencarian
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    // Gunakan debounce pada fungsi pencarian
    const debouncedSearch = debounce(searchProducts, 300);

    // Update fungsi filterProducts untuk mempertahankan hasil pencarian
    function filterProducts(categoryId) {
        // Update active state pada kategori
        document.querySelectorAll('.category-filter').forEach(el => {
            el.classList.remove('border', 'border-success', 'border-2');
            el.classList.add('border', 'border-white', 'border-2');
        });
        document.querySelectorAll('.category-text').forEach(el => {
            el.classList.remove('text-success');
            el.classList.add('text-dark');
        });

        // Aktifkan kategori yang dipilih
        const selectedFilter = document.querySelector(`.category-filter[data-category="${categoryId}"]`);
        const selectedText = document.querySelector(`.category-text[data-category="${categoryId}"]`);
        if (selectedFilter) {
            selectedFilter.classList.remove('border-white');
            selectedFilter.classList.add('border', 'border-success', 'border-2');
        }
        if (selectedText) {
            selectedText.classList.remove('text-dark');
            selectedText.classList.add('text-success');
        }

        // Update nama kategori
        const categoryName = categoryId === 'all' ? 'Semua Kategori' : selectedText.textContent;
        document.getElementById('categoryName').textContent = categoryName;

        // Filter produk
        const products = document.querySelectorAll('.product-item');
        products.forEach(product => {
            if (categoryId === 'all' || product.dataset.category === categoryId) {
                product.style.display = '';
            } else {
                product.style.display = 'none';
            }
        });

        // Jalankan pencarian ulang dengan keyword yang ada
        const keyword = document.getElementById('searchInput').value;
        searchProducts(keyword);

        // Update banner sesuai kategori
        const categories = @json($categories->keyBy('id'));
        const banners = @json($banners->keyBy('id'));
        const banner = document.getElementById('categoryBanner');

        if (categoryId === 'all') {
            banner.src = @json($banners->first()->image);
        } else {
            const selectedCategory = categories[categoryId];
            if (selectedCategory && selectedCategory.banner) {
                banner.src = selectedCategory.banner;
            } else {
                banner.src = @json($banners->first()->image);
            }
        }
    }

    // Set kategori default saat halaman dimuat
    document.addEventListener('DOMContentLoaded', () => {
        filterProducts('all');
    });

    function showHomeAlert(message, type = 'success') {
        const existingAlert = document.querySelector('.home-alert');
        if (existingAlert) {
            existingAlert.remove();
        }

        const alertDiv = document.createElement('div');
        alertDiv.className = 'home-alert';

        const contentDiv = document.createElement('div');
        contentDiv.className = 'home-alert-content';

        const iconSpan = document.createElement('span');
        iconSpan.className = 'home-alert-icon bi ' + (type === 'success' ? 'bi-check-circle' : 'bi-exclamation-circle');

        const messageSpan = document.createElement('span');
        messageSpan.className = 'home-alert-message';
        messageSpan.textContent = message;

        const closeButton = document.createElement('span');
        closeButton.className = 'home-alert-close';
        closeButton.innerHTML = '&times;';
        closeButton.onclick = () => alertDiv.remove();

        contentDiv.appendChild(iconSpan);
        contentDiv.appendChild(messageSpan);
        alertDiv.appendChild(contentDiv);
        alertDiv.appendChild(closeButton);

        document.body.appendChild(alertDiv);

        setTimeout(() => {
            alertDiv.classList.add('show');
        }, 100);

        setTimeout(() => {
            alertDiv.classList.remove('show');
            setTimeout(() => {
                alertDiv.remove();
            }, 300);
        }, 3000);
    }
</script>
@endsection
