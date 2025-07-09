<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UsersAddresses extends Model
{
    use HasFactory;

    protected $table = 'users_addresses';

    protected $fillable = [
        'id',
        'street',
        'number',
        'zip',
        'city',
        'state',
        'country',
        'user_id',
    ];    
}



