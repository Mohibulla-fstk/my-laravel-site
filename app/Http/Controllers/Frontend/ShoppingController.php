<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Combo;
use Cart;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;


class ShoppingController extends Controller
{
  

    public function showProducts(Request $request, $categorySlug = null)
    {
        $all_products = Product::with('images', 'reviews', 'procolors.color', 'prosizes.size');

        $category = null;
        $subcategories = collect();

        if ($categorySlug) {
            $category = Category::where('slug', $categorySlug)->where('status', 1)->first();
            if ($category) {
                $all_products->where('category_id', $category->id);
                $subcategories = Subcategory::where('category_id', $category->id)->where('status', 1)->get();
            }
        }

        $all_products = $all_products->get();
        $shippingcharge = ShippingCharge::all();

        return view('shop', compact('all_products', 'shippingcharge', 'category', 'subcategories'));
    }

    
    public function cart_store(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:products,id',
            'qty' => 'required|integer|min:1',
            'product_size' => 'nullable|string',
            'product_color' => 'nullable|string',
            'pro_unit' => 'nullable|string',
        ]);

        // Main product
        $product = Product::with('image')->find($request->id);
        if (!$product) {
            return redirect()->back()->with('error', 'Product not found!');
        }

        // Add product to cart
        Cart::instance('shopping')->add([
            'id' => $product->id,
            'name' => $product->name,
            'qty' => $request->qty,
            'price' => $product->new_price,
            'options' => [
                'slug' => $product->slug,
                'image' => $product->image->image ?? null,
                'old_price' => $product->old_price,
                'purchase_price' => $product->purchase_price,
                'product_size' => $request->product_size,
                'product_color' => $request->product_color,
                'pro_unit' => $request->pro_unit,
            ],
        ]);

        // Buy Now button check
        if ($request->has('order_now')) {
            return redirect()->route('customer.checkout')->with('success', 'Product added. Proceed to checkout.');
        }

        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }
    public function cart_store_combo(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:combos,id',
            'qty' => 'required|integer|min:1',
            'combo_products' => 'nullable|array',
            'combo_products.*' => 'nullable|exists:products,id',
            'combo_colors' => 'nullable|array',
            'combo_sizes' => 'nullable|array',
        ]);

        $combo = Combo::findOrFail($request->id);
        $qty = $request->qty;

        // ভিতরের product গুলা prepare করা (শুধু details show এর জন্য)
        $selectedProducts = [];
        if (!empty($request->combo_products) && is_array($request->combo_products)) {
            foreach ($request->combo_products as $index => $cpId) {
                if ($cpId) {
                    $product = Product::with('image')->find($cpId);
                    if ($product) {
                        $selectedProducts[] = [
                            'id' => $product->id,
                            'name' => $product->name,
                            'slug' => $product->slug,
                            'image' => $product->image->image ?? null,
                            'color' => $request->combo_colors[$index] ?? null,
                            'size' => $request->combo_sizes[$index] ?? null,
                        ];
                    }
                }
            }
        }

        // শুধু main combo cart এ add হবে
        Cart::instance('shopping')->add([
            'id' => 'combo-' . $combo->id,
            'name' => $combo->name ?? 'Unnamed Combo',
            'qty' => $qty,
            'price' => $combo->new_price ?? $combo->price ?? 0,
            'options' => [
                'combo_id' => $combo->id,
                'slug' => $combo->slug ?? '',
                'image' => $combo->images && $combo->images->count() > 0
                    ? $combo->images->first()->image
                    : 'public/default.png',
                'is_combo' => true,
                'product_type' => 'combo',
                'combo_items' => $selectedProducts, // ভিতরের product list
            ],
        ]);

        // Buy Now handling
        if ($request->has('combo_order_now')) {
            return redirect()->route('customer.checkout')
                ->with('success', 'Combo added. Proceed to checkout.');
        }

        return redirect()->back()->with('success', 'Combo added to cart successfully!');
    }




    public function show($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        return view('product.show', compact('product'));
    }


    public function cart_update(Request $request)
    {
        // Get the row ID of the cart item
        $rowId = $request->id;
        // Fetch the current cart item using the row ID
        $cartItem = Cart::instance('shopping')->get($rowId);
        if ($cartItem) {
            // Update the options for the cart item
            Cart::instance('shopping')->update($rowId, [
                'options' => [
                    'product_size' => $request->product_size ?: $cartItem->options->product_size, // Use new size or keep existing
                    'product_color' => $request->product_color ?: $cartItem->options->product_color, // Use new color or keep existing
                    'slug' => $cartItem->options->slug, // Keep existing slug
                    'image' => $cartItem->options->image, // Keep existing image
                    'old_price' => $cartItem->options->old_price, // Keep existing old price
                    'purchase_price' => $cartItem->options->purchase_price, // Keep existing purchase price
                    'pro_unit' => $cartItem->options->pro_unit,
                    
                     // Keep existing pro unit
                ],
            ]);
        }

        $data = Cart::instance('shopping')->content();

        return view('frontEnd.layouts.ajax.cart', compact('data'));
    }


    public function cart_remove(Request $request)
    {
        $remove = Cart::instance('shopping')->update($request->id, 0);
        $data = Cart::instance('shopping')->content();

        return view('frontEnd.layouts.ajax.cart', compact('data'));
    }

    // public function cart_increment(Request $request)
    // {
    //     $item = Cart::instance('shopping')->get($request->id);
    //     $qty = $item->qty + 1;
    //     $increment = Cart::instance('shopping')->update($request->id, $qty);
    //     $data = Cart::instance('shopping')->content();

    //     return view('frontEnd.layouts.ajax.cart', compact('data'));
    // }
    public function cart_increment(Request $request)
    {
        $item = Cart::instance('shopping')->get($request->id);
        if (!$item) {
            return $request->ajax()
                ? response()->json(['success' => false, 'message' => 'Item not found'])
                : abort(403, 'Direct access not allowed'); // browser direct → forbidden
        }

        // Increment quantity
        $qty = $item->qty + 1;
        Cart::instance('shopping')->update($request->id, $qty);

        // 🔹 AJAX call → return Blade partial for .cartlist
        if ($request->ajax()) {
            $data = Cart::instance('shopping')->content();
            return view('frontEnd.layouts.ajax.cart', compact('data'));
        }

        // Browser direct access → HTML render হবে না
        return response('success', 200);
    }
    public function cart_decrement(Request $request)
    {
        $item = Cart::instance('shopping')->get($request->id);
        if (!$item) {
            return $request->ajax()
                ? response()->json(['success' => false, 'message' => 'Item not found'])
                : abort(403, 'Direct access not allowed'); // browser direct → forbidden
        }

        // Increment quantity
        $qty = $item->qty - 1;
        Cart::instance('shopping')->update($request->id, $qty);

        // 🔹 AJAX call → return Blade partial for .cartlist
        if ($request->ajax()) {
            $data = Cart::instance('shopping')->content();
            return view('frontEnd.layouts.ajax.cart', compact('data'));
        }

        // Browser direct access → HTML render হবে না
        return response('success', 200);
    }

    // public function cart_decrement(Request $request)
    // {
    //     $item = Cart::instance('shopping')->get($request->id);
    //     $qty = $item->qty - 1;
    //     $decrement = Cart::instance('shopping')->update($request->id, $qty);
    //     $data = Cart::instance('shopping')->content();

    //     return view('frontEnd.layouts.ajax.cart', compact('data'));
    // }
  public function cart_menu(Request $request)
{
    // 🔹 AJAX call → Blade partial for cart menu
    if ($request->ajax()) {
        return view('frontEnd.layouts.ajax.cartmenu');
    }

    // Browser direct access → just success
    return response('success', 200);
}

    public function cart_count(Request $request)
    {
        $data = Cart::instance('shopping')->count();

        return view('frontEnd.layouts.ajax.cart_count', compact('data'));
    }

    public function mobilecart_qty(Request $request)
    {
        $data = Cart::instance('shopping')->count();

        return view('frontEnd.layouts.ajax.mobilecart_qty', compact('data'));
    }

    public function changeProduct(Request $request)
    {

        // Get the selected product
        $productId = $request->input('id');
        $product = Product::find($productId); // Fetch the product by ID

        if ($product) {
            // Clear existing items in the cart if necessary
            Cart::instance('shopping')->destroy(); // Or adjust this logic as needed

            // Add the selected product to the cart
            Cart::instance('shopping')->add([
                'id' => $product->id,
                'name' => $product->name,
                'qty' => 1, // Adjust quantity as needed
                'price' => $product->new_price,
                'options' => [
                    'slug' => $product->slug,
                    'image' => $product->image->image,
                    'old_price' => $product->old_price,
                    'purchase_price' => $product->purchase_price,
                ],
            ]);
            $data = Cart::instance('shopping')->content();

            return view('frontEnd.layouts.ajax.cart', compact('data'));

        }

        return response()->json(['success' => false, 'message' => 'Product not found.']);
    }

    public function increment($rowId)
    {
        $cart = Cart::instance('shopping');
        $cart->update($rowId, $cart->get($rowId)->qty + 1);

        return $this->cartResponse();
    }

    public function decrement($rowId)
    {
        $cart = Cart::instance('shopping');
        $qty = $cart->get($rowId)->qty;

        if ($qty > 1) {
            $cart->update($rowId, $qty - 1);
        } else {
            $cart->remove($rowId);
        }

        return $this->cartResponse();
    }

    public function remove($rowId)
    {
        $cart = Cart::instance('shopping');
        $cart->remove($rowId);

        return $this->cartResponse();
    }

    public function menu()
    {
        return view('frontEnd.layouts.partials.cartmenu');
    }

    private function cartResponse()
    {
        return response()->json([
            'html' => view('frontEnd.layouts.partials.cartmenu')->render(),
            'total' => Cart::instance('shopping')->subtotal(),
            'count' => Cart::instance('shopping')->count(),
        ]);
    }
}
