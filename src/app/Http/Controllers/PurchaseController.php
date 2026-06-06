<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Address;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function index($item_id)
    {
        $item = Product::find($item_id);

        return view('purchase', compact('item'));
    }

    public function address($item_id)
    {
        return view('address', compact('item_id'));
    }

    public function store(Request $request,$item_id)
    {
        $item = Product::findOrFail($item_id);

        $address = Address::create([
            'user_id' => Auth::id(),
            'postal_code' => Auth::user()->postal_code,
            'address' => Auth::user()->address,
            'building' => Auth::user()->building,
        ]);

        Order::create([
            'user_id' => Auth::id(),
            'product_id' => $item->id,
            'address_id' => $address->id,
            'total_price' => $item->price,
            'payment_method' => $request->payment_method,
            'status' => 1,
            'ordered_at' => now(),
        ]);

        $item->update([
            'status' => 2,
        ]);

        return redirect('/');
    }

    public function updateAddress(Request $request, $item_id)
    {

    }
}
