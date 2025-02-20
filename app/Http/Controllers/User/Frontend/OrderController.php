<?php

namespace App\Http\Controllers\User\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
{
        $orders = Order::where('user_id', Auth::guard('web')->user()->id)
            ->with('products')
            ->get();
        return inertia('User/Order/Index',[
            'orders' => $orders
        ]);
    }

    public function show(Order $order)
    {
        $order = new OrderResource(
            Order::where('id', $order->id)
                ->with('products')
                ->with('users')
                ->first()
        );
        return inertia('User/Order/Show',[
            'order' => $order
        ]);
    }
}
