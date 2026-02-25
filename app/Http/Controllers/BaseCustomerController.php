<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Customer;
use App\Models\Product;

class BaseCustomerController extends Controller
{
    protected $customer;
    protected $all_products;

    public function __construct()
    {
        // Middleware দিয়ে handle করা হচ্ছে প্রতিটি request
        $this->middleware(function ($request, $next) {

            // 1️⃣ Logged-in customer set করা
            $this->customer = Auth::guard('customer')->check()
                ? Customer::find(Auth::guard('customer')->id())
                : null;

            // 2️⃣ All active products set করা
            $this->all_products = Product::where('status', 1)
                ->with('category', 'image', 'images', 'procolors', 'prosizes')
                ->get();

            // 3️⃣ Blade view-এ share করা
            view()->share([
                'customer' => $this->customer,
                'all_products' => $this->all_products
            ]);

            return $next($request);
        });
    }
}
