<?php

namespace App\Http\Controllers\Admin\Backend;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getData()
    {
        $product = Product::orderBy('created_at','desc')->get();
        return response()->json(ProductResource::collection($product),200);
    }

    public function update(Product $product, Request $request)
    {
        $updateData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'price' => 'required|integer',
            'category_id' => 'required|integer',
            'stock' => 'integer|required',
            'image' => 'required',
            'status' => 'integer|required'
        ]);
        if($request->hasFile('image')){
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
            $updateData['image'] = $path;
        }

        $product->update($updateData);
        return response()->json([],200);
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

    public function destroy(Product $product)
    {
        if(file_exists(public_path('storage/'.$product->image))){
            Storage::delete($product->image);
        }
        $product->delete();
        return response()->json([],200);
    }
}
