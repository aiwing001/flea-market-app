<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Product;
use App\Http\Requests\CommentRequest;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(CommentRequest $request, Product $item)
    {

        Comment::create([
            'user_id' => Auth::id(),
            'product_id' => $item->id,
            'content' => $request->content,
        ]);

        return redirect('/item/' . $item->id);
    }
}
