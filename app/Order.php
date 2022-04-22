<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'product_id', 'user_id', 'quantity', 'address', 'amount', 'is_delivered'
    ];

}
