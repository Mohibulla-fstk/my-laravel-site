<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // Cart facade ensure import
use Illuminate\Support\Facades\Session;

class CouponController extends Controller
{
    /**
     * Apply coupon
     */
    public function __construct()
    {
        $this->middleware('permission:coupon-list|coupon-create|coupon-edit|coupon-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:coupon-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:coupon-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:coupon-delete', ['only' => ['destroy']]);
    }

    public function apply(Request $request)
    {
        try {
            $request->validate([
                'code' => 'required|string',
                'subtotal' => 'nullable|numeric',
                'shipping' => 'nullable|numeric',
                'product_id' => 'nullable|integer',
            ]);

            $coupon = Coupon::where('code', $request->code)->first();
            if (!$coupon)
                return response()->json(['error' => 'Invalid coupon code']);

            $subtotal = (float) ($request->subtotal ?? 0);
            $shipping = (float) ($request->shipping ?? 0);

            if (!method_exists($coupon, 'isCurrentlyValid') || !$coupon->isCurrentlyValid($subtotal)) {
                return response()->json(['error' => 'This coupon is not valid for your order.']);
            }

            $userKey = auth()->check() ? 'user_' . auth()->id() : md5($request->ip() . session()->getId());
            $used_by = $coupon->used_by ? json_decode($coupon->used_by, true) : [];
            $user_uses = $used_by[$userKey] ?? 0;

            if ($coupon->max_uses && $user_uses >= $coupon->max_uses) {
                return response()->json(['error' => "You have already used this coupon {$user_uses}/{$coupon->max_uses} times."]);
            }

            $discount = ($coupon->value > 0) ? ($coupon->value / 100) * $subtotal : min($subtotal, $coupon->max_discount ?? $subtotal);
            $shipOff = 0;
            $grandTotal = max(0, ($subtotal - $discount) + max(0, $shipping - $shipOff));

            Session::put('coupon', [
                'id' => $coupon->id,
                'code' => $coupon->code,
                'subtotal' => $subtotal,
                'discount' => $discount,
                'shipping_discount' => $shipOff,
                'grandTotal' => $grandTotal
            ]);

            $used_by[$userKey] = $user_uses + 1;
            $coupon->used_by = json_encode($used_by);
            $coupon->save();

            return response()->json([
                'success' => true,
                'message' => 'Coupon applied successfully!',
                'code' => $coupon->code,
                'subtotal' => $subtotal,
                'shipping' => $shipping,
                'discount' => $discount,
                'shipping_discount' => $shipOff,
                'grandTotal' => $grandTotal
            ]);

        } catch (\Exception $e) {
            Log::error('Coupon apply error: ' . $e->getMessage());
            return response()->json(['error' => 'Something went wrong. Please try again.'], 500);
        }
    }



    /**
     * Remove coupon
     */
    public function remove(Request $request)
    {
        try {
            $applied = session('coupon');

            if ($applied) {
                $coupon = Coupon::find($applied['id']);
                if ($coupon) {
                    $fromCheckout = $request->fromCheckout ?? false;
                    $userKey = auth()->check() ? 'user_' . auth()->id() : md5($request->ip() . session()->getId());

                    $used_by = [];
                    if ($coupon->used_by) {
                        $decoded = json_decode($coupon->used_by, true);
                        if (json_last_error() === JSON_ERROR_NONE) {
                            $used_by = $decoded;
                        }
                    }

                    if (!$fromCheckout && isset($used_by[$userKey]) && $used_by[$userKey] > 0) {
                        $used_by[$userKey]--;
                        $coupon->used_by = json_encode($used_by);
                        $coupon->save();
                    }
                }
            }

            Session::forget('coupon');

            $subtotal = (float) Cart::instance('shopping')->subtotal(2, '.', '');
            $shipping = Session::get('shipping') ?? 0;
            $discount = 0;
            $shipOff = 0;
            $grandTotal = max(0, ($subtotal - $discount) + max(0, $shipping - $shipOff));

            return response()->json([
                'success' => 'Coupon removed successfully!',
                'code' => null,
                'subtotal' => $subtotal,
                'shipping' => $shipping,
                'discount' => $discount,
                'shipping_discount' => $shipOff,
                'grandTotal' => $grandTotal,
            ]);

        } catch (\Exception $e) {
            Log::error('Coupon remove error: ' . $e->getMessage());

            return response()->json(['error' => 'Something went wrong. Please try again.'], 500);
        }
    }

