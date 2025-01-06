<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'shipping_method_id',
        'total_price',
        'status',
        'shipping_price',
        'code',
        'app_fee',
        'address',
        'notes',
        'additional_cost',
    ];

    public function shippingMethod()
    {
        return $this->belongsTo(ShippingMethod::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}