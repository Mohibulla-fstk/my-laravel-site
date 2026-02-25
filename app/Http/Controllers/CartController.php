<?php

namespace App\Http\Controllers;

use Cart;

class CartController extends Controller
{
    public function increment($rowId)
    {
        $item = Cart::instance('shopping')->get($rowId);
        Cart::instance('shopping')->update($rowId, $item->qty + 1);

        $updated = Cart::instance('shopping')->get($rowId);

        return response()->json([
            'qty' => $updated->qty,
            'unit_price' => $updated->price,
            'rowTotal' => $updated->price * $updated->qty,
            'cartTotal' => Cart::instance('shopping')->subtotal(),
        ]);
    }

    public function decrement($rowId)
    {
        $item = Cart::instance('shopping')->get($rowId);
        if ($item->qty > 1) {
            Cart::instance('shopping')->update($rowId, $item->qty - 1);
        }

        $updated = Cart::instance('shopping')->get($rowId);

        return response()->json([
            'qty' => $updated->qty,
            'unit_price' => $updated->price,
            'rowTotal' => $updated->price * $updated->qty,
            'cartTotal' => Cart::instance('shopping')->subtotal(),
        ]);
    }

    public function remove($rowId)
    {
        Cart::instance('shopping')->remove($rowId);

        return response()->json([
            'status' => 'removed',
            'cartTotal' => Cart::instance('shopping')->subtotal(),
        ]);
    }
    
    
}
