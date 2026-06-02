<?php

namespace App\Http\Controllers;

use App\Models\Product;
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
        //
    }

    public function updateAddress(Request $request, $item_id)
    {

    }
}
