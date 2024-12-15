<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\TransactionController as DashboardTransactionController;
use App\Http\Controllers\Dashboard\PaymentController as DashboardPaymentController;
use App\Http\Controllers\Dashboard\DistrictController;
use App\Http\Controllers\Dashboard\BannerController;
use App\Http\Controllers\Dashboard\AssetController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\UserAddressController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SSOController;
use App\Http\Controllers\Landing\AuthController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\Dashboard\FaqController;
use Illuminate\Support\Facades\Route;

Route::get('/privacy-policy', function () {
    return view('privacyPolicy');
})->name('privacy.policy');

Route::get('/', [LandingController::class, 'home'])->name('home');
Route::get('/product/{slug}', [LandingController::class, 'productDetail'])->name('product.detail');
Route::get('/landing/login', [AuthController::class, 'login'])->middleware('guest')->name('landing.auth.login');
Route::get('/landing/register', [AuthController::class, 'register'])->middleware('guest')->name('landing.auth.register');
Route::get('/landing/user-detail', [LandingController::class, 'userDetail'])->middleware('auth')->name('user.details');

Route::get('/cart', [CartController::class, 'index'])->middleware('auth')->name('cart');
Route::post('/cart/store', [CartController::class, 'store'])->middleware('auth')->name('cart.store');
Route::delete('/cart/destroy', [CartController::class, 'destroy'])->middleware('auth')->name('cart.destroy');
Route::get('/transaction', [TransactionController::class, 'index'])->middleware('auth')->name('transaction');
Route::post('/transaction/store', [TransactionController::class, 'store'])->middleware('auth')->name('transaction.store');
Route::patch('/transaction/{transaction}/mark-as-done', [TransactionController::class, 'markAsDone'])->middleware('auth')->name('transaction.markAsDone');
Route::get('/transaction/{transaction}/pay', [TransactionController::class, 'pay'])->middleware('auth')->name('transaction.pay');
Route::patch('/transaction/{transaction}/updateStatus', [TransactionController::class, 'updateStatus'])->middleware('auth')->name('transaction.updateStatus');
Route::get('/user/addresses', [UserAddressController::class, 'index'])->middleware('auth')->name('user.addresses');
Route::get('/user/addresses/add', [UserAddressController::class, 'create'])->middleware('auth')->name('user.addresses.add');
Route::post('/user/addresses/store', [UserAddressController::class, 'store'])->middleware('auth')->name('user.addresses.store');
Route::get('/user/addresses/{id}/edit', [UserAddressController::class, 'edit'])->middleware('auth')->name('user.addresses.edit');
Route::put('/user/addresses/{id}', [UserAddressController::class, 'update'])->middleware('auth')->name('user.addresses.update');
Route::delete('/user/addresses/destroy/{id}', [UserAddressController::class, 'destroy'])->middleware('auth')->name('user.addresses.destroy');
Route::get('/faq', [LandingController::class, 'faq'])->name('faq');

Route::get('/checkout', function () {
    return view('pages.landing.checkout');
})->name('checkout');

