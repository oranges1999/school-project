<?php

namespace App\Http\Controllers\Admin\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        return inertia('Admin/Category/Index',[
            'categories' => Category::orderBy('created_at', 'desc')->get()
        ]);
    }

    public function create()
    {
        return inertia('Admin/Category/Create');
    }
}
