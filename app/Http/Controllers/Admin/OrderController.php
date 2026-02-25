<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Courierapi;
use App\Models\Customer;
use App\Models\GeneralSetting;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\OrderStatus;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Shipping;
use App\Models\ShippingCharge;
use App\Models\SmsGateway;
use App\Models\User;
use Cart;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Session;
use Toastr;

class OrderController extends Controller
{
    public function index($slug, Request $request)
    {
        if ($slug == 'all') {
            $order_status = (object) [
                'name' => 'All',
                'orders_count' => Order::count(),
            ];

            // coupon relation load করা হয়েছে
            $show_data = Order::latest()->with('shipping', 'status', 'coupon', 'details');

            if ($request->keyword) {
                $show_data = $show_data->where(function ($query) use ($request) {
                    $query->orWhere('invoice_id', 'LIKE', '%' . $request->keyword . '%')
                        ->orWhereHas('shipping', function ($subQuery) use ($request) {
                            $subQuery->where('phone', $request->keyword);
                        });
                });
            }

            $show_data = $show_data->paginate(10);
        } else {
            $order_status = OrderStatus::where('slug', $slug)
                ->withCount('orders')
                ->first();

            $show_data = Order::where(['order_status' => $order_status->id])
                ->latest()
                ->with('shipping', 'status', 'coupon') // coupon relation load
                ->paginate(10);
        }

        $users = User::get();
        $steadfast = Courierapi::where(['status' => 1, 'type' => 'steadfast'])->first();
        $pathao_info = Courierapi::where(['status' => 1, 'type' => 'pathao'])
            ->select('id', 'type', 'url', 'token', 'status')
            ->first();

        // pathao courier
        if ($pathao_info) {
            $response = Http::get($pathao_info->url . '/api/v1/countries/1/city-list');
            $pathaocities = $response->json();

            $response2 = Http::withHeaders([
                'Authorization' => 'Bearer ' . $pathao_info->token,
                'Content-Type' => 'application/json',
            ])->get($pathao_info->url . '/api/v1/stores');

            $pathaostore = $response2->json();
        } else {
            $pathaocities = [];
            $pathaostore = [];
        }

        return view(
            'backEnd.order.index',
            compact('show_data', 'order_status', 'users', 'steadfast', 'pathaostore', 'pathaocities')
        );
    }

