<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Coupon extends Model
{
    use HasFactory;

    protected $table = 'coupon';

    protected $fillable = [
        'id',
        'coupon_code',
        'startDate',
        'endDate',
        'discount',
    ];
}
