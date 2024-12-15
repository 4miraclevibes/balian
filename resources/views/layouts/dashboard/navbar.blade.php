        <!-- Menu -->

        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
            <div class="app-brand demo d-flex justify-content-center align-items-center">
              <a href="{{ route('home') }}" class="app-brand-link">
                <span class="app-brand-logo demo">
                  <img src="{{ asset('assets/landing/images/logo-navbar.png') }}" style="max-width: 200px; height: auto;" alt="Logo">
                </span>
              </a>
  
              <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none position-absolute" style="top: 1rem; right: 1rem;">
                <i class="bx bx-chevron-left bx-sm align-middle"></i>
              </a>
            </div>
  
            <div class="menu-inner-shadow"></div>
  
            <ul class="menu-inner py-1 mt-3">
              {{-- Dashboard --}}
              <li class="menu-item {{ Route::is('dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}" class="menu-link">
                  <i class="menu-icon tf-icons bx bxs-home"></i>
                  <div data-i18n="Analytics">Dashboard</div>
                </a>
              </li>
              {{-- Users --}}
              <li class="menu-item {{ Route::is('dashboard.user*') ? 'active' : '' }}">
                <a href="{{ route('dashboard.user.index') }}" class="menu-link">
                  <i class="menu-icon tf-icons bx bxs-user"></i>
                  <div data-i18n="Analytics">Users</div>
                </a>
              </li>
              {{-- Categories --}}
              <li class="menu-item {{ Route::is('dashboard.category*') ? 'active' : '' }}">
                <a href="{{ route('dashboard.category.index') }}" class="menu-link">
                  <i class="menu-icon tf-icons bx bxs-category"></i>
                  <div data-i18n="Analytics">Categories</div>
                </a>
              </li>
              {{-- Products --}}
              <li class="menu-item {{ Route::is('dashboard.product*') ? 'active' : '' }}">
                <a href="{{ route('dashboard.product.index') }}" class="menu-link">
                  <i class="menu-icon tf-icons bx bxs-package"></i>
                  <div data-i18n="Analytics">Products</div>
                </a>
              </li>
              {{-- Transactions --}}
              <li class="menu-item {{ Route::is('dashboard.transaction.index', 'dashboard.transaction.show') ? 'active' : '' }}">
                <a href="{{ route('dashboard.transaction.index') }}" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-money"></i>
                  <div data-i18n="Analytics">Transactions</div>
                </a>
              </li>
              {{-- Deliveries --}}
              <li class="menu-item {{ Route::is('dashboard.transaction.deliveries') ? 'active' : '' }}">
                <a href="{{ route('dashboard.transaction.deliveries') }}" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-dollar"></i>
                  <div data-i18n="Analytics">Deliveries</div>
                </a>
              </li>
              {{-- Districts --}}
              <li class="menu-item {{ Route::is('dashboard.district*') ? 'active' : '' }}">
                <a href="{{ route('dashboard.district.index') }}" class="menu-link">
                  <i class="menu-icon tf-icons bx bxs-map"></i>
                  <div data-i18n="Analytics">Districts</div>
                </a>
              </li>
              {{-- Banners --}}
              <li class="menu-item {{ Route::is('dashboard.banner*') ? 'active' : '' }}">
                <a href="{{ route('dashboard.banner.index') }}" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-image"></i>
                  <div data-i18n="Analytics">Banners</div>
                </a>
              </li>
              {{-- Assets --}}
              <li class="menu-item {{ Route::is('dashboard.asset*') ? 'active' : '' }}">
                <a href="{{ route('dashboard.asset.index') }}" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-image"></i>
                  <div data-i18n="Analytics">Assets</div>
                </a>
              </li>
              {{-- FAQ --}}
              <li class="menu-item {{ Route::is('dashboard.faq*') ? 'active' : '' }}">
                <a href="{{ route('dashboard.faq.index') }}" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-help-circle"></i>
                  <div data-i18n="Analytics">FAQ</div>
                </a>
              </li>
            </ul>
          </aside>
          <!-- / Menu -->

@push('styles')
<style>
  .app-brand.demo {
    height: 80px; /* Sesuaikan dengan kebutuhan */
    overflow: hidden;
  }
  .app-brand-logo.demo img {
    object-fit: contain;
    max-height: 100%;
  }
</style>
@endpush