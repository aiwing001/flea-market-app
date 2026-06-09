<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Order;
use App\Http\Requests\ProfileRequest;

class ProfileController extends Controller
{
    public function profile()
    {
        return view('profile');
    }

    public function update(ProfileRequest $request)
    {
        $user = Auth::user();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('profile_images', 'public');
            $user->image_url = $path;
        }

        $user->name = $request->name;
        $user->postal_code = $request->postal_code;
        $user->address = $request->address;
        $user->building = $request->building;
        $user->save();

        return redirect('/');
    }

    public function mypage(Request $request)
    {
        $page = $request->query('page', 'sell');

        if ($page === 'buy') {
            $items = Order::where('user_id', Auth::id())
                ->with('product')
                ->get()
                ->pluck('product');
        } else {
            $items = Product::where('user_id', Auth::id())->get();
        }

        return view('mypage', compact('page', 'items'));
    }
}
