<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class ShippingMethod extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'cost', 'description'];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
