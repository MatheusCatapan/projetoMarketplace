<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserCart extends Model
{
    use HasFactory;

    protected $table = 'user_cart';

    protected $fillable = [
        'id',
        'created_at',
        'user_id',
    ];
}
