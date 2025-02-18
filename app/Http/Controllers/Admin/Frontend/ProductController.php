<?php

namespace App\Http\Controllers\Admin\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return inertia('Admin/Products/Index');
    }

    public function create()
    {
        return inertia('Admin/Products/Create');
    }
    
    public function edit(Product $product)
    {
        return inertia('Admin/Products/Edit',[
            'product' => $product
        ]);
    }
}
