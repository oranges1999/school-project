<?php

namespace App\Http\Controllers\User\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ToppageController extends Controller
{
    public function index()
    {
        return inertia('User/FrontPage/Index',[
            'categories' => CategoryResource::collection(Category::with('products')->get())
        ]);
    }

    public function show(Category $category)
    {
        return inertia('User/Category/Index',[
            'categories' => CategoryResource::collection(Category::with('products')->get()),
            'category' => new CategoryResource($category->load('products'))
        ]);
    }

    public function showProduct(Product $product)
    {
        return inertia('User/Product/Index',[
            'product' => new ProductResource($product)
        ]);
    }

    public function showCart()
    {
        return inertia('User/Cart/Index');
    }
}
