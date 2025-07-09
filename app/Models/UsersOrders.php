<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersOrders extends Model
{
    use HasFactory;

    protected $table = 'users_orders';

    protected $fillable = [
        'id',
        'user_id',
        'addressId',
        'orderDate',
        'couponId',
        'totalPrice',
    ];
}
