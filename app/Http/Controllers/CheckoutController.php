<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\PaymentGateway;
use App\Models\ShippingCharge;
use Gloudemans\Shoppingcart\Facades\Cart;
use Session;

class CheckoutController extends Controller
{
    /**
     * Show the checkout page
     */
    public function checkout()
    {
        // সক্রিয় shipping charge সবগুলো এবং default charge
        $shippingCharges = ShippingCharge::where('status', 1)->get();
        $defaultCharge = $shippingCharges->first();

        // Payment gateways (active only)
        $bkashGateway = PaymentGateway::where(['status' => 1, 'type' => 'bkash'])->first();
        $shurjopayGateway = PaymentGateway::where(['status' => 1, 'type' => 'shurjopay'])->first();

        // Session এ shipping charge save করো (default)
        if ($defaultCharge) {
            Session::put('shipping', $defaultCharge->amount);
        }

        // Cart items
        $cartItems = Cart::instance('shopping')->content();

        // View return
        return view('frontEnd.layouts.customer.checkout', compact(
            'shippingCharges',
            'bkashGateway',
            'shurjopayGateway',
            'cartItems'
        ));
    }
}
