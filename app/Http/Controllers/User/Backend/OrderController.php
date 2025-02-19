<?php

namespace App\Http\Controllers\User\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'address' => 'required|max:255',
            'phone_number' => 'required|max:255',
            'total' => 'required',
            'product' => 'required|max:255',
        ]);
        $orderData = Arr::only($data, ['name', 'address', 'phone_number', 'total']);
        $products = Arr::only($data,'product');
        DB::beginTransaction();
        try {
            $order = Order::create([
                ...$orderData
            ]);
            $order->products()->sync($products['product']);
            DB::commit();
            return response()->json([],200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json($th, 500);
        }
    }
}
