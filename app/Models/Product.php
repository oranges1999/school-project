<?php

namespace App\Models;

use App\Status;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'name',
        'price',
        'description',
        'category_id',
        'image',
        'stock',
        'status',
    ];

    protected $casts = [
        'status' => Status::class,
    ];

    public function categories()
    {
        return $this->belongsTo(Category::class,'category_id','id');
    }

    public function order()
    {
        return $this->belongsToMany(Order::class, 'orders_products', 'product_id', 'order_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
