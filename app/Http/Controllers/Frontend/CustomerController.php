<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\BaseCustomerController;
use App\Models\Customer;
use App\Models\District;
use App\Models\GeneralSetting;
use App\Models\Order;
use App\Mail\OrderPlace;
use App\Models\OrderDetails;
use Illuminate\Support\Facades\Mail;
use App\Models\Payment;
use App\Models\PaymentGateway;
use App\Models\Review;
use App\Models\Shipping;
use App\Models\ShippingCharge;
use App\Models\SmsGateway;
use App\Models\Product;
use App\Models\Combo;
use App\Models\Category;
use App\Models\Size;
use Auth;
use Brian2694\Toastr\Facades\Toastr;
use Cart;
use DB;
use Hash;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Session;
use shurjopayv2\ShurjopayLaravelPackage8\Http\Controllers\ShurjopayController;
use Str;

class CustomerController extends BaseCustomerController
{
    public function __construct()
    {
        $this->middleware('customer', ['except' => ['signup', 'store', 'verify', 'resendotp', 'account_verify', 'login', 'signin', 'logout', 'checkout', 'forgot_password', 'forgot_verify', 'forgot_reset', 'forgot_store', 'forgot_resend', 'order_save', 'order_success', 'order_track', 'order_track_result']]);
    }

    public function review(Request $request)
    {
        $this->validate($request, [
            'ratting' => 'required',
            'review' => 'required',
        ]);

        // data save
        $review = new Review;
        $review->name = Auth::guard('customer')->user()->name ? Auth::guard('customer')->user()->name : 'N / A';
        $review->email = Auth::guard('customer')->user()->email ? Auth::guard('customer')->user()->email : 'N / A';
        $review->product_id = $request->product_id;
        $review->review = $request->review;
        $review->ratting = $request->ratting;
        $review->customer_id = Auth::guard('customer')->user()->id;
        $review->status = 'pending';
        $review->save();
        $product = Product::find($request->product_id);
        notify(
            null,
            'New Review!',
            'You got "' . $request->ratting . ' star" rating by ' 
            . Auth::guard('customer')->user()->name 
            . ' on the product "' . ($product->name ?? 'N/A') . '".',
            'review', 
            route('reviews.index')
        );
        Toastr::success('Thanks, Your review send successfully', 'Success!');

        return redirect()->back();
    }

    public function login()
    {
        $products = Product::where('status', 1);
        $category = $subcategory = $childcategory = null;
        $subcategories = collect();
        $childcategories = collect();
        $all_categories = Category::where('status', 1)->get();
        $all_sizes = Size::select('sizeName')->distinct()->get();


        return view('frontEnd.layouts.customer.login', compact(
            'products',
            'category',
            'subcategories',
            'childcategories',
            'all_categories',
            'all_sizes',

        ));
    }

    public function signin(Request $request)
    {
        $auth_check = Customer::where('phone', $request->phone)->first();
        if ($auth_check) {
            if (Auth::guard('customer')->attempt(['phone' => $request->phone, 'password' => $request->password])) {
                Toastr::success('You are login successfully', 'success!');
                if (Cart::instance('shopping')->count() > 0) {
                    return redirect()->route('customer.checkout');
                }

                return redirect()->intended('customer/account');
            }
            Toastr::error('message', 'Opps! your phone or password wrong');

            return redirect()->back();
        } else {
            Toastr::error('message', 'Sorry! You have no account');

            return redirect()->back();
        }
    }

    public function signup()
    {
        $products = Product::where('status', 1);
        $category = $subcategory = $childcategory = null;
        $subcategories = collect();
        $childcategories = collect();
        $all_categories = Category::where('status', 1)->get();
        $all_sizes = Size::select('sizeName')->distinct()->get();


        return view('frontEnd.layouts.customer.signup', compact(
            'products',
            'category',
            'subcategories',
            'childcategories',
            'all_categories',
            'all_sizes',

        ));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required|unique:customers',
            'password' => 'required|min:6',
        ]);

        $last_id = Customer::orderBy('id', 'desc')->first();
        $last_id = $last_id ? $last_id->id + 1 : 1;
        $store = new Customer;
        $store->name = $request->name;
        $store->slug = strtolower(Str::slug($request->name . '-' . $last_id));
        $store->phone = $request->phone;
        $store->email = $request->email;
        $store->password = bcrypt($request->password);
        $store->verify = 1;
        $store->status = 'active';
        $store->save();

        Toastr::success('Success', 'Account Create Successfully');

        return redirect()->route('customer.login');
    }

    public function verify()
    {
        return view('frontEnd.layouts.customer.verify');
    }

    public function resendotp(Request $request)
    {
        $customer_info = Customer::where('phone', session::get('verify_phone'))->first();
        $customer_info->verify = rand(1111, 9999);
        $customer_info->save();
        $site_setting = GeneralSetting::where('status', 1)->first();
        $sms_gateway = SmsGateway::where('status', 1)->first();
        if ($sms_gateway) {
            $url = "$sms_gateway->url";
            $data = [
                'api_key' => "$sms_gateway->api_key",
                'number' => $customer_info->phone,
                'type' => 'text',
                'senderid' => "$sms_gateway->serderid",
                'message' => "Dear $customer_info->name!\r\nYour account verify OTP is $customer_info->verify \r\nThank you for using $site_setting->name",
            ];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec($ch);
            curl_close($ch);

        }
        Toastr::success('Success', 'Resend code send successfully');

        return redirect()->back();
    }

    public function account_verify(Request $request)
    {
        $this->validate($request, [
            'otp' => 'required',
        ]);
        $customer_info = Customer::where('phone', session::get('verify_phone'))->first();
        if ($customer_info->verify != $request->otp) {
            Toastr::error('Success', 'Your OTP not match');

            return redirect()->back();
        }

        $customer_info->verify = 1;
        $customer_info->status = 'active';
        $customer_info->save();
        Auth::guard('customer')->loginUsingId($customer_info->id);

        return redirect()->route('customer.account');
    }

    public function forgot_password()
    {
        $products = Product::where('status', 1);
        $category = $subcategory = $childcategory = null;
        $subcategories = collect();
        $childcategories = collect();
        $all_categories = Category::where('status', 1)->get();
        $all_sizes = Size::select('sizeName')->distinct()->get();

        return view('frontEnd.layouts.customer.forgot_password', compact(
            'products',
            'category',
            'subcategories',
            'childcategories',
            'all_categories',
            'all_sizes',

        ));

    }

    public function forgot_verify(Request $request)
    {
        $customer_info = Customer::where('phone', $request->phone)->first();
        if (!$customer_info) {
            Toastr::error('Your phone number not found');

            return back();
        }
        $customer_info->forgot = rand(1111, 9999);
        $customer_info->save();
        $site_setting = GeneralSetting::where('status', 1)->first();
        $sms_gateway = SmsGateway::where(['status' => 1, 'forget_pass' => 1])->first();
        if ($sms_gateway) {
            $url = "$sms_gateway->url";
            $data = [
                'api_key' => "$sms_gateway->api_key",
                'number' => $customer_info->phone,
                'type' => 'text',
                'senderid' => "$sms_gateway->serderid",
                'message' => "Dear $customer_info->name!\r\nYour forgot password verify OTP is $customer_info->forgot \r\nThank you for using $site_setting->name",
            ];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec($ch);
            curl_close($ch);
        }

        session::put('verify_phone', $request->phone);
        Toastr::success('Your account register successfully');

        return redirect()->route('customer.forgot.reset');
    }

    public function forgot_resend(Request $request)
    {
        $customer_info = Customer::where('phone', session::get('verify_phone'))->first();
        $customer_info->forgot = rand(1111, 9999);
        $customer_info->save();
        $site_setting = GeneralSetting::where('status', 1)->first();
        $sms_gateway = SmsGateway::where(['status' => 1])->first();
        if ($sms_gateway) {
            $url = "$sms_gateway->url";
            $data = [
                'api_key' => "$sms_gateway->api_key",
                'number' => $customer_info->phone,
                'type' => 'text',
                'senderid' => "$sms_gateway->serderid",
                'message' => "Dear $customer_info->name!\r\nYour forgot password verify OTP is $customer_info->forgot \r\nThank you for using $site_setting->name",
            ];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec($ch);
            curl_close($ch);

        }

        Toastr::success('Success', 'Resend code send successfully');

        return redirect()->back();
    }

    public function forgot_reset()
    {
        if (!Session::get('verify_phone')) {
            Toastr::error('Something wrong please try again');

            return redirect()->route('customer.forgot.password');
        }
        $products = Product::where('status', 1);
        $category = $subcategory = $childcategory = null;
        $subcategories = collect();
        $childcategories = collect();
        $all_categories = Category::where('status', 1)->get();
        $all_sizes = Size::select('sizeName')->distinct()->get();

        return view('frontEnd.layouts.customer.forgot_reset', compact(
            'products',
            'category',
            'subcategories',
            'childcategories',
            'all_categories',
            'all_sizes',

        ));

    }

    public function forgot_store(Request $request)
    {

        $customer_info = Customer::where('phone', session::get('verify_phone'))->first();

        if ($customer_info->forgot != $request->otp) {
            Toastr::error('Success', 'Your OTP not match');

            return redirect()->back();
        }

        $customer_info->forgot = 1;
        $customer_info->password = bcrypt($request->password);
        $customer_info->save();
        if (Auth::guard('customer')->attempt(['phone' => $customer_info->phone, 'password' => $request->password])) {
            Session::forget('verify_phone');
            Toastr::success('You are login successfully', 'success!');

            return redirect()->intended('customer/account');
        }
    }

    public function account()
    {
        $products = Product::where('status', 1);
        $category = $subcategory = $childcategory = null;
        $subcategories = collect();
        $childcategories = collect();
        $all_categories = Category::where('status', 1)->get();
        $all_sizes = Size::select('sizeName')->distinct()->get();



        return view('frontEnd.layouts.customer.account', compact(
            'products',
            'category',
            'subcategories',
            'childcategories',
            'all_categories',
            'all_sizes',

        ));
    }

    public function logout(Request $request)
    {
        Auth::guard('customer')->logout();
        Toastr::success('You are logout successfully', 'success!');

        return redirect()->route('customer.login');
    }

    public function checkout()
    {
        $shippingcharge = ShippingCharge::where('status', 1)->get();
        $select_charge = ShippingCharge::where('status', 1)->first();
        $bkash_gateway = PaymentGateway::where(['status' => 1, 'type' => 'bkash'])->first();
        $shurjopay_gateway = PaymentGateway::where(['status' => 1, 'type' => 'shurjopay'])->first();
        $products = Product::where('status', 1);
        $category = $subcategory = $childcategory = null;
        $subcategories = collect();
        $childcategories = collect();
        $all_categories = Category::where('status', 1)->get();
        $all_sizes = Size::select('sizeName')->distinct()->get();

        Session::put('shipping', $select_charge->amount);

        $order = Order::latest()->first();

        // Mail::to('customer@gmail.com')->send(new OrderPlace($order));
        // ------------------------------

        return view('frontEnd.layouts.customer.checkout', compact(
            'shippingcharge',
            'bkash_gateway',
            'shurjopay_gateway',
            'products',
            'category',
            'subcategories',
            'childcategories',
            'all_categories',
            'all_sizes',

        ));
    }

    public function order_save(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'note' => 'nullable',
            'area' => 'required',
            'payment_method' => 'required',
        ]);

        if (Cart::instance('shopping')->count() <= 0) {
            Toastr::error('Your shopping cart is empty', 'Failed!');

            return redirect()->back();
        }

        // Cart subtotal
        $subtotal = Cart::instance('shopping')->subtotal();
        $subtotal = str_replace(',', '', $subtotal);
        $subtotal = str_replace('.00', '', $subtotal);

        // Shipping
        $shippingfee = Session::get('shipping') ?? 0;
        $shipping_area = ShippingCharge::where('id', $request->area)->first();

        // Coupon session
        $coupon = Session::get('coupon');
        $discount = $coupon['discount'] ?? 0;
        $coupon_id = $coupon['id'] ?? null;

        // Customer check / create
        if (Auth::guard('customer')->check()) {
            $customer_id = Auth::guard('customer')->user()->id;
        } else {
            $existing_customer = Customer::where('phone', $request->phone)->first();
            if ($existing_customer) {
                $customer_id = $existing_customer->id;
            } else {
                $password = rand(111111, 999999);
                $store = new Customer;
                $store->name = $request->name;
                $store->slug = Str::slug($request->name);
                $store->phone = $request->phone;
                $store->password = bcrypt($password);
                $store->verify = 1;
                $store->status = 'active';
                $store->save();
                $customer_id = $store->id;
            }
        }

        // Order save
        $order = new Order;
        $order->invoice_id = rand(11111, 99999);
        $order->amount = ($subtotal + $shippingfee) - $discount;
        $order->shipping_charge = $shippingfee;
        $order->customer_id = $customer_id;
        $order->order_status = 1;
        $order->note = $request->note ?? null;

        // Coupon & discount
        $order->discount = $discount ?? 0; // এটা add করতে হবে
        $order->discount_amount = $discount ?? 0;
        $order->coupon_id = $coupon_id;

        $order->save();

        // Shipping save
        $shipping = new Shipping;
        $shipping->order_id = $order->id;
        $shipping->customer_id = $customer_id;
        $shipping->name = $request->name;
        $shipping->phone = $request->phone;
        $shipping->address = $request->address;
        $shipping->note = $request->note;
        $shipping->area = $shipping_area->name;
        $shipping->save();

        // Payment save
        $payment = new Payment;
        $payment->order_id = $order->id;
        $payment->customer_id = $customer_id;
        $payment->payment_method = $request->payment_method;
        $payment->amount = $order->amount;
        $payment->payment_status = 'pending';
        $payment->save();

        // Order details save

        foreach (Cart::instance('shopping')->content() as $cart) {
            $order_details = new OrderDetails;
            $order_details->order_id = $order->id;

            // Combo or normal
            if (isset($cart->options['is_combo']) && $cart->options['is_combo']) {
                $order_details->product_type = 'combo';
                $order_details->combo_id = $cart->options['combo_id'] ?? null; // main combo id
                $order_details->product_id = null; // combo main এর জন্য null
                $order_details->review_id = '1';

            } elseif (isset($cart->options['is_combo_item'])) {
                // combo_item skip
                continue;

            } else {
                $order_details->product_type = 'normal';
                $order_details->product_id = $cart->id;
                $order_details->combo_id = null;
                $order_details->review_id = '1';
            }

            $order_details->product_name = $cart->name;
            $order_details->purchase_price = $cart->options->purchase_price ?? 0;
            $order_details->product_color = $cart->options->product_color ?? null;
            $order_details->product_size = $cart->options->product_size ?? null;
            $order_details->sale_price = $cart->price;
            $order_details->qty = $cart->qty;

            // Product-specific discount
            if ($coupon && isset($coupon['product_id']) && $cart->id == $coupon['product_id']) {
                $order_details->discount_amount = $coupon['discount'];
            } else {
                $order_details->discount_amount = 0;
            }
            $order_details->coupon_name = $coupon['code'] ?? null;
            $order_details->coupon_discount_amount = $coupon['discount'] ?? 0;
            $order_details->save();

            // ✅ Normal product stock decrement
            if ($order_details->product_id) {
                $product = Product::find($order_details->product_id);
                if ($product) {
                    $product->stock = max(0, $product->stock - $order_details->qty);
                    $product->save();
                }
            }

            // ✅ Combo main stock decrement + combo items save
            if (isset($cart->options['is_combo']) && $cart->options['is_combo']) {
                // Combo table থেকে stock কমানো
                if ($order_details->combo_id) {
                    $combo = Combo::find($order_details->combo_id);
                    if ($combo) {
                        $combo->stock = max(0, $combo->stock - $order_details->qty);
                        $combo->save();
                    }
                }

                // Combo items save + stock decrement
                foreach ($cart->options['combo_items'] ?? [] as $p) {
                    $order_details_item = new OrderDetails;
                    $order_details_item->order_id = $order->id;
                    $order_details_item->product_type = 'combo_item';
                    $order_details_item->combo_id = $cart->options['combo_id'] ?? null;
                    $order_details_item->product_id = $p['id'];
                    $order_details_item->product_name = $p['name'];
                    $order_details_item->purchase_price = 0; // combo main price already saved
                    $order_details_item->product_color = $p['color'] ?? null;
                    $order_details_item->product_size = $p['size'] ?? null;
                    $order_details_item->sale_price = 0;
                    $order_details_item->qty = 1;
                    $order_details_item->discount_amount = 0;
                    $order_details_item->save();

                    // Combo item stock decrement
                    if ($order_details_item->product_id) {
                        $productItem = Product::find($order_details_item->product_id);

                        if ($productItem) {
                            $productItem->stock = max(0, $productItem->stock - 1);
                            $productItem->save();
                        }
                    }
                }
            }
        }





        // Clear cart & coupon session
        Cart::instance('shopping')->destroy();
        Session::forget('coupon');
// ✅ Send notification for all users
        notify(
            null, // null = all users
            'New Order Placed',
            'Order #' . $order->invoice_id . ' has been placed by ' . $request->name,
            'order',
            route('admin.orders', ['slug' => 'pending']) // admin orders page link
        );

        Toastr::success('Thanks, Your order has been placed successfully', 'Success!');

        // Redirect according to payment method
        if ($request->payment_method == 'bkash') {
            return redirect('/bkash/checkout-url/create?order_id=' . $order->id);
        } elseif ($request->payment_method == 'shurjopay') {
            $info = [
                'currency' => 'BDT',
                'amount' => $order->amount,
                'order_id' => uniqid(),
                'discsount_amount' => $discount,
                'disc_percent' => 0,
                'client_ip' => $request->ip(),
                'customer_name' => $request->name,
                'customer_phone' => $request->phone,
                'email' => $request->email ?? 'customer@gmail.com',
                'customer_address' => $request->address,
                'customer_city' => $request->area,
                'customer_state' => $request->area,
                'customer_postcode' => '1212',
                'customer_country' => 'BD',
                'value1' => $order->id,
            ];
            $shurjopay_service = new ShurjopayController;

            return $shurjopay_service->checkout($info);
        } else {
            return redirect('customer/order-success/' . $order->id);
        }
    }

    public function orders()
    {
        $products = Product::where('status', 1);
        $category = $subcategory = $childcategory = null;
        $subcategories = collect();
        $childcategories = collect();
        $all_categories = Category::where('status', 1)->get();
        $all_sizes = Size::select('sizeName')->distinct()->get();

        $orders = Order::where('customer_id', Auth::guard('customer')->user()->id)->with('status')->latest()->get();

        return view('frontEnd.layouts.customer.orders', compact(
            'orders',
            'products',
            'category',
            'subcategories',
            'childcategories',
            'all_categories',
            'all_sizes',

        ));
    }

    public function order_success($id)
    {
        $products = Product::where('status', 1);
        $category = $subcategory = $childcategory = null;
        $subcategories = collect();
        $childcategories = collect();
        $all_categories = Category::where('status', 1)->get();
        $all_sizes = Size::select('sizeName')->distinct()->get();

        $order = Order::where('id', $id)->firstOrFail();

        return view('frontEnd.layouts.customer.order_success', compact(
            'order',
            'products',
            'category',
            'subcategories',
            'childcategories',
            'all_categories',
            'all_sizes',

        ));
    }

    public function invoice(Request $request)
    {
        $products = Product::where('status', 1);
        $category = $subcategory = $childcategory = null;
        $subcategories = collect();
        $childcategories = collect();
        $all_categories = Category::where('status', 1)->get();
        $all_sizes = Size::select('sizeName')->distinct()->get();

        $order = Order::where(['id' => $request->id, 'customer_id' => Auth::guard('customer')->user()->id])->with('orderdetails', 'payment', 'shipping', 'customer')->firstOrFail();

        return view('frontEnd.layouts.customer.invoice', compact(
            'order',
            'products',
            'category',
            'subcategories',
            'childcategories',
            'all_categories',
            'all_sizes',

        ));
    }

    public function order_note(Request $request)
    {
        $order = Order::where(['id' => $request->id, 'customer_id' => Auth::guard('customer')->user()->id])->firstOrFail();

        return view('frontEnd.layouts.customer.order_note', compact('order'));
    }

    public function profile_edit(Request $request)
    {
        $products = Product::where('status', 1);
        $category = $subcategory = $childcategory = null;
        $subcategories = collect();
        $childcategories = collect();
        $all_categories = Category::where('status', 1)->get();
        $all_sizes = Size::select('sizeName')->distinct()->get();

        $profile_edit = Customer::where(['id' => Auth::guard('customer')->user()->id])->firstOrFail();
        $districts = District::distinct()->select('district')->get();
        $areas = District::where(['district' => $profile_edit->district])->select('area_name', 'id')->get();

        return view('frontEnd.layouts.customer.profile_edit', compact(
            'profile_edit',
            'districts',
            'areas',
            'products',
            'category',
            'subcategories',
            'childcategories',
            'all_categories',
            'all_sizes',

        ));
    }

    public function profile_update(Request $request)
    {
        $update_data = Customer::where(['id' => Auth::guard('customer')->user()->id])->firstOrFail();

        $image = $request->file('image');
        if ($image) {
            // image with intervention
            $name = time() . '-' . $image->getClientOriginalName();
            $name = preg_replace('"\.(jpg|jpeg|png|webp)$"', '.webp', $name);
            $name = strtolower(Str::slug($name));
            $uploadpath = 'public/uploads/customer/';
            $imageUrl = $uploadpath . $name;
            $img = Image::make($image->getRealPath());
            $img->encode('webp', 90);
            $width = 120;
            $height = 120;
            $img->resize($width, $height);
            $img->save($imageUrl);
        } else {
            $imageUrl = $update_data->image;
        }

        $update_data->name = $request->name;
        $update_data->phone = $request->phone;
        $update_data->email = $request->email;
        $update_data->address = $request->address;
        $update_data->district = $request->district;
        $update_data->area = $request->area;
        $update_data->image = $imageUrl;
        $update_data->save();

        Toastr::success('Your profile update successfully', 'Success!');

        return redirect()->route('customer.account');
    }

    public function order_track()
    {
        $products = Product::where('status', 1);
        $category = $subcategory = $childcategory = null;
        $subcategories = collect();
        $childcategories = collect();
        $all_categories = Category::where('status', 1)->get();
        $all_sizes = Size::select('sizeName')->distinct()->get();

        return view('frontEnd.layouts.customer.order_track', compact(
            'products',
            'category',
            'subcategories',
            'childcategories',
            'all_categories',
            'all_sizes',

        ));
    }

    public function order_track_result(Request $request)
    {

        $phone = $request->phone;
        $invoice_id = $request->invoice_id;
        $products = Product::where('status', 1);
        $category = $subcategory = $childcategory = null;
        $subcategories = collect();
        $childcategories = collect();
        $all_categories = Category::where('status', 1)->get();
        $all_sizes = Size::select('sizeName')->distinct()->get();

        if ($phone != null && $invoice_id == null) {
            $order = DB::table('orders')
                ->join('shippings', 'orders.id', '=', 'shippings.order_id')
                ->where(['shippings.phone' => $request->phone])
                ->get();

        } elseif ($invoice_id && $phone) {
            $order = DB::table('orders')
                ->join('shippings', 'orders.id', '=', 'shippings.order_id')
                ->where(['orders.invoice_id' => $request->invoice_id, 'shippings.phone' => $request->phone])
                ->get();
        }

        if ($order->count() == 0) {

            Toastr::error('message', 'Something Went Wrong !');

            return redirect()->back();
        }

        //   return $order->count();

        return view('frontEnd.layouts.customer.tracking_result', compact(
            'order',
            'products',
            'category',
            'subcategories',
            'childcategories',
            'all_categories',
            'all_sizes',

        ));
    }

    public function change_pass()
    {
        $products = Product::where('status', 1);
        $category = $subcategory = $childcategory = null;
        $subcategories = collect();
        $childcategories = collect();
        $all_categories = Category::where('status', 1)->get();
        $all_sizes = Size::select('sizeName')->distinct()->get();

        return view('frontEnd.layouts.customer.change_password', compact(
            'products',
            'category',
            'subcategories',
            'childcategories',
            'all_categories',
            'all_sizes',

        ));
    }

    public function password_update(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required',
            'new_password' => 'required',
            'confirm_password' => 'required_with:new_password|same:new_password|',
        ]);

        $customer = Customer::find(Auth::guard('customer')->user()->id);
        $hashPass = $customer->password;

        if (Hash::check($request->old_password, $hashPass)) {

            $customer->fill([
                'password' => Hash::make($request->new_password),
            ])->save();

            Toastr::success('Success', 'Password changed successfully!');

            return redirect()->route('customer.account');
        } else {
            Toastr::error('Failed', 'Old password not match!');

            return redirect()->back();
        }
    }
}
