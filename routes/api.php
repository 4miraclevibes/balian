<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\LandingController;
use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\TransactionController;
use App\Http\Controllers\API\PaymentController;
use App\Http\Controllers\API\UserAddressController;
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/home', [LandingController::class, 'home']);
Route::get('/product-detail/{slug}', [LandingController::class, 'productDetail']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/register', [UserController::class, 'register']);
Route::post('/payment/{code}', [PaymentController::class, 'updatePayment']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart', [CartController::class, 'store']);
    Route::delete('/cart', [CartController::class, 'destroy']);
    Route::get('/user', [UserController::class, 'userDetail']);
    Route::put('/user', [UserController::class, 'update']);
    Route::post('/logout', [UserController::class, 'logout']);
    Route::get('/user-address', [UserAddressController::class, 'index']);
    Route::get('/user-address/{id}', [UserAddressController::class, 'show']);
    Route::post('/user-address', [UserAddressController::class, 'store']);
    Route::put('/user-address/{id}', [UserAddressController::class, 'update']);
    Route::delete('/user-address/{id}', [UserAddressController::class, 'destroy']);
    //Get Districts
    Route::get('/districts', [UserAddressController::class, 'getDistricts']);
});

Route::middleware('auth:sanctum')->group(function () {
    // Transaction routes
    Route::prefix('transactions')->group(function () {
        Route::get('/', [TransactionController::class, 'index']);
        Route::post('/', [TransactionController::class, 'store']);
        Route::put('/{transaction}/status', [TransactionController::class, 'updateStatus']);
        Route::post('/{transaction}/mark-as-done', [TransactionController::class, 'markAsDone']);
        Route::get('/{transaction}/pay', [TransactionController::class, 'pay']);
    });
});

