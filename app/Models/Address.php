<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Address extends Model
{
    use HasFactory;

    protected $table = 'address';

    protected $fillable = [
        'id',
        'user_id',
        'street',
        'city',
        'state',
        'zip',
        'timestamp'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
