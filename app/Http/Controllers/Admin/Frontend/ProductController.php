<?php

namespace App\Http\Controllers\Admin\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return inertia('Admin/Products/Index');
    }

    public function create()
    {
        return inertia('Admin/Products/Create');
    }
}
