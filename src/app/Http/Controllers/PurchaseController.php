<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Address;
use App\Models\Order;
use App\Http\Requests\PurchaseRequest;
use App\Http\Requests\AddressRequest;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function index($item_id)
    {
        $item = Product::findOrFail($item_id);

        $address = Address::where('user_id', Auth::id())->first();

        return view('purchase', compact('item', 'address'));
    }

    public function address($item_id)
    {
        return view('address', compact('item_id'));
    }

    public function store(PurchaseRequest $request,$item_id)
    {
        $item = Product::findOrFail($item_id);

        Stripe::setApiKey(config('services.stripe.secret'));

        $paymentMethod = $request->payment_method;

        $session = Session::create([
            'payment_method_types' => [$paymentMethod],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => [
                        'name' => $item->name,
                    ],
                    'unit_amount' => $item->price,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => url('/purchase/success/' . $item->id . '?payment_method=' . $paymentMethod),
            'cancel_url' => url('/item/' . $item->id),
        ]);

        return redirect($session->url);
    }

    public function updateAddress(AddressRequest $request, $item_id)
    {
        Address::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'postal_code' => $request->postal_code,
                'address' => $request->address,
                'building' => $request->building,
            ]
        );

        return redirect('/item/' . $item_id . '/purchase');
        
    }

    public function success(Request $request, $item_id)
    {
        $item = Product::findOrFail($item_id);

        $address = Address::where('user_id', Auth::id())->first();

        if (!$address) {
            $address = Address::create([
                'user_id' => Auth::id(),
                'postal_code' => Auth::user()->postal_code,
                'address' => Auth::user()->address,
                'building' => Auth::user()->building,
            ]);
        }

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
}
