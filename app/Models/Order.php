<?php

namespace App\Models;

use App\OrderStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'user_id',
        'phone_number',
        'address',
        'total',
    ];

    protected $casts = [
        'status' => OrderStatus::class
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'orders_products','order_id','product_id')->withPivot(['price', 'qty']);
    }

    public function users()
    {
        return $this->belongsTo(User::class,'user_id', 'id');
    }
}
