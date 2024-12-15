<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockDetail extends Model
{
    use HasFactory;
    protected $fillable = ['variant_stock_id', 'capital_price', 'price', 'status'];

    public function variantStock()
    {
        return $this->belongsTo(VariantStock::class);
    }
}
