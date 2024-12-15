<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\VariantStock;
use Illuminate\Http\Request;
use App\Http\Controllers\Service\ServiceController;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    protected $serviceController;

    public function __construct(ServiceController $serviceController)
    {
        $this->serviceController = $serviceController;
    }

    public function priceCalculation($price)
    {
        $appFee = 0.2;
        $profit = 0.3;
        $packingPrice = 500;
        $totalPercentage = $appFee + $profit;
        $adjustment = $totalPercentage * $price;
        return $price + $adjustment + $packingPrice;
    }

    public function priceCalculationReverse($price)
    {
        $appFee = 0.2;
        $profit = 0.3;
        $packingPrice = 500;
        $totalPercentage = $appFee + $profit;
        
        $priceWithoutPacking = $price - $packingPrice;
        $price = $priceWithoutPacking / (1 + $totalPercentage);
        return $price;
    }

    public function index()
    {
        $products = Product::with('category', 'variants', 'images')->get();
        return view('pages.dashboard.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('pages.dashboard.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        if($request->is_sayur) {
            $price = $this->priceCalculation($request->price);
            $isSayur = true;
        } else {
            $price = $request->sell_price;
            $isSayur = false;
        }
        if ($request->hasFile('thumbnail')) {
            $thumbnailUrl = $this->serviceController->uploadImage($request->file('thumbnail'));
            
            $product = Product::create([
                ...$request->except('thumbnail'),
                'thumbnail' => $thumbnailUrl
            ]);
        } else {
            $product = Product::create($request->except('thumbnail'));
        }

        // Buat variant default
        $product->variants()->create([
            'name' => 'default',
            'price' => $price,
            'is_visible' => true,
            'is_sayur' => $isSayur,
        ]);

        return redirect()->route('dashboard.product.index');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('pages.dashboard.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        if ($request->hasFile('thumbnail')) {
            $thumbnailUrl = $this->serviceController->uploadImage($request->file('thumbnail'));
            
            $product->update([
                ...$request->except('thumbnail'),
                'thumbnail' => $thumbnailUrl
            ]);
        } else {
            $product->update($request->except('thumbnail'));
        }

        return redirect()->route('dashboard.product.index');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('dashboard.product.index');
    }

    public function productImage(Product $product)
    {
        return view('pages.dashboard.products.images.index', compact('product'));
    }

    public function productImageStore(Product $product, Request $request)
    {
        $product->images()->create($request->all());
        return redirect()->route('dashboard.product.image.index', $product->id);
    }

    public function productImageDestroy(ProductImage $productImage)
    {
        $productImage->delete();
        return redirect()->route('dashboard.product.image.index', $productImage->product_id);
    }

    public function productVariant(Product $product)
    {
        return view('pages.dashboard.products.variants.index', compact('product'));
    }

    public function productVariantCreate(Product $product)
    {
        return view('pages.dashboard.products.variants.create', compact('product'));
    }

    public function productVariantStore(Product $product, Request $request)
    {
        if($request->is_sayur) {
            $price = $this->priceCalculation($request->price);
            $isSayur = true;
        } else {
            $price = $request->sell_price;
            $isSayur = false;
        }
        $product->variants()->create([
            'name' => $request->name,
            'price' => $price,
            'is_sayur' => $isSayur,
            'is_visible' => 0,
        ]);
        return redirect()->route('dashboard.product.variant.index', $product->id);
    }

    public function productVariantEdit(ProductVariant $variant)
    {
        if($variant->is_sayur) {
            $price = $this->priceCalculationReverse($variant->price);
        } else {
            $price = $variant->price;
        }
        return view('pages.dashboard.products.variants.edit', compact('variant', 'price'));
    }

    public function productVariantUpdate(Request $request, ProductVariant $variant)
    {
        if($request->is_sayur) {
            $price = $this->priceCalculation($request->price);
            $isSayur = true;
        } else {
            $price = $request->sell_price;
            $isSayur = false;
        }
        $variant->update([
            ...$request->except('price'),
            'price' => $price,
            'is_sayur' => $isSayur,
        ]);
        return redirect()->route('dashboard.product.variant.index', $variant->product_id);
    }

    public function productVariantDestroy(ProductVariant $variant)
    {
        $variant->delete();
        return redirect()->route('dashboard.product.variant.index', $variant->product_id);
    }

    public function productVariantStock(ProductVariant $variant)
    {
        return view('pages.dashboard.products.variants.stock.index', compact('variant'));
    }

    public function productVariantStockStore(ProductVariant $variant, Request $request)
    {
        try {
            DB::beginTransaction();
            
            $capitalPrice = $request->capital_price;
            $price = $this->priceCalculation($capitalPrice);
            
            if($variant->is_sayur) {
                $price = $this->priceCalculation($capitalPrice);
            } else {
                $price = $variant->price;
            }   
            $variant->update([
                'price' => $price,
            ]);
            
            $variantStocks = $variant->variantStocks()->create([
                'quantity' => $request->quantity,
                'capital_price' => $capitalPrice,
            ]);

            for ($i = 0; $i < $variantStocks->quantity; $i++) {
                $variantStocks->stockDetails()->create([
                    'variant_stock_id' => $variantStocks->id,
                    'capital_price' => $capitalPrice,
                    'price' => 0,
                    'status' => 'ready',
                ]);
            }
            
            DB::commit();
            return redirect()->back()->with('success', 'Stok berhasil ditambahkan');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function productVariantStockDestroy(VariantStock $variantStock)
    {
        $variantStock->delete();
        return redirect()->back()->with('success', 'Stok berhasil dihapus');
    }

    public function productVariantStockDetail(VariantStock $variantStock)
    {
        return view('pages.dashboard.products.variants.stock.detail', compact('variantStock'));
    }
}