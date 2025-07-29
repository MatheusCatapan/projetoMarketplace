<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'stock',
        'price',
        'image'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // public function cart()
    // {
    //     return $this->hasMany(Cart::class);
    // }

}
