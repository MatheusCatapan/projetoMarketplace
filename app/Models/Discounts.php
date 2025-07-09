<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Discounts extends Model
{
    use HasFactory;

    protected $table = 'discounts';

    protected $fillable = [
        'id',
        'description',
        'startDate',
        'endDate',
        'discount',
    ];
}
