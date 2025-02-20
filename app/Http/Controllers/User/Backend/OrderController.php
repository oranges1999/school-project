<?php

namespace App\Http\Controllers\User\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::guard('web')->user();
        $data = $request->validate([
            'name' => 'required|max:255',
            'address' => 'required|max:255',
            'phone_number' => 'required|max:255',
            'total' => 'required',
            'product' => 'required|max:255',
        ]);
        $orderData = Arr::only($data, ['name', 'address', 'phone_number', 'total']);
        $products = Arr::only($data,'product');
        foreach($products['product'] as $product){
            $dbProduct = Product::find($product['id']);
            if($dbProduct->stock < $product['qty']){
                return response()->json(['message' => 'Product out of stock'], 400);
            }
        }
        DB::beginTransaction();
        try {
            $order = Order::create([
                'user_id' => $user->id,
                ...$orderData
            ]);
            
            foreach($products['product'] as $product){
                $order->products()->attach($product['id'],[
                    'qty' => $product['qty'],
                    'price' => $product['price']
                ]);
                $dbProduct = Product::find($product['id']);
                $dbProduct->stock = $dbProduct->stock - $product['qty'];
                $dbProduct->save();
            }
            DB::commit();
            return response()->json([],200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json($th, 500);
        }
    }
}
