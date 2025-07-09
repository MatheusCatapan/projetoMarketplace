<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UsersCarts extends Model
{
    use HasFactory;

    protected $table = 'users_carts';

    protected $fillable = [
        'id',
        'created_at',
        'user_id',
    ];
}
