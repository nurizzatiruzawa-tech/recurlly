<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = [
        'user_id', 'name', 'category', 'price',
        'billing_cycle', 'is_active', 'renewal_date',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'price' => 'float',
    ];
}