    public function orderSave(Request $request)
    {
        $applied = session('coupon'); // coupon session থেকে নিলাম
        $cartContent = Cart::instance('shopping')->content();

        // Subtotal হিসাব
        $totalSubtotal = 0;
        foreach ($cartContent as $item) {
            $totalSubtotal += $item->price * $item->qty;
        }

        // Shipping charge
        $shipping = Session::get('shipping') ?? 0;

        // Discount (coupon থেকে)
        $discount = $applied['discount'] ?? 0;
        $shipOff = $applied['shipping_discount'] ?? 0;

        // Grand total
        $grandTotal = max(0, ($totalSubtotal - $discount) + max(0, $shipping - $shipOff));

        // Order তৈরি
        $order = new Order;
        $order->invoice_id = rand(10000, 99999);
        $order->amount = $grandTotal;
        $order->shipping_charge = $shipping;
        $order->customer_id = auth()->id();

        // যদি coupon apply করা থাকে
        if (!empty($applied)) {
            $order->coupon_id = $applied['id'] ?? null;
            $order->discount_amount = $applied['discount'] ?? 0;
        } else {
            $order->coupon_id = null;
            $order->discount_amount = 0;
        }

        $order->save();

        // Order details save
        foreach (Cart::instance('shopping')->content() as $cartItem) {
            if (isset($cartItem->options['combo_id'])) {
                // ✅ Combo product
                OrderDetails::create([
                    'order_id' => $order->id,
                    'product_id' => null,  // combo হলে product_id null
                    'combo_id' => $cartItem->options['combo_id'],
                    'product_name' => $cartItem->name,
                    'purchase_price' => $cartItem->price,
                    'qty' => $cartItem->qty,
                    'product_color' => null,
                    'product_size' => null,
                    'discount_amount' => 0,
                ]);
            } else {
                // ✅ Normal product
                OrderDetails::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->id,
                    'combo_id' => null, // normal product হলে combo_id null
                    'product_name' => $cartItem->name,
                    'purchase_price' => $cartItem->price,
                    'qty' => $cartItem->qty,
                    'product_color' => $cartItem->options['product_color'] ?? null,
                    'product_size' => $cartItem->options['product_size'] ?? null,
                    'discount_amount' => 0,
                ]);
            }
        }

        // Coupon session clear
        session()->forget('coupon');

        return redirect()->route('customer.order.success', $order->id);
    }



    public function pathaocity(Request $request)
    {
        $pathao_info = Courierapi::where(['status' => 1, 'type' => 'pathao'])->select('id', 'type', 'url', 'token', 'status')->first();
        if ($pathao_info) {
            $response = Http::get($pathao_info->url . '/api/v1/cities/' . $request->city_id . '/zone-list');
            $pathaozones = $response->json();

            return response()->json($pathaozones);
        } else {
            return response()->json([]);
        }
    }

    public function pathaozone(Request $request)
    {
        $pathao_info = Courierapi::where(['status' => 1, 'type' => 'pathao'])->select('id', 'type', 'url', 'token', 'status')->first();
        if ($pathao_info) {
            $response = Http::get($pathao_info->url . '/api/v1/zones/' . $request->zone_id . '/area-list');
            $pathaoareas = $response->json();

            return response()->json($pathaoareas);
        } else {
            return response()->json([]);
        }
    }

    public function order_pathao(Request $request)
    {
        $orders_id = $request->order_ids;

        foreach ($orders_id as $order_id) {
            $order = Order::with('shipping')->find($order_id);
            $order_count = OrderDetails::select('order_id')->where('order_id', $order->id)->count();
            // return $request->all();
            // pathao
            $pathao_info = Courierapi::where(['status' => 1, 'type' => 'pathao'])->select('id', 'type', 'url', 'token', 'status')->first();
            if ($pathao_info) {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $pathao_info->token,
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ])->post($pathao_info->url . '/api/v1/orders', [
                            'store_id' => $request->pathaostore,
                            'merchant_order_id' => $order->invoice_id,
                            'sender_name' => 'Test',
                            'sender_phone' => $order->shipping ? $order->shipping->phone : '',
                            'recipient_name' => $order->shipping ? $order->shipping->name : '',
                            'recipient_phone' => $order->shipping ? $order->shipping->phone : '',
                            'recipient_address' => $order->shipping ? $order->shipping->address : '',
                            'recipient_city' => $request->pathaocity,
                            'recipient_zone' => $request->pathaozone,
                            'recipient_area' => $request->pathaoarea,
                            'delivery_type' => 48,
                            'item_type' => 2,
                            'special_instruction' => 'Special note- product must be check after delivery',
                            'item_quantity' => 1,
                            'item_weight' => 0.5,
                            'amount_to_collect' => round($order->amount),
                            'item_description' => 'Special note- product must be check after delivery',
                        ]);
            }
            if ($response->status() == '200') {
                Toastr::success($response['data']['consignment_id'], 'Courier Tracking ID');

                return response()->json(['status' => 'success', 'message' => $response['data']['consignment_id'], 'Courier Tracking ID']);
            } else {
                Toastr::error($response['message'], 'Courier Order Faild');

                return response()->json(['status' => 'failed', 'message' => $response['message'], 'Courier Order Faild']);
            }

            return redirect()->back();

        }
    }

    public function invoice($invoice_id)
    {
        $order = Order::where(['invoice_id' => $invoice_id])->with('orderdetails', 'payment', 'shipping', 'customer')->firstOrFail();

        return view('backEnd.order.invoice', compact('order'));
    }

    public function process($invoice_id)
    {
        $data = Order::where(['invoice_id' => $invoice_id])->select('id', 'invoice_id', 'order_status')->with('orderdetails')->first();
        $shippingcharge = ShippingCharge::where('status', 1)->get();

        return view('backEnd.order.process', compact('data', 'shippingcharge'));
    }

    public function order_process(Request $request)
    {

        $link = OrderStatus::find($request->status)->slug;
        $order = Order::find($request->id);
        $courier = $order->order_status;
        $order->order_status = $request->status;
        $order->admin_note = $request->admin_note;
        $order->save();

        $shipping_update = Shipping::where('order_id', $order->id)->first();
        $shippingfee = ShippingCharge::find($request->area);
        if ($shippingfee->name != $request->area) {
            if ($order->shipping_charge > $shippingfee->amount) {
                $total = $order->amount + ($shippingfee->amount - $order->shipping_charge);
                $order->shipping_charge = $shippingfee->amount;
                $order->amount = $total;
                $order->save();
            } else {
                $total = $order->amount + ($shippingfee->amount - $order->shipping_charge);
                $order->shipping_charge = $shippingfee->amount;
                $order->amount = $total;
                $order->save();
            }
        }

        $shipping_update->name = $request->name;
        $shipping_update->phone = $request->phone;
        $shipping_update->address = $request->address;
        $shipping_update->area = $shippingfee->name;
        $shipping_update->save();

        if ($request->status == 5 && $courier != 5) {
            $courier_info = Courierapi::where(['status' => 1, 'type' => 'steadfast'])->first();
            if ($courier_info) {
                $consignmentData = [
                    'invoice' => $order->invoice_id,
                    'recipient_name' => $order->shipping ? $order->shipping->name : 'InboxHat',
                    'recipient_phone' => $order->shipping ? $order->shipping->phone : '01750578495',
                    'recipient_address' => $order->shipping ? $order->shipping->address : '01750578495',
                    'cod_amount' => $order->amount,
                ];
                $client = new Client;
                $response = $client->post('$courier_info->url', [
                    'json' => $consignmentData,
                    'headers' => [
                        'Api-Key' => '$courier_info->api_key',
                        'Secret-Key' => '$courier_info->secret_key',
                        'Accept' => 'application/json',
                    ],
                ]);

                $responseData = json_decode($response->getBody(), true);
            } else {
                return 'ok';
            }
            Toastr::success('Success', 'Order status change successfully');

            return redirect('admin/order/' . $link);
        }
        Toastr::success('Success', 'Order status change successfully');

        return redirect('admin/order/' . $link);
    }

    public function destroy(Request $request)
    {
        $order = Order::where('id', $request->id)->delete();
        $order_details = OrderDetails::where('order_id', $request->id)->delete();
        $shipping = Shipping::where('order_id', $request->id)->delete();
        $payment = Payment::where('order_id', $request->id)->delete();
        Toastr::success('Success', 'Order delete success successfully');

        return redirect()->back();
    }

    public function order_assign(Request $request)
    {
        $products = Order::whereIn('id', $request->input('order_ids'))->update(['user_id' => $request->user_id]);

        return response()->json(['status' => 'success', 'message' => 'Order user id assign']);
    }

    public function order_status(Request $request)
    {

        $sms_gateway = SmsGateway::where('status', 1)->first();
        $site_setting = GeneralSetting::where('status', 1)->first();
        // Update order statuses
        $orders = Order::whereIn('id', $request->input('order_ids'))->get();

        foreach ($orders as $order) {

            $order->order_status = $request->order_status;
            $order->update();
            $orderStatus = OrderStatus::find($request->order_status);

            // Send SMS to the customer
            if ($sms_gateway) {
                $customer_info = Customer::find($order->customer_id); // Retrieve customer information
                if ($customer_info) {
                    $url = $sms_gateway->url;
                    $data = [
                        'api_key' => $sms_gateway->api_key,
                        'number' => $customer_info->phone,
                        'type' => 'text',
                        'senderid' => $sms_gateway->serderid,
                        'message' => "Dear {$customer_info->name},\r\n"
                            . "Your order (Order ID: {$order->invoice_id}) status has been updated to: "
                            . "{$orderStatus->name}.\r\n"
                            . "Thank you for using {$site_setting->name}!",
                    ];

                    // cURL request to send SMS
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    $response = curl_exec($ch);
                    curl_close($ch);
                }
            }
        }

        if ($request->order_status == 5) {
            $orders = Order::whereIn('id', $request->input('order_ids'))->get();
            foreach ($orders as $order) {
                $orders_details = OrderDetails::select('id', 'order_id', 'product_id')->where('order_id', $order->id)->get();
                foreach ($orders_details as $order_details) {
                    $product = Product::select('id', 'stock')->find($order_details->product_id);
                    $product->stock -= $order_details->qty;
                    $product->save();
                }

            }
        }

        return response()->json(['status' => 'success', 'message' => 'Order status change successfully']);
    }

    public function bulk_destroy(Request $request)
    {
        $orders_id = $request->order_ids;
        foreach ($orders_id as $order_id) {
            $order = Order::where('id', $order_id)->delete();
            $order_details = OrderDetails::where('order_id', $order_id)->delete();
            $shipping = Shipping::where('order_id', $order_id)->delete();
            $payment = Payment::where('order_id', $order_id)->delete();
        }

        return response()->json(['status' => 'success', 'message' => 'Order delete successfully']);
    }

    public function order_print(Request $request)
    {
        $orders = Order::whereIn('id', $request->input('order_ids'))->with('orderdetails', 'payment', 'shipping', 'customer')->get();
        $view = view('backEnd.order.print', ['orders' => $orders])->render();

        return response()->json(['status' => 'success', 'view' => $view]);
    }
    // public function bulk_courier($slug, Request $request)
    // {
    //     $courier_info = Courierapi::where(['status' => 1, 'type' => $slug])->first();

    //     if ($courier_info) {
    //         $orders_ids = $request->order_ids;

    //         foreach ($orders_ids as $order_id) {
    //             $order = Order::find($order_id);

    //             $courier = $order->order_status;
    //             if ($request->status == 5 && $courier != 5) {
    //                 $consignmentData = [
    //                     'invoice' => $order->invoice_id,
    //                     'recipient_name' => $order->shipping ? $order->shipping->name : 'InboxHat',
    //                     'recipient_phone' => $order->shipping ? $order->shipping->phone : '01750578495',
    //                     'recipient_address' => $order->shipping ? $order->shipping->address : '01750578495',
    //                     'cod_amount' => $order->amount
    //                 ];
    //                 $client = new Client();
    //                 $response = $client->post('$courier_info->url', [
    //                     'json' => $consignmentData,
    //                     'headers' => [
    //                         'Api-Key' => '$courier_info->api_key',
    //                         'Secret-Key' => '$courier_info->secret_key',
    //                         'Accept' => 'application/json',
    //                     ],
    //                 ]);

    //                 $responseData = json_decode($response->getBody(), true);
    //                 if ($responseData['status'] == 200) {
    //                     $message = 'Your order place to courier successfully';
    //                     $status = 'success';
    //                     $order->order_status = 4;
    //                     $order->save();
    //                 } else {
    //                     $message = 'Your order place to courier failed';
    //                     $status = 'failed';
    //                 }
    //                 return response()->json(['status' => $status, 'message' => $message]);
    //             }

    //         }
    //     } else {
    //         return "stop";
    //     }
    // }
    public function bulk_courier($slug, Request $request)
    {
        $courier_info = Courierapi::where(['status' => 1, 'type' => $slug])->first();

        if ($courier_info) {
            $orders_ids = $request->order_ids;
            $successOrders = [];
            $failedOrders = [];

            foreach ($orders_ids as $order_id) {
                $order = Order::find($order_id);

                if ($order && $request->status == 5 && $order->order_status != 5) {
                    $consignmentData = [
                        'invoice' => $order->invoice_id,
                        'recipient_name' => $order->shipping ? $order->shipping->name : 'InboxHat',
                        'recipient_phone' => $order->shipping ? $order->shipping->phone : '01750578495',
                        'recipient_address' => $order->shipping ? $order->shipping->address : 'Address not provided',
                        'cod_amount' => $order->amount,
                    ];

                    $client = new Client;
                    try {
                        $response = $client->post($courier_info->url, [
                            'json' => $consignmentData,
                            'headers' => [
                                'Api-Key' => $courier_info->api_key,
                                'Secret-Key' => $courier_info->secret_key,
                                'Accept' => 'application/json',
                            ],
                        ]);

                        $responseData = json_decode($response->getBody(), true);

                        if ($responseData['status'] == 200) {
                            $order->order_status = 5; // Update order status to successful placement
                            $order->save();
                            $successOrders[] = [
                                'order_id' => $order_id,
                                'message' => $responseData['message'] ?? 'Order placed successfully',
                            ];
                        } else {
                            $failedOrders[] = [
                                'order_id' => $order_id,
                                'message' => $responseData['message'] ?? 'Failed to place order',
                            ];
                        }
                    } catch (\Exception $e) {
                        // Add to failed orders if there's an exception
                        $failedOrders[] = [
                            'order_id' => $order_id,
                            'message' => $e->getMessage(),
                        ];
                    }
                }
            }

            // Return summary of success and failure
            return response()->json([
                'status' => 'success',
                'message' => 'Your order place to courier successfully',
                'success' => json_encode($successOrders),
                'failed' => json_encode($failedOrders),
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Courier information not found.',
            ]);
        }
    }

    public function stock_report(Request $request)
    {
        $products = Product::select('id', 'name', 'new_price', 'stock')
            ->where('status', 1);
        if ($request->keyword) {
            $products = $products->where('name', 'LIKE', '%' . $request->keyword . '%');
        }
        if ($request->category_id) {
            $products = $products->where('category_id', $request->category_id);
        }
        if ($request->start_date && $request->end_date) {
            $products = $products->whereBetween('updated_at', [$request->start_date, $request->end_date]);
        }
        $total_purchase = $products->sum(\DB::raw('purchase_price * stock'));
        $total_stock = $products->sum('stock');
        $total_price = $products->sum(\DB::raw('new_price * stock'));
        $products = $products->paginate(10);
        $categories = Category::where('status', 1)->get();

        return view('backEnd.reports.stock', compact('products', 'categories', 'total_purchase', 'total_stock', 'total_price'));
    }

    public function order_report(Request $request)
    {
        $users = User::where('status', 1)->get();
        $orders = OrderDetails::with('shipping', 'order')->whereHas('order', function ($query) {
            $query->where('order_status', 6);
        });
        if ($request->keyword) {
            $orders = $orders->where('name', 'LIKE', '%' . $request->keyword . '%');
        }
        if ($request->user_id) {
            $orders = $orders->whereHas('order', function ($query) use ($request) {
                $query->where('user_id', $request->user_id);
            });
        }
        if ($request->start_date && $request->end_date) {
            $orders = $orders->whereBetween('updated_at', [$request->start_date, $request->end_date]);
        }
        $total_purchase = $orders->sum(\DB::raw('purchase_price * qty'));
        $total_item = $orders->sum('qty');
        $total_sales = $orders->sum(\DB::raw('sale_price * qty'));
        $orders = $orders->paginate(10);

        return view('backEnd.reports.order', compact('orders', 'users', 'total_purchase', 'total_item', 'total_sales'));
    }

    public function order_create()
    {
        $cartinfo = Cart::instance('pos_shopping')->destroy();
        $products = Product::select('id', 'name', 'new_price', 'product_code')->where(['status' => 1])->get();
        $cartinfo = Cart::instance('pos_shopping')->content();
        $shippingcharge = ShippingCharge::where('status', 1)->get();

        return view('backEnd.order.create', compact('products', 'cartinfo', 'shippingcharge', ));
    }

    public function order_store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'area' => 'required',
        ]);

        if (Cart::instance('pos_shopping')->count() <= 0) {
            Toastr::error('Your shopping empty', 'Failed!');

            return redirect()->back();
        }

        $subtotal = Cart::instance('pos_shopping')->subtotal();
        $subtotal = str_replace(',', '', $subtotal);
        $subtotal = str_replace('.00', '', $subtotal);
        $discount = Session::get('pos_discount') + Session::get('product_discount');
        $shippingfee = ShippingCharge::find($request->area);

        $exits_customer = Customer::where('phone', $request->phone)->select('phone', 'id')->first();
        if ($exits_customer) {
            $customer_id = $exits_customer->id;
        } else {
            $password = rand(111111, 999999);
            $store = new Customer;
            $store->name = $request->name;
            $store->slug = $request->name;
            $store->phone = $request->phone;
            $store->password = bcrypt($password);
            $store->verify = 1;
            $store->status = 'active';
            $store->save();
            $customer_id = $store->id;
        }

        // order data save
        $order = new Order;
        $order->invoice_id = rand(11111, 99999);
        $order->amount = ($subtotal + $shippingfee->amount) - $discount;
        $order->discount = $discount ? $discount : 0;
        $order->shipping_charge = $shippingfee->amount;
        $order->customer_id = $customer_id;
        $order->order_status = 1;
        $order->note = $request->note;
        $order->save();

        // shipping data save
        $shipping = new Shipping;
        $shipping->order_id = $order->id;
        $shipping->customer_id = $customer_id;
        $shipping->name = $request->name;
        $shipping->phone = $request->phone;
        $shipping->address = $request->address;
        $shipping->area = $shippingfee->name;
        $shipping->save();

        // payment data save
        $payment = new Payment;
        $payment->order_id = $order->id;
        $payment->customer_id = $customer_id;
        $payment->payment_method = 'Cash On Delivery';
        $payment->amount = $order->amount;
        $payment->payment_status = 'pending';
        $payment->save();

        // order details data save
        foreach (Cart::instance('pos_shopping')->content() as $cart) {
            OrderDetails::create([
                'order_id' => $order->id,
                'product_id' => ($cart->options['is_combo'] ?? false) ? null : $cart->id,
                'combo_id' => $cart->options['combo_id'] ?? $cart->options['parent_combo'] ?? null,
                'product_name' => $cart->name,
                'purchase_price' => $cart->options['purchase_price'] ?? $cart->price,
                'sale_price' => $cart->price,
                'qty' => $cart->qty,
                'product_color' => $cart->options['product_color'] ?? null,
                'product_size' => $cart->options['product_size'] ?? null,
                'discount_amount' => $cart->options['product_discount'] ?? 0,

                // ✅ Product type set করা
                'product_type' => $cart->options['is_combo_item'] ?? false
                    ? 'combo_item'
                    : (($cart->options['is_combo'] ?? false) ? 'combo' : 'normal'),
            ]);
        }

        Cart::instance('pos_shopping')->destroy();
        Session::forget('pos_shipping');
        Session::forget('pos_discount');
        Session::forget('product_discount');
        Toastr::success('Thanks, Your order place successfully', 'Success!');

        return redirect('admin/order/pending');
    }

    public function cart_add(Request $request)
    {
        $product = Product::with('image', 'sizes', 'colors')->find($request->id);
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        $cartItem = Cart::instance('pos_shopping')->add([
            'id' => $product->id,
            'name' => $product->name,
            'qty' => 1,
            'price' => $product->new_price,
            'options' => [
                'slug' => $product->slug,
                'image' => $product->image->image ?? null,
                'old_price' => $product->old_price,
                'purchase_price' => $product->purchase_price,
                'product_discount' => 0,
                'details_id' => null, // নতুন প্রোডাক্টে null
                'product_size' => '',
                'product_color' => '',
            ],
        ]);

        return response()->json([
            'success' => true,
            'cart' => Cart::instance('pos_shopping')->content(),
        ]);
    }

    public function cart_content()
    {
        $cartinfo = Cart::instance('pos_shopping')->content();

        return view('backEnd.order.cart_content', compact('cartinfo'));
    }

    public function cart_details()
    {
        $cartinfo = Cart::instance('pos_shopping')->content();
        $discount = 0;
        foreach ($cartinfo as $cart) {
            $discount += $cart->options->product_discount * $cart->qty;
        }
        Session::put('product_discount', $discount);

        return view('backEnd.order.cart_details', compact('cartinfo'));
    }

    public function cart_increment(Request $request)
    {
        $qty = $request->qty + 1;
        $cart = Cart::instance('pos_shopping')->content()->where('rowId', $request->id)->first();
        $cartinfo = Cart::instance('pos_shopping')->update($request->id, [
            'qty' => $qty,
            'options' => [
                'slug' => $cart->options->slug,
                'image' => $cart->options->image,
                'old_price' => $cart->options->old_price,
                'purchase_price' => $cart->options->purchase_price,
                'product_discount' => $cart->options->product_discount,
                'product_size' => $cart->options->product_size,
                'product_color' => $cart->options->product_color,
            ],
        ]);

        return response()->json($cartinfo);
    }

    public function cart_decrement(Request $request)
    {
        $qty = $request->qty - 1;
        $cart = Cart::instance('pos_shopping')->content()->where('rowId', $request->id)->first();
        $cartinfo = Cart::instance('pos_shopping')->update($request->id, [
            'qty' => $qty,
            'options' => [
                'slug' => $cart->options->slug,
                'image' => $cart->options->image,
                'old_price' => $cart->options->old_price,
                'purchase_price' => $cart->options->purchase_price,
                'product_discount' => $cart->options->product_discount,
                'product_size' => $cart->options->product_size,
                'product_color' => $cart->options->product_color,
            ],
        ]);

        return response()->json($cartinfo);
    }

    public function cart_remove(Request $request)
    {
        $rowId = $request->id;

        // 1️⃣ Try get cart item first
        $cartItem = Cart::instance('pos_shopping')->get($rowId);

        // 2️⃣ Remove from Cart if exists
        if ($cartItem) {
            Cart::instance('pos_shopping')->remove($rowId);
        }

        // 3️⃣ Remove from database if details_id exists
        if ($cartItem && isset($cartItem->options['details_id'])) {
            OrderDetails::where('id', $cartItem->options['details_id'])->delete();
        }

        // 4️⃣ Always return success to avoid Ajax error
        $cartinfo = Cart::instance('pos_shopping')->content();

        return response()->json([
            'success' => true,
            'cartinfo' => $cartinfo,
        ]);
    }

    public function product_discount(Request $request)
    {
        $rowId = $request->id;
        $discount = floatval($request->discount);

        $cartItem = Cart::instance('pos_shopping')->get($rowId);
        if (!$cartItem) {
            return response()->json(['error' => 'Cart item not found'], 404);
        }

        // Update cart option
        $options = $cartItem->options->toArray();
        $options['product_discount'] = $discount;

        Cart::instance('pos_shopping')->update($rowId, [
            'qty' => $cartItem->qty,
            'options' => $options,
        ]);

        // Update database (overwrite)
        if (isset($options['details_id'])) {
            OrderDetails::where('id', $options['details_id'])
                ->update(['product_discount' => $discount]);
        }

        // Recalculate total product discount
        $totalProductDiscount = Cart::instance('pos_shopping')->content()
            ->sum(fn($item) => $item->options->product_discount ?? 0);

        // Coupon discount
        $couponDiscount = $cartItem->options['coupon_value'] ?? 0;

        $totalDiscount = $totalProductDiscount + $couponDiscount;

        // Update order discount
        Order::where('id', $options['order_id'])
            ->update(['discount' => $totalDiscount]);

        return response()->json([
            'success' => true,
            'total_discount' => $totalDiscount,
        ]);
    }

    public function cart_update(Request $request)
    {
        $rowId = $request->id;
        $cartItem = Cart::instance('pos_shopping')->get($rowId);

        if ($cartItem) {
            $options = $cartItem->options->toArray();

            if ($request->has('product_size')) {
                $options['product_size'] = $request->product_size;
            }
            if ($request->has('product_color')) {
                $options['product_color'] = $request->product_color;
            }
            if ($request->has('product_discount')) {
                $options['product_discount'] = $request->product_discount;
            }

            $updateData = ['options' => $options];

            if ($request->has('qty')) {
                $updateData['qty'] = $request->qty;
            }

            Cart::instance('pos_shopping')->update($rowId, $updateData);

            $updatedCartItem = Cart::instance('pos_shopping')->get($rowId);

            return response()->json([
                'success' => true,
                'cartItem' => $updatedCartItem,
            ]);
        }

        return response()->json(['success' => false]);
    }




    public function cart_shipping(Request $request)
    {
        $shipping = ShippingCharge::where(['status' => 1, 'id' => $request->id])->first()->amount;
        Session::put('pos_shipping', $shipping);

        return response()->json($shipping);
    }

    public function cart_clear($order_id)
    {
        // Get the order
        $order = Order::findOrFail($order_id);

        // Delete order details (only for this order)
        OrderDetails::where('order_id', $order->id)->delete();

        // Clear Cart instance
        Cart::instance('pos_shopping')->destroy();

        // Clear related sessions
        Session::forget('pos_shipping');
        Session::forget('pos_discount');
        Session::forget('product_discount');

        // Optionally, mark the order as cleared
        // $order->update(['status' => 'cleared']); // if you want

        return response()->json([
            'success' => true,
            'message' => 'Cart cleared successfully for this order!',
        ]);
    }

    public function order_edit($invoice_id)
    {
        // Active products
        $products = Product::select('id', 'name', 'new_price', 'product_code')
            ->where('status', 1)->get();

        // Active shipping charges
        $shippingcharge = ShippingCharge::where('status', 1)->get();

        // Load order with coupon
        $order = Order::with('coupon')->where('invoice_id', $invoice_id)->firstOrFail();

        // Clear cart before refill
        Cart::instance('pos_shopping')->destroy();

        // Shipping info
        $shippinginfo = Shipping::where('order_id', $order->id)->first();

        // Order details
        $orderdetails = OrderDetails::with('combo.images', 'image') // eager load
            ->where('order_id', $order->id)
            ->get();


        // Subtotal from order details
        $subtotal = $orderdetails->sum(fn($item) => $item->sale_price * $item->qty);

        // Coupon discount
        $couponDiscount = 0;
        if ($order->coupon) {
            $coupon = $order->coupon;
            $value = $coupon->value ?? 0;
            $maxDiscount = $coupon->max_discount ?? 0;

            if ($value > 0) {
                $couponDiscount = ($value / 100) * $subtotal;
                if ($maxDiscount > 0 && $couponDiscount > $maxDiscount) {
                    $couponDiscount = $maxDiscount;
                }
            } elseif ($maxDiscount > 0) {
                $couponDiscount = min($subtotal, $maxDiscount);
            }
        }

        // Save shipping and coupon discount in session
        Session::put('pos_shipping', $order->shipping_charge);
        Session::put('product_discount', $couponDiscount);

        // Refill cart
        if ($orderdetails->count() > 0) {
            foreach ($orderdetails as $ordetails) {

                if ($ordetails->product_type == 'combo') {
                    Cart::instance('pos_shopping')->add([
                        'id' => 'combo-' . $ordetails->combo_id, // keep as string
                        'name' => $ordetails->product_name,
                        'qty' => $ordetails->qty,
                        'price' => $ordetails->sale_price,
                        'options' => [
                            'is_combo' => true,
                            'combo_id' => $ordetails->combo_id,
                            'slug' => optional($ordetails->combo)->slug ?? '',
                            'image' => optional($ordetails->combo?->images->first())->image ?? 'public/default.png',
                            'purchase_price' => $ordetails->purchase_price,
                            'details_id' => $ordetails->id,
                            'product_type' => 'combo',
                        ],
                    ]);
                } elseif ($ordetails->product_type == 'combo_item' || $ordetails->product_type == 'normal') {

                    // 🖼️ প্রথম image select করা হচ্ছে (ascending order এ)
                    $productImage = optional($ordetails->product?->image)->image
                        ?? optional($ordetails->product?->images()->orderBy('id', 'asc')->first())->image
                        ?? 'public/default.png';

                    Cart::instance('pos_shopping')->add([
                        'id' => $ordetails->product_id,
                        'name' => $ordetails->product_name,
                        'qty' => $ordetails->qty,
                        'price' => $ordetails->sale_price,
                        'options' => [
                            'is_combo_item' => $ordetails->product_type == 'combo_item',
                            'parent_combo' => $ordetails->combo_id ? 'combo-' . $ordetails->combo_id : null,
                            'image' => $productImage, 
                            'purchase_price' => $ordetails->purchase_price,
                            'details_id' => $ordetails->id,
                            'product_size' => $ordetails->product_size,
                            'product_color' => $ordetails->product_color,
                            'product_discount' => $ordetails->discount_amount ?? 0,
                            'product_type' => $ordetails->product_type,
                        ],
                    ]);
                }

            }

        }

        // else {

        //     $cartinfo = Cart::instance('pos_shopping')->content();
        // }

        // Get cart content
        $cartinfo = Cart::instance('pos_shopping')->content();

        // Return edit page
        return view('backEnd.order.edit', compact(
            'products',
            'cartinfo',
            'shippingcharge',
            'shippinginfo',
            'order',
            'orderdetails'
        ));
    }

    public function order_update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'area' => 'required',
        ]);

        if (Cart::instance('pos_shopping')->count() <= 0) {
            Toastr::error('Your shopping empty', 'Failed!');

            return redirect()->back();
        }

        $subtotal = Cart::instance('pos_shopping')->subtotal();
        $subtotal = str_replace(',', '', $subtotal);
        $subtotal = str_replace('.00', '', $subtotal);
        $discount = Session::get('pos_discount') + Session::get('product_discount');
        $shippingfee = ShippingCharge::find($request->area);

        $exits_customer = Customer::where('phone', $request->phone)->select('phone', 'id')->first();
        if ($exits_customer) {
            $customer_id = $exits_customer->id;
        } else {
            $password = rand(111111, 999999);
            $store = new Customer;
            $store->name = $request->name;
            $store->slug = $request->name;
            $store->phone = $request->phone;
            $store->password = bcrypt($password);
            $store->verify = 1;
            $store->status = 'active';
            $store->save();
            $customer_id = $store->id;
        }

        // order data save
        $order = Order::where('id', $request->order_id)->first();
        $order->invoice_id = rand(11111, 99999);
        $order->amount = ($subtotal + $shippingfee->amount) - $discount;
        $order->discount = $discount ? $discount : 0;
        $order->shipping_charge = $shippingfee->amount;
        $order->customer_id = $customer_id;
        $order->order_status = 1;
        $order->note = $request->note;
        $order->save();

        // shipping data save
        $shipping = Shipping::where('order_id', $request->order_id)->first();
        $shipping->order_id = $order->id;
        $shipping->customer_id = $customer_id;
        $shipping->name = $request->name;
        $shipping->phone = $request->phone;
        $shipping->address = $request->address;
        $shipping->area = $shippingfee->name;
        $shipping->save();

        // payment data save
        $payment = Payment::where('order_id', $request->order_id)->first();
        $payment->order_id = $order->id;
        $payment->customer_id = $customer_id;
        $payment->payment_method = 'Cash On Delivery';
        $payment->amount = $order->amount;
        $payment->payment_status = 'pending';
        $payment->save();

        // order details data save
        foreach (Cart::instance('pos_shopping')->content() as $cart) {
            $exits = OrderDetails::where('id', $cart->options->details_id)->first();
            if ($exits) {
                $order_details = OrderDetails::find($exits->id);
                $order_details->product_discount = $cart->options->product_discount;
                $order_details->product_color = $cart->options->product_color;
                $order_details->product_size = $cart->options->product_size;
                $order_details->sale_price = $cart->price;
                $order_details->qty = $cart->qty;
                $order_details->save();
            } else {
                $order_details = new OrderDetails;
                $order_details->order_id = $order->id;
                $order_details->product_id = $cart->id;
                $order_details->product_name = $cart->name;
                $order_details->purchase_price = $cart->options->purchase_price;
                $order_details->product_discount = $cart->options->product_discount;
                $order_details->product_color = $cart->options->product_color;
                $order_details->product_size = $cart->options->product_size;
                $order_details->sale_price = $cart->price;
                $order_details->qty = $cart->qty;
                $order_details->save();
            }

        }
        Cart::instance('pos_shopping')->destroy();
        Session::forget('pos_shipping');
        Session::forget('pos_discount');
        Session::forget('product_discount');
        Toastr::success('Thanks, Your order place successfully', 'Success!');

        return redirect('admin/order/pending');
    }
}
