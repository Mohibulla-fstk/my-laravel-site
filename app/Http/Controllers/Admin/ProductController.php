<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Childcategory;
use App\Models\Color;
use App\Models\Product;
use App\Models\Productcolor;
use App\Models\Productimage;
use App\Models\Productprice;
use App\Models\Productsize;
use App\Models\Size;
use App\Models\Subcategory;
use DB;
use File;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Toastr;

class ProductController extends Controller
{
    public function getSubcategory(Request $request)
    {
        $subcategory = DB::table('subcategories')
            ->where('category_id', $request->category_id)
            ->pluck('subcategoryName', 'id');

        return response()->json($subcategory);
    }

    public function getChildcategory(Request $request)
    {
        $childcategory = DB::table('childcategories')
            ->where('subcategory_id', $request->subcategory_id)
            ->pluck('childcategoryName', 'id');

        return response()->json($childcategory);
    }

    public function __construct()
    {
        $this->middleware('permission:product-list|product-create|product-edit|product-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:product-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:product-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:product-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        if ($request->keyword) {
            $data = Product::orderBy('id', 'DESC')->where('name', 'LIKE', '%' . $request->keyword . '%')->with('image', 'category')->paginate(50);
        } else {
            $data = Product::orderBy('id', 'DESC')->with('image', 'category')->paginate(50);
        }

        return view('backEnd.product.index', compact('data'));
    }



    public function create()
    {
        $categories = Category::where('parent_id', '=', '0')->where('status', 1)->select('id', 'name', 'status')->with('childrenCategories')->get();
        $brands = Brand::where('status', '1')->select('id', 'name', 'status')->get();
        $colors = Color::where('status', '1')->get();
        $sizes = Size::where('status', '1')->get();

        return view('backEnd.product.create', compact('categories', 'brands', 'colors', 'sizes'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'category_id' => 'required',
            'new_price' => 'required',
            'purchase_price' => 'required',
            'stock' => 'required',
            'category_id' => 'required',
            'description' => 'required',
        ]);
        $last_id = Product::orderBy('id', 'desc')->select('id')->first();
        $last_id = $last_id ? $last_id->id + 1 : 1;
        $input = $request->except(['image', 'files', 'proSize', 'proColor']);

        $input['slug'] = strtolower(preg_replace('/[\/\s]+/', '-', $request->name . '-' . $last_id));
        $input['pro_video'] = $this->getEmbedVideoUrl($request->pro_video);
        $input['status'] = $request->status ? 1 : 0;
        $input['topsale'] = $request->topsale ? 1 : 0;
        $input['feature_product'] = $request->feature_product ? 1 : 0;
        $input['product_code'] = 'NM' . str_pad($last_id, 4, '0', STR_PAD_LEFT);
        $save_data = Product::create($input);
        $save_data->sizes()->attach($request->proSize);
        $save_data->colors()->attach($request->proColor);

        $images = $request->file('image');
        if ($images) {
            foreach ($images as $key => $image) {
                if ($image->isValid()) {
                    // আসল নাম থেকে clean নাম বানানো
                    $name = time() . '-' . $image->getClientOriginalName();
                    $name = preg_replace('"\.(jpg|jpeg|png|gif|webp)$"', '.webp', $name);
                    $name = strtolower(Str::slug(pathinfo($name, PATHINFO_FILENAME))) . '-' . $key . '.webp';

                    $uploadPath = 'public/uploads/product/';
                    $imageUrl = $uploadPath . $name;

                    // Intervention দিয়ে convert to webp
                    $img = Image::make($image->getRealPath());
                    $img->encode('webp', 70);
                    $img->save($imageUrl);

                    // Database এ save
                    $pimage = new Productimage;
                    $pimage->product_id = $save_data->id;
                    $pimage->image = $imageUrl;
                    $pimage->save();
                }
            }
        }
        Toastr::success('Success', 'Data insert successfully');

        return redirect()->route('products.index');
    }

    public function edit($id)
    {
        $edit_data = Product::with('images')->find($id);
        $categories = Category::where('parent_id', '=', '0')->where('status', 1)->select('id', 'name', 'status')->get();
        $categoryId = Product::find($id)->category_id;
        $subcategoryId = Product::find($id)->subcategory_id;
        $subcategory = Subcategory::where('category_id', '=', $categoryId)->select('id', 'subcategoryName', 'status')->get();
        $childcategory = Childcategory::where('subcategory_id', '=', $subcategoryId)->select('id', 'childcategoryName', 'status')->get();
        $brands = Brand::where('status', '1')->select('id', 'name', 'status')->get();
        $totalsizes = Size::where('status', 1)->get();
        $totalcolors = Color::where('status', 1)->get();
        $selectcolors = Productcolor::where('product_id', $id)->get();
        $selectsizes = Productsize::where('product_id', $id)->get();

        return view('backEnd.product.edit', compact('edit_data', 'categories', 'subcategory', 'childcategory', 'brands', 'selectcolors', 'selectsizes', 'totalsizes', 'totalcolors'));
    }

    public function price_edit()
    {
        $products = DB::table('products')->select('id', 'name', 'status', 'old_price', 'new_price', 'stock','stockstatus')->where('status', 1)->get();

        return view('backEnd.product.price_edit', compact('products'));
    }

