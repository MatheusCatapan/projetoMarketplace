<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserOrder extends Model
{
    use HasFactory;

    protected $table = 'user_order';

    protected $fillable = [
        'id',
        'user_id',
        'addressId',
        'orderDate',
        'couponId',
        'totalPrice',
    ];
}
