<?php

namespace App\Http\Controllers\Admin\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\OrderStatus;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index ()
    {
        $orders = Order::where('status', OrderStatus::PENDING->label())->get();
        return inertia('Admin/Order/Index',[
            'orders' => OrderResource::collection($orders),
        ]);
    }

    public function show (Order $order)
    {
        $order = Order::where('id', $order->id)->with('products')->first();
        return inertia('Admin/Order/Show',[
            'orders' => new OrderResource($order),
        ]);
    }
}
