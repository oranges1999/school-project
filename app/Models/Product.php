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

    public function Categories()
    {
        return $this->belongsTo(Category::class,'category_id','id');
    }
}
