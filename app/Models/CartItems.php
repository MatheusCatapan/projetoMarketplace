<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItems extends Model
{
    use HasFactory;

    protected $table = 'cart_items';

    protected $fillable = [
        'id',
        'cart_id',
        'product_id',
        'quantity',
        'price',
    ];
}
