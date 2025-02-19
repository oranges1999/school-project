<?php

namespace App\Http\Controllers\User\BackEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $order = $request->validate([
            'name' => 'required|max:255',
            'address' => 'required|max:255',
            'phone_number' => 'required|max:255',
            'product' => 'required|max:255',
        ]);

        dd($order);
    }
}
