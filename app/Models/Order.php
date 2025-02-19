<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'phone_number',
        'address',
        'total',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'orders_products','order_id','product_id');
    }
}
