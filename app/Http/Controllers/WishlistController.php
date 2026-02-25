<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Cookie;

class WishlistController extends Controller
{
    public function index(Request $request)
    {
        $wishlist = json_decode($request->cookie('wishlist', '[]'), true);
        return view('frontEnd.layouts.pages.wishlist', compact('wishlist'));
    }

    public function toggle(Request $request)
    {
        $wishlist = json_decode($request->cookie('wishlist', '[]'), true);

        // REMOVE
        if (isset($wishlist[$request->product_id])) {
            unset($wishlist[$request->product_id]);

            Cookie::queue('wishlist', json_encode($wishlist), 60 * 24 * 30);

            return response()->json([
                'status' => 'removed',
                'count'  => count($wishlist)
            ]);
        }

        // ADD
        $product = Product::findOrFail($request->product_id);

        $wishlist[$product->id] = [
            'id'    => $product->id,
            'name'  => $product->name,
            'new_price' => $product->new_price,
            'old_price' => $product->old_price,
            'stock' => $product->stock,
            'image' => optional($product->image)->image,
            'slug'  => $product->slug,
        ];

        Cookie::queue('wishlist', json_encode($wishlist), 60 * 24 * 30);

        return response()->json([
            'status' => 'added',
            'count'  => count($wishlist)
        ]);
    }
}
