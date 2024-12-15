<footer class="border-top">
    <div class="container">
        <div class="row py-2">
            <div class="col-3 text-center">
                <a href="{{ route('home') }}" class="text-decoration-none {{ Route::is(['home', 'product.detail']) ? 'active' : '' }}">
                    <i class="bi bi-house-door{{ Route::is(['home', 'product.detail']) ? '-fill' : '' }} fs-5 {{ Route::is(['home', 'product.detail']) ? 'text-success' : 'text-secondary' }}"></i>
                    <p class="mb-0 small {{ Route::is(['home', 'product.detail']) ? 'text-success' : 'text-secondary' }}">Beranda</p>
                </a>
            </div>
            <div class="col-3 text-center">
                <a href="{{ route('cart') }}" class="text-decoration-none position-relative @auth {{ Auth::user()->role->name == 'driver' ? 'disabled' : '' }} @endauth {{ Route::is('cart*') ? 'active' : '' }}">
                    @auth
                        @if(Auth::user()->carts->count() >= 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger cart-badge" style="font-size: 0.5rem; margin-left: -1.5rem; margin-top: -0.2rem">
                                <span class="cart-count">{{ Auth::user()->carts->count() }}</span>
                            </span>
                        @endif
                    @endauth
                    <i class="bi bi-cart{{ Route::is('cart*') ? '-fill' : '' }} fs-5 {{ Route::is('cart*') ? 'text-success' : 'text-secondary' }}"></i>
                    <p class="mb-0 small {{ Route::is('cart*') ? 'text-success' : 'text-secondary' }}">Keranjang</p>
                </a>
            </div>
            @auth
            <div class="col-3 text-center">
                <a href="{{ route('transaction') }}" class="text-decoration-none {{ Route::is('transaction') ? 'active' : '' }}">
                    <i class="bi bi-{{ Auth::user()->role->name == 'user' ? 'clipboard' : 'truck-front' }}{{ Route::is('transaction') ? '-fill' : '' }} fs-5 {{ Route::is('transaction') ? 'text-success' : 'text-secondary' }}"></i>
                    <p class="mb-0 small {{ Route::is('transaction') ? 'text-success' : 'text-secondary' }}">{{ Auth::user()->role->name == 'user' ? 'Pesanan' : 'Pengiriman' }}</p>
                </a>
            </div>
            @else
            <div class="col-3 text-center">
                <a href="{{ route('transaction') }}" class="text-decoration-none {{ Route::is('transaction') ? 'active' : '' }}">
                    <i class="bi bi-clipboard{{ Route::is('transaction') ? '-fill' : '' }} fs-5 {{ Route::is('transaction') ? 'text-success' : 'text-secondary' }}"></i>
                    <p class="mb-0 small {{ Route::is('transaction') ? 'text-success' : 'text-secondary' }}">Pesanan</p>
                </a>
            </div>
            @endauth
            <div class="col-3 text-center">
                <a href="{{ route('user.details') }}" class="text-decoration-none {{ Route::is(['user.details', 'user.addresses', 'user.addresses.edit', 'user.addresses.add']) ? 'active' : '' }}">
                    <i class="bi bi-person{{ Route::is(['user.details', 'user.addresses', 'user.addresses.edit', 'user.addresses.add']) ? '-fill' : '' }} fs-5 {{ Route::is(['user.details', 'user.addresses', 'user.addresses.edit', 'user.addresses.add']) ? 'text-success' : 'text-secondary' }}"></i>
                    <p class="mb-0 small {{ Route::is(['user.details', 'user.addresses', 'user.addresses.edit', 'user.addresses.add']) ? 'text-success' : 'text-secondary' }}">Profile</p>
                </a>
            </div>
        </div>
    </div>
</footer>
