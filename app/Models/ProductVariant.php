<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class ProductVariant extends Model
{
    use HasFactory;
    protected $fillable = ['product_id', 'name', 'price', 'is_visible', 'is_sayur'];
    protected $appends = ['available_stock_count'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function variantStocks()
    {
        return $this->hasMany(VariantStock::class);
    }

    public function getAvailableStockCount()
    {
        return $this->variantStocks()
            ->withCount(['stockDetails' => function ($query) {
                $query->where('status', 'ready');
            }])
            ->get()
            ->sum('stock_details_count');
    }

    // Atribut baru
    public function availableStockCount(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->getAvailableStockCount();
            }
        );
    }

    public function getAvailableStockDetails()
    {
        return StockDetail::whereHas('variantStock', function ($query) {
            $query->where('product_variant_id', $this->id);
        })->where('status', 'ready')
          ->orderBy('created_at', 'asc')
          ->get();
    }

    public function getTotalAvailableStockAttribute()
    {
        return $this->variantStocks()
            ->withCount(['stockDetails' => function ($query) {
                $query->where('status', 'ready');
            }])
            ->get()
            ->sum('stock_details_count');
    }

    public function getCapitalPriceForQuantity($quantity)
    {
        $availableStockDetails = $this->getAvailableStockDetails()
            ->take($quantity);
        
        if ($availableStockDetails->count() < $quantity) {
            throw new \Exception("Stok tidak cukup untuk produk {$this->product->name} - {$this->name}");
        }
        
        return $availableStockDetails->sum('capital_price');
    }

    public function getTotalCapitalPrice()
    {
        return $this->variantStocks()
            ->with('stockDetails')
            ->get()
            ->sum(function ($variantStock) {
                return $variantStock->stockDetails->sum('capital_price');
            });
    }

    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class, 'variant_id');
    }
}
