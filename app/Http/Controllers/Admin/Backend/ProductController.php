<?php

namespace App\Http\Controllers\Admin\Backend;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getData()
    {
        $product = Product::orderBy('created_at','desc')->get();
        return response()->json(ProductResource::collection($product),200);
    }

    public function store(Request $request)
    {
        
        $product = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'price' => 'required|integer',
            'category_id' => 'required|integer',
            'stock' => 'integer|required',
            'image' => 'required',
            'status' => 'integer|required'
        ]);
        $now = date(now());
        $now = str_replace(
            ' ',
            '-',
            str_replace(
                ':',
                '',
                str_replace(
                    '-',
                    '',
                    $now
                )
            )
        );
        $random = rand(1,9999).$now;
        $path = $request->file('image')->storeAs(
            'product-image', $product['name'].'-'.$random.'.'.$request->file('image')->getClientOriginalExtension()
        );
        $product['image'] = $path;
        if(Product::create($product)){
            return response()->json([],200);
        } else {
            return response()->json([],400);
        }
 
    }

    public function destroy(Request $request)
    {
        Product::where('id',$request->input('id'))->delete();
        return response()->json([],200);
    }
}
