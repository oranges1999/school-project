<?php

namespace App\Http\Controllers\Admin\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function getData()
    {
        $categories = Category::orderBy('created_at', 'desc')->get();

        return response()->json($categories);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = Category::create($request->all());

        return response()->json($category, 201);
    }

    public function destroy(Request $request)
    {
        $category = Category::findOrFail($request->id);
        $category->delete();

        return response()->json(null, 204);
    }
}
