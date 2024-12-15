<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function index()
    {
        try {
            $carts = Cart::with('variant.product')->where('user_id', Auth::user()->id)->get();
            if($carts->isEmpty() || Auth::user()->userAddress->where('status', 'active')->first() == null){
                $shipping_price = 0;
                $app_fee = 0;
            }else{
                $shipping_price = Auth::user()->userAddress->where('status', 'active')->first()->subDistrict->fee;
                $app_fee = 0;
            }
            
            return response()->json([
                'code' => 200,
                'status' => 'success',
                'message' => 'Cart data retrieved successfully',
                'data' => [
                    'carts' => $carts,
                    'shipping_price' => $shipping_price,
                    'app_fee' => $app_fee
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'status' => 'error',
                'message' => 'An error occurred while retrieving cart data',
                'error' => 'Error pada CartController: ' . $e->getMessage() . ' (File: ' . $e->getFile() . ', Baris: ' . $e->getLine() . ')'
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            Log::info('Received cart data:', $request->all());
            if(Auth::user()->userAddress->where('status', 'active')->first() == null){
                return response()->json([
                    'code' => 400,
                    'status' => 'error',
                    'message' => 'User tidak memiliki alamat'
                ], 400);
            }
            $validator = Validator::make($request->all(), [
                'variant_id' => 'required|exists:product_variants,id',
                'quantity' => 'required|numeric|min:1',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'code' => 422,
                    'status' => 'error',
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            if (Auth::user()->role->name == 'driver') {
                return response()->json([
                    'code' => 403,
                    'status' => 'error',
                    'message' => 'Driver tidak dapat menambahkan produk ke keranjang'
                ], 403);
            }

            $userId = Auth::user()->id;
            $variant = ProductVariant::findOrFail($request->variant_id);
            if ($request->quantity > $variant->getAvailableStockCount()) {
                return response()->json([
                    'code' => 400,
                    'status' => 'error',
                    'message' => 'Jumlah yang dipilih melebihi stok yang tersedia'
                ], 400);
            }

            $existingCart = Cart::where('user_id', $userId)
                                ->where('variant_id', $request->variant_id)
                                ->first();

            if ($existingCart) {
                $existingCart->quantity += $request->quantity;
                $existingCart->save();
            } else {
                Cart::create([
                    'variant_id' => $request->variant_id,
                    'quantity' => $request->quantity,
                    'user_id' => $userId,
                ]);
            }

            return response()->json([
                'code' => 200,
                'status' => 'success',
                'message' => 'Produk berhasil ditambahkan ke keranjang'
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error in CartController@store: ' . $e->getMessage(), [
                'request' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'code' => 500,
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menambahkan produk ke keranjang',
                'error' => $e->getMessage() . ' (File: ' . $e->getFile() . ', Baris: ' . $e->getLine() . ')'
            ], 500);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $items = $request->input('items', []);
            
            if (empty($items)) {
                return response()->json([
                    'code' => 400,
                    'status' => 'error',
                    'message' => 'Tidak ada item yang dipilih untuk dihapus'
                ], 400);
            }

            $deletedCount = Cart::whereIn('id', $items)->where('user_id', Auth::user()->id)->delete();

            return response()->json([
                'code' => 200,
                'status' => 'success',
                'message' => $deletedCount . ' item telah dihapus dari keranjang'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'status' => 'error',
                'message' => 'An error occurred while removing items from cart',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
