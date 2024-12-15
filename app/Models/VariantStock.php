<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VariantStock extends Model
{
    use HasFactory;
    protected $fillable = ['product_variant_id', 'quantity'];

    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class);
    }

    public function stockDetails()
    {
        return $this->hasMany(StockDetail::class);
    }
}
