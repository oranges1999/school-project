<?php

namespace App\Http\Controllers\Admin\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index ()
    {
        return inertia('Admin/Order/Index', [
            'orders' => Order
        ]);
    }
}