    public function price_update(Request $request)
    {
        $ids = $request->ids;
        $oldPrices = $request->old_price;
        $newPrices = $request->new_price;
        $stocks = $request->stock;
        $stockstatuss = $request->stockstatus;
        foreach ($ids as $key => $id) {
            $product = Product::select('id', 'name', 'status', 'old_price', 'new_price', 'stock')->find($id);

            if ($product) {
                $product->update([
                    'old_price' => $oldPrices[$key],
                    'new_price' => $newPrices[$key],
                    'stock' => $stocks[$key],
                    'stockstatus' => $stockstatuss[$key],
                ]);
            }
        }
        Toastr::success('Success', 'Price update successfully');

        return redirect()->back();
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'category_id' => 'required',
            'new_price' => 'required',
            'purchase_price' => 'required',
            'stock' => 'required',
            'category_id' => 'required',
            'description' => 'required',
        ]);

        $update_data = Product::find($request->id);
        $input = $request->except(['image', 'files', 'proSize', 'proColor']);
        $last_id = Product::orderBy('id', 'desc')->select('id')->first();
        $input['slug'] = strtolower(preg_replace('/[\/\s]+/', '-', $request->name . '-' . $last_id->id));
        $input['status'] = $request->status ? 1 : 0;
        $input['topsale'] = $request->topsale ? 1 : 0;
        $input['feature_product'] = $request->feature_product ? 1 : 0;
        $input['pro_video'] = $this->getEmbedVideoUrl($request->pro_video);
        $update_data->update($input);
        $update_data->sizes()->sync($request->proSize);
        $update_data->colors()->sync($request->proColor);

        // image with intervention
          $images = $request->file('image');
        if ($images) {
            foreach ($images as $key => $image) {
                if ($image->isValid()) {
                    // মূল নাম থেকে clean নাম বানানো এবং webp extension
                    $name = time() . '-' . $image->getClientOriginalName();
                    $name = preg_replace('"\.(jpg|jpeg|png|gif|webp)$"', '.webp', $name);
                    $name = strtolower(Str::slug(pathinfo($name, PATHINFO_FILENAME))) . '-' . $key . '.webp';

                    $uploadPath = 'public/uploads/product/';
                    $imageUrl = $uploadPath . $name;

                    // Intervention দিয়ে শুধু webp এ convert
                    $img = Image::make($image->getRealPath());
                    $img->encode('webp', 70);
                    $img->save($imageUrl);

                    // Database এ save
                    $pimage = new Productimage;
                    $pimage->product_id = $update_data->id; // update data id ব্যবহার
                    $pimage->image = $imageUrl;
                    $pimage->save();
                }
            }
        }

        Toastr::success('Success', 'Data update successfully');

        return redirect()->route('products.index');
    }

    public function inactive(Request $request)
    {
        $inactive = Product::find($request->hidden_id);
        $inactive->status = 0;
        $inactive->save();
        Toastr::success('Success', 'Data inactive successfully');

        return redirect()->back();
    }

    public function active(Request $request)
    {
        $active = Product::find($request->hidden_id);
        $active->status = 1;
        $active->save();
        Toastr::success('Success', 'Data active successfully');

        return redirect()->back();
    }

    public function destroy(Request $request)
    {
        $delete_data = Product::find($request->hidden_id);
        $delete_data->delete();
        Toastr::success('Success', 'Data delete successfully');

        return redirect()->back();
    }

    public function imgdestroy(Request $request)
    {
        $delete_data = Productimage::find($request->id);
        File::delete($delete_data->image);
        $delete_data->delete();
        Toastr::success('Success', 'Data delete successfully');

        return redirect()->back();
    }

    public function pricedestroy(Request $request)
    {
        $delete_data = Productprice::find($request->id);
        $delete_data->delete();
        Toastr::success('Success', 'Product price delete successfully');

        return redirect()->back();
    }

    public function update_deals(Request $request)
    {
        $products = Product::whereIn('id', $request->input('product_ids'))->update(['topsale' => $request->status]);

        return response()->json(['status' => 'success', 'message' => 'Hot deals product status change']);
    }

    public function update_feature(Request $request)
    {
        $products = Product::whereIn('id', $request->input('product_ids'))->update(['feature_product' => $request->status]);

        return response()->json(['status' => 'success', 'message' => 'Feature product status change']);
    }

    public function update_status(Request $request)
    {
        $products = Product::whereIn('id', $request->input('product_ids'))->update(['status' => $request->status]);

        return response()->json(['status' => 'success', 'message' => 'Product status change successfully']);
    }

    public function getEmbedVideoUrl($input)
    {
        // 1️⃣ YouTube normal / shorts / youtu.be
        if (preg_match('/^[a-zA-Z0-9_-]{11}$/', $input)) {
            // যদি input শুধু 11 character ID হয়
            return "https://www.youtube.com/embed/$input";
        }

        if (preg_match('/(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:watch\?v=|shorts\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $input, $matches)) {
            return "https://www.youtube.com/embed/" . $matches[1];
        }

        // 2️⃣ Facebook video / reel / share
        if (
            preg_match('/facebook\.com\/.*\/videos\/(\d+)/', $input) ||
            preg_match('/facebook\.com\/watch\?v=(\d+)/', $input) ||
            preg_match('/facebook\.com\/reel\/(\d+)/', $input) ||
            preg_match('/facebook\.com\/share\/v\/(\w+)/', $input) ||
            preg_match('/facebook\.com\/share\/p\/(\w+)/', $input)
        ) {
            return "https://www.facebook.com/plugins/video.php?href=" . urlencode($input) . "&show_text=0&width=560";
        }

        // 3️⃣ যদি match না হয়, original URL return
        return $input;
    }


}
