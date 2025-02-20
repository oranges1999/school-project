<?php

namespace App\Http\Controllers\User\Backend;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Product $product, Request $request)
    {
        $user = Auth::guard('web')->user();
        $data = $request->validate([
            'content' => 'required|max:255',
        ]);
        $comment = Comment::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'content' => $data['content'],
        ]);
        return response()->json($comment, 200);
    }

    public function destroy(Comment $comment)
    {
        if($comment->user_id !== Auth::guard('web')->user()->id){
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $comment->delete();
        return response()->json([], 200);
    }
}
