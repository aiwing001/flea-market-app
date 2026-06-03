<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Http\Requests\SellRequest;
use Illuminate\Support\Facades\Auth;

class SellController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        return view('sell', compact('categories'));
    }

    public function store(SellRequest $request)
    {
        $imagePath = $request->file('image')->store('products','public');

        $product = Product::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'brand' => $request->brand,
            'price' => $request->price,
            'description' => $request->description,
            'condition' => $request->condition,
            'status' => 1,
            'image' => 'storage/' . $imagePath,
        ]);

        $product->categories()->attach($request->categories);

        return redirect('/');
    }
}
