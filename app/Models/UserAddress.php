<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;

    protected $table = 'user_addresses';
    protected $fillable = [
        'user_id',
        'sub_district_id',
        'address',
        'latitude',
        'longitude',
        'type',
        'receiver_name',
        'receiver_phone',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subDistrict()
    {
        return $this->belongsTo(SubDistrict::class);
    }
}
