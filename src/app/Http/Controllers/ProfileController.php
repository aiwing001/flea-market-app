<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

class ProfileController extends Controller
{
    public function profile()
    {
        return view('profile');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'image'],
        ]);

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
        $tab = $request->query('tab');

        if ($tab === 'buy') {
            $items = collect();
        } else {
            $items = Product::where('user_id', Auth::id())->get();
        }

        return view('mypage', compact('tab', 'items'));
    }
}