    public function index()
    {
        $coupons = \App\Models\Coupon::orderBy('created_at', 'desc')->get();

        return view('backEnd.coupon.index', compact('coupons'));
    }

    /**
     * Show create coupon form
     */
    public function create()
    {
        return view('backEnd.coupon.create'); // তুমি যেই path ব্যবহার করছো তা 맞াবো
    }

    /**
     * Show edit coupon form
     */
    public function edit($id)
    {
        $coupon = Coupon::findOrFail($id);

        return view('backEnd.coupon.edit', compact('coupon'));
    }

    /**
     * Store new coupon
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:coupons,code',
            'type' => 'required|in:percent,fixed,free_shipping',
            'value' => 'nullable|numeric',
            'max_discount' => 'nullable|numeric',
            'min_order_total' => 'nullable|numeric',
            'max_uses' => 'nullable|integer',
            'is_active' => 'required|boolean',
            'starts_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after_or_equal:starts_at',
        ]);

        Coupon::create([
            'code' => $request->code,
            'type' => $request->type,
            'value' => $request->value ?? 0,           // যদি null আসে, 0 সেট হবে
            'max_discount' => $request->max_discount ?? 0,
            'min_order_total' => $request->min_order_total ?? 0,
            'max_uses' => $request->max_uses ?? 1,
            'is_active' => $request->is_active ?? 1,
            'starts_at' => $request->starts_at,
            'expires_at' => $request->expires_at,
        ]);

        return redirect()->route('coupon.index')->with('success', 'Coupon created successfully!');
    }

    /**
     * Make coupon inactive
     */
    public function inactive(Request $request)
    {
        $coupon = Coupon::findOrFail($request->hidden_id);
        $coupon->is_active = 0;
        $coupon->save();

        return redirect()->back()->with('success', 'Coupon deactivated successfully!');
    }

    /**
     * Make coupon active
     */
    public function active(Request $request)
    {
        $coupon = Coupon::findOrFail($request->hidden_id);
        $coupon->is_active = 1;
        $coupon->save();

        return redirect()->back()->with('success', 'Coupon activated successfully!');
    }

    /**
     * Delete coupon
     */
    public function destroy(Request $request, $id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->delete();

        return redirect()->back()->with('success', 'Coupon deleted successfully!');
    }

    public function checkout()
    {
        $cartItems = \Cart::instance('shopping')->content();
        $cartSubtotal = (float) \Cart::instance('shopping')->subtotal(2, '.', '');
        $cartShipping = 100; // dynamic হলে তোমার shipping logic বসাও
        $coupon = session('coupon');

        return view('frontEnd.layouts.customer.checkout', compact(
            'cartItems',
            'cartSubtotal',
            'cartShipping',
            'coupon'
        ));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'code' => 'required|string|unique:coupons,code,' . $id,
            'type' => 'required|in:percent,fixed,free_shipping',
            'value' => 'nullable|numeric',
            'max_discount' => 'nullable|numeric',
            'min_order_total' => 'nullable|numeric',
            'max_uses' => 'nullable|integer',
            'is_active' => 'required|boolean',
            'starts_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after_or_equal:starts_at',
        ]);

        $coupon = Coupon::findOrFail($id);

        $coupon->update([
            'code' => $request->code,
            'type' => $request->type,
            'value' => $request->value,
            'max_discount' => $request->max_discount,
            'min_order_total' => $request->min_order_total,
            'max_uses' => $request->max_uses,
            'is_active' => $request->has('is_active') ? 1 : 0,
            'starts_at' => $request->starts_at,
            'expires_at' => $request->expires_at,
        ]);

        return redirect()->route('coupon.index')->with('success', 'Coupon updated successfully!');
    }
}
