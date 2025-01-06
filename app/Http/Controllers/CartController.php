<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Cart;
use App\Models\ProductVariant;
use App\Models\ShippingMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $carts = Cart::with('variant.product')->where('user_id', Auth::user()->id)->get();
        $shippingMethods = ShippingMethod::all();
        $assets = Asset::where('is_active', true)->get();
        if($carts->isEmpty() || Auth::user()->userAddress->where('status', 'active')->first() == null){
            $shipping_price = 0;
            $app_fee = 0;
        }else{
            $shipping_price = Auth::user()->userAddress->where('status', 'active')->first()->subDistrict->fee;
            $app_fee = 0;
        }
        if ($carts->isEmpty()) {
            return view('pages.landing.cartEmpty', compact('assets'));
        }
        if (Auth::user()->role->name == 'driver') {
            return view('pages.landing.home', compact('assets'));
        }
        return view('pages.landing.cart', compact('carts', 'shippingMethods', 'shipping_price', 'app_fee', 'assets'));
    }

    public function store(Request $request)
    {
        if (Auth::user()->role->name == 'driver') {
            if ($request->ajax()) {
                return response()->json(['error' => 'Driver tidak dapat menambahkan produk ke keranjang']);
            }
            return back()->with('error', 'Driver tidak dapat menambahkan produk ke keranjang');
        }

        if(Auth::user()->userAddress->where('status', 'active')->first() == null){
            if ($request->ajax()) {
                return response()->json(['redirect' => route('user.addresses.add'),
                                      'message' => 'Tambahkan alamat terlebih dahulu']);
            }
            return redirect()->route('user.addresses.add')->with('success', 'Tambahkan alamat terlebih dahulu');
        }

        $request->validate([
            'variant_id' => 'required',
            'quantity' => 'required|numeric|min:1',
        ]);

        $userId = Auth::user()->id;
        $variant = ProductVariant::find($request->variant_id);

        if ($request->quantity > $variant->getAvailableStockCount()) {
            if ($request->ajax()) {
                return response()->json(['error' => 'Jumlah yang dipilih melebihi stok yang tersedia']);
            }
            return back()->with('error', 'Jumlah yang dipilih melebihi stok yang tersedia');
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

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil ditambahkan ke keranjang',
                'count' => Auth::user()->carts->count()
            ]);
        }

        return redirect()->route('home')->with('success', 'Produk berhasil ditambahkan ke keranjang');
    }

    public function destroy(Request $request)
    {
        $items = $request->input('items', []);

        if (empty($items)) {
            return back()->with('error', 'Tidak ada item yang dipilih untuk dihapus');
        }

        Cart::whereIn('id', $items)->where('user_id', Auth::user()->id)->delete();

        return back()->with('success', 'Item yang dipilih telah dihapus dari keranjang');
    }

    public function cartSuccess()
    {
        $assets = Asset::where('is_active', true)->get();
        return view('pages.landing.cartSuccess', compact('assets'));
    }
}
