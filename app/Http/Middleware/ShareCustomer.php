<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;
use App\Models\Product;

class ShareCustomer
{
    public function handle(Request $request, Closure $next)
    {
        // 1️⃣ Logged-in customer
        $customer = Auth::guard('customer')->check()
            ? Customer::find(Auth::guard('customer')->id())
            : null;

        // 2️⃣ All active products
        $all_products = Product::where('status', 1)
            ->with('category', 'image', 'images', 'procolors', 'prosizes')
            ->get();

        // 3️⃣ Blade view-এ share করা
        view()->share([
            'customer' => $customer,
            'all_products' => $all_products
        ]);

        return $next($request);
    }
}
