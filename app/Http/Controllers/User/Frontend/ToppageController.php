<?php

namespace App\Http\Controllers\User\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use PDO;

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
            'product' => new ProductResource($product->load('comments'))
        ]);
    }

    public function showCart()
    {
        return inertia('User/Cart/Index');
    }

    public function apiGetProductData(Product $product)
    {
        return response()->json(new ProductResource($product->load('comments')), 200);
    }

    public function search(Request $request)
    {
        if($request->search == ''){
            return response()->json([], 200);
        }
        $product = Product::whereLike('name', "%$request->search%")->get();
        return response()->json(ProductResource::collection($product), 200);
    }
}
