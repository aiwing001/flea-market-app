<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Like;
use App\Models\Category;


class ItemController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'recommend');
        $keyword = $request->query('keyword');

        $items = Product::query()
            ->when($tab === 'mylist' && Auth::check(), function ($query) {
                $query->whereHas('likes', function ($query) {
                    $query->where('user_id', Auth::id());
                });
            })
            ->when($keyword, function ($query, $keyword) {
                $query->where('name', 'like', "%{$keyword}%");
            })
            ->get();

        return view('index', compact('items', 'tab'));
    }

    public function item($item_id)
    {
        $item = Product::with(['likes', 'categories', 'comments.user'])->findOrFail($item_id);

        $isLiked = false;

        if (Auth::check()) {
            $isLiked = Like::where('user_id', Auth::id())
                ->where('product_id', $item->id)
                ->exists();
        }

        return view('item', compact('item', 'isLiked'));
    }
}