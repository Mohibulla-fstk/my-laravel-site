<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Review;
use App\Models\Combo;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    // function __construct()
    // {
    //      $this->middleware('permission:review-list|review-create|review-edit|review-delete', ['only' => ['index','store']]);
    //      $this->middleware('permission:review-create', ['only' => ['create','store']]);
    //      $this->middleware('permission:review-edit', ['only' => ['edit','update']]);
    //      $this->middleware('permission:review-delete', ['only' => ['destroy']]);
    // }

    public function index(Request $request)
    {
        // Product reviews
        $productReviews = Review::whereNotNull('product_id')
            ->with('product', 'customer')
            ->get();

        // Combo reviews
        $comboReviews = Review::whereNotNull('combo_id')
            ->with('combo', 'customer')
            ->get();

        // উভয় merge
        $show_data = $productReviews->merge($comboReviews)
            ->sortByDesc('id'); // latest first

        return view('backEnd.review.index', compact('show_data'));
    }


    public function create()
    {
        $products = Product::where(['status' => 1])->select('id', 'name')->get();
        $customers = Customer::where('status', 'active')->get();

        return view('backEnd.review.create', compact('products', 'customers'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'customer_id' => 'required',
            'ratting' => 'required',
            'review' => 'required',
            'product_id' => 'required',
            'status' => 'required',
        ]);
        $customer = Customer::where('id', $request->customer_id)->first();
        $input = $request->all();
        $input['name'] = $customer->name ? $customer->name : 'N / A';
        $input['email'] = $customer->email ? $customer->email : 'N / A';
        $input['status'] = $request->status == 1 ? '1' : 'pending';
        Review::create($input);
        Toastr::success('Success', 'Data insert successfully');

        return redirect()->route('reviews.index');
    }
    public function storeComboReview(Request $request)
    {
        $this->validate($request, [
            'combo_id' => 'required|exists:combos,id',
            'ratting' => 'required|integer|min:1|max:5',
            'review' => 'required|string|max:1000',
        ]);

        $customer = Auth::guard('customer')->user();

        $input = $request->all();
        $input['customer_id'] = $customer->id;
        $input['name'] = $customer->name ?? 'N / A';
        $input['email'] = $customer->email ?? 'N / A';
        $input['status'] = 1; // approved
        $input['product_id'] = 0;
        Review::create($input);

        return back()->with('success', 'Combo review submitted successfully!');
    }

    public function edit($id)
    {
        $edit_data = Review::find($id);
        $products = Product::where(['status' => 1])->select('id', 'name')->get();
        $combos = Combo::where('status', 1)->get();
        return view('backEnd.review.edit', compact('edit_data', 'products', 'combos'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'ratting' => 'required|integer|min:1|max:5',
            'review' => 'required|string|max:1000',
            'reviewable_id' => 'required|integer', // product বা combo উভয়ের ID
        ]);

        $review = Review::find($request->hidden_id);
        if (!$review) {
            return redirect()->back()->with('error', 'Review not found');
        }

        $selected_id = $request->reviewable_id;

        // product বা combo চেক
        if (\App\Models\Product::where('id', $selected_id)->exists()) {
            $review->product_id = $selected_id;
            $review->combo_id = null;
        } elseif (\App\Models\Combo::where('id', $selected_id)->exists()) {
            $review->combo_id = $selected_id;
            $review->product_id = 0;
        }

        $review->name = $request->name;
        $review->email = $request->email;
        $review->ratting = $request->ratting;
        $review->review = $request->review;
        $review->status = $request->status == 1 ? '1' : 'pending';

        $review->save();

        Toastr::success('Success', 'Data updated successfully');
        return redirect()->route('reviews.index');
    }


    public function pending()
    {
        $data = Review::where('status', 'pending')->get();

        return view('backEnd.review.pending', compact('data'));
    }

    public function inactive(Request $request)
    {
        $inactive = Review::find($request->hidden_id);
        $inactive->status = 'pending';
        $inactive->save();
        Toastr::success('Success', 'Data inactive successfully');

        return redirect()->back();
    }

    public function active(Request $request)
    {
        $active = Review::find($request->hidden_id);
        $active->status = 'active';
        $active->save();

        $product = Product::select('id', 'ratting')->find($active->product_id);
        $product->ratting += 1;
        $product->save();
        Toastr::success('Success', 'Data active successfully');

        return redirect()->back();
    }

    public function destroy(Request $request)
    {
        $delete_data = Review::find($request->hidden_id);
        $delete_data->delete();
        Toastr::success('Success', 'Data delete successfully');

        return redirect()->back();
    }
}