// Cart Success
Route::get('/cart/success', [CartController::class, 'cartSuccess'])->name('cart.success');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Dashboard
// Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');
Route::group(['prefix' => 'dashboard', 'as' => 'dashboard.', 'middleware' => ['auth', 'admin']], function () {
    // User
    Route::get('user/index', [UserController::class, 'index'])->name('user.index');
    Route::get('user/create', [UserController::class, 'create'])->name('user.create');
    Route::post('user/store', [UserController::class, 'store'])->name('user.store');
    Route::get('user/edit/{user}', [UserController::class, 'edit'])->name('user.edit');
    Route::put('user/update/{user}', [UserController::class, 'update'])->name('user.update');
    Route::delete('user/destroy/{user}', [UserController::class, 'destroy'])->name('user.destroy');
    // Category
    Route::get('category/index', [CategoryController::class, 'index'])->name('category.index');
    Route::get('category/create', [CategoryController::class, 'create'])->name('category.create');
    Route::post('category/store', [CategoryController::class, 'store'])->name('category.store');
    Route::get('category/edit/{category}', [CategoryController::class, 'edit'])->name('category.edit');
    Route::put('category/update/{category}', [CategoryController::class, 'update'])->name('category.update');
    Route::delete('category/destroy/{category}', [CategoryController::class, 'destroy'])->name('category.destroy');
    // Product
    Route::get('product/index', [ProductController::class, 'index'])->name('product.index');
    Route::get('product/create', [ProductController::class, 'create'])->name('product.create');
    Route::post('product/store', [ProductController::class, 'store'])->name('product.store');
    Route::get('product/edit/{product}', [ProductController::class, 'edit'])->name('product.edit');
    Route::put('product/update/{product}', [ProductController::class, 'update'])->name('product.update');
    Route::delete('product/destroy/{product}', [ProductController::class, 'destroy'])->name('product.destroy');
    // Product Variant
    Route::get('product/variant/index/{product}', [ProductController::class, 'productVariant'])->name('product.variant.index');
    Route::get('product/variant/create/{product}', [ProductController::class, 'productVariantCreate'])->name('product.variant.create');
    Route::post('product/variant/store/{product}', [ProductController::class, 'productVariantStore'])->name('product.variant.store');
    Route::get('product/variant/edit/{variant}', [ProductController::class, 'productVariantEdit'])->name('product.variant.edit');
    Route::put('product/variant/update/{variant}', [ProductController::class, 'productVariantUpdate'])->name('product.variant.update');
    Route::delete('product/variant/destroy/{variant}', [ProductController::class, 'productVariantDestroy'])->name('product.variant.destroy');
    // Product Variant Stock
    Route::get('product/variant/stock/index/{variant}', [ProductController::class, 'productVariantStock'])->name('product.variant.stock.index');
    Route::post('product/variant/stock/store/{variant}', [ProductController::class, 'productVariantStockStore'])->name('product.variant.stock.store');
    Route::delete('product/variant/stock/destroy/{variantStock}', [ProductController::class, 'productVariantStockDestroy'])->name('product.variant.stock.destroy');
    // Product Variant Stock Detail
    Route::get('product/variant/stock/detail/{variantStock}', [ProductController::class, 'productVariantStockDetail'])->name('product.variant.stock.detail');
    // Product Image
    Route::get('product/image/index/{product}', [ProductController::class, 'productImage'])->name('product.image.index');
    Route::post('product/image/store/{product}', [ProductController::class, 'productImageStore'])->name('product.image.store');
    Route::delete('product/image/destroy/{productImage}', [ProductController::class, 'productImageDestroy'])->name('product.image.destroy');
    // Transaction
    Route::get('transaction/index', [DashboardTransactionController::class, 'index'])->name('transaction.index');
    Route::patch('transaction/updateStatus/{transaction}', [DashboardTransactionController::class, 'updateStatus'])->name('transaction.updateStatus');
    Route::get('transaction/show/{transaction}', [DashboardTransactionController::class, 'show'])->name('transaction.show');
    Route::get('transaction/fresh', [DashboardTransactionController::class, 'fresh'])->name('transaction.fresh');
    Route::patch('transaction/{transaction}/additional-cost', [TransactionController::class, 'updateAdditionalCost'])->name('transaction.updateAdditionalCost');
    // Deliveries
    Route::get('transaction/deliveries', [DashboardTransactionController::class, 'deliveries'])->name('transaction.deliveries');
    // Payment
    Route::post('payment/store/{transaction}', [DashboardPaymentController::class, 'store'])->name('payment.store');
    // District dan SubDistrict
    Route::get('/districts', [DistrictController::class, 'index'])->name('district.index');
    Route::post('/districts', [DistrictController::class, 'store'])->name('district.store');
    Route::delete('/districts/{district}', [DistrictController::class, 'destroy'])->name('district.destroy');
    Route::post('/subdistricts', [DistrictController::class, 'storeSubDistrict'])->name('subdistrict.store');
    Route::delete('/subdistricts/{subdistrict}', [DistrictController::class, 'destroySubDistrict'])->name('subdistrict.destroy');
    Route::post('/districts/update-fee-all', [DistrictController::class, 'updateFeeAll'])->name('district.updateFeeAll');
    Route::put('/districts/{district}', [DistrictController::class, 'update'])->name('district.update');
    Route::put('/subdistricts/{subdistrict}', [DistrictController::class, 'updateSubDistrict'])->name('subdistrict.update');
    // Banner
    Route::get('banner/index', [BannerController::class, 'index'])->name('banner.index');
    Route::post('banner/store', [BannerController::class, 'store'])->name('banner.store');
    Route::delete('banner/destroy/{banner}', [BannerController::class, 'destroy'])->name('banner.destroy');
    Route::put('banner/update/{banner}', [BannerController::class, 'update'])->name('banner.update');
    // Asset
    Route::get('asset/index', [AssetController::class, 'index'])->name('asset.index');
    Route::post('asset/store', [AssetController::class, 'store'])->name('asset.store');
    Route::delete('asset/destroy/{asset}', [AssetController::class, 'destroy'])->name('asset.destroy');
    Route::put('asset/update/{asset}', [AssetController::class, 'update'])->name('asset.update');
    // FAQ Routes
    Route::get('faq/index', [FaqController::class, 'index'])->name('faq.index');
    Route::post('faq/store', [FaqController::class, 'store'])->name('faq.store');
    Route::put('faq/update/{faq}', [FaqController::class, 'update'])->name('faq.update');
    Route::delete('faq/destroy/{faq}', [FaqController::class, 'destroy'])->name('faq.destroy');
});

Route::get('/dashboard', [SSOController::class, 'dashboard'])->middleware(['login', 'auth', 'admin'])->name('dashboard');
Route::post('/dashboard/send-whatsapp-notification', [DashboardController::class, 'sendWhatsappNotification'])->name('dashboard.send-whatsapp-notification');
// Route untuk melakukan login dengan SSO
Route::post('/login/sso', [SSOController::class, 'login'])->name('login.sso');
Route::get('/login/sso', [SSOController::class, 'loginView'])->name('login.sso.view');
// Route untuk mendapatkan data pengguna dari SSO
Route::get('/user', [SSOController::class, 'getUser'])->name('user');
// Route untuk melakukan logout dengan SSO
Route::post('/logout/sso', [SSOController::class, 'logout'])->name('logout.sso');

Route::get('/refresh-csrf', function() {
    return csrf_token();
});


require __DIR__.'/auth.php';
