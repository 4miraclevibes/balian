<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubDistrict extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'district_id',
        'fee',
        'description',
        'status',
    ];

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function userAddress()
    {
        return $this->hasMany(UserAddress::class);
    }

    public function transaction()
    {
        return $this->hasMany(Transaction::class);
    }
}
