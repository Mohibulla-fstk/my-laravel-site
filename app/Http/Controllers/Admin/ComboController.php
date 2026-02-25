<?php

namespace App\Http\Controllers\Admin;
use App\Models\GeneralSetting;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Combo;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Size;
use App\Models\Color;
use App\Models\Comboimage;
use App\Models\ShippingCharge;
use Illuminate\Http\Request;
use App\Models\Review;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ComboController extends Controller
{
    // List all combos
    public function __construct()
    {
        $this->middleware('permission:combo-list|combo-create|combo-edit|combo-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:combo-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:combo-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:combo-delete', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        if ($request->keyword) {
            $combos = Combo::orderBy('id', 'DESC')
                ->where('name', 'LIKE', '%' . $request->keyword . '%')
                ->with(['images', 'category'])
                ->paginate(50);
        } else {
            $combos = Combo::orderBy('id', 'DESC')
                ->with(['images', 'category'])
                ->paginate(50);
        }

        return view('backEnd.combos.index', compact('combos'));
    }



    // Show create form
    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();
        $sizes = Size::all();
        $colors = Color::all();
        $products = \App\Models\Product::select('id', 'name')->get(); // products পাঠাচ্ছি
        return view('backEnd.combos.create', compact('categories', 'products'));
    }
    // ComboController.php

    public function details($slug)
    {
        // Combo with related products, images, colors, sizes
        $combo = Combo::with([
            'images',
            'products' => function ($q) {
                $q->where('status', 1)
                    ->with(['colors', 'sizes', 'images']);
            }
        ])
            ->where('slug', $slug)
            ->where('status', 1) // only active combos
            ->firstOrFail();

        // Combo-specific reviews
        $reviews = Review::where('status', 1)
            ->where('combo_id', $combo->id)
            ->get();

        // Shipping charges
        $shippingcharge = ShippingCharge::where('status', 1)->get();

        // Min & Max products selection
        $minProducts = $combo->min_products;
        $maxProducts = $combo->max_products;

        // All products in combo category
        $products = $combo->category->products()->with(['colors', 'sizes', 'images'])->get();

        // All active combos (for cross-sell / suggestions)
        $all_combos = Combo::where('status', 1)
            ->with(['images', 'category', 'products'])
            ->get();

        // All active products
        $all_products = Product::where('status', 1)
            ->with(['category', 'image', 'images', 'procolors', 'prosizes'])
            ->get();

        // Flatten product sizes if needed
        $productsizes = $combo->products->flatMap(function ($product) {
            return $product->prosizes;
        });

        // Recently viewed combos (session)
        $recentlyViewed = session()->get('recently_viewed_combos', []);
        if (($key = array_search($combo->id, $recentlyViewed)) !== false) {
            unset($recentlyViewed[$key]);
        }
        array_unshift($recentlyViewed, $combo->id);
        $recentlyViewed = array_slice($recentlyViewed, 0, 10);
        session()->put('recently_viewed_combos', $recentlyViewed);

        $recentlyCombos = Combo::with('images')
            ->whereIn('id', $recentlyViewed)
            ->orderByRaw('FIELD(id, ' . implode(',', $recentlyViewed) . ')')
            ->get();

        return view('frontEnd.layouts.pages.combo', compact(
            'combo',
            'minProducts',
            'maxProducts',
            'reviews',
            'shippingcharge',
            'productsizes',
            'products',
            'all_combos',
            'all_products',
            'recentlyCombos'
        ));
    }





    // Store new combo
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id', // ✅ validation added
            'min_products' => 'required|integer|min:1',
            'max_products' => 'required|integer|min:1|gte:min_products',
            'price' => 'required|numeric|min:0',
            'new_price' => 'required|numeric|min:0',
            'old_price' => 'nullable|numeric|min:0',
            'description' => 'required|string',
            'status' => 'nullable|boolean', // checkbox

        ]);

        $status = $request->has('status') ? 1 : 0;

        // Combo create
        $combo = Combo::create([
            'name' => $request->name,
            'slug' => \Str::slug($request->name),
            'category_id' => $request->category_id,
            'brand_id' => $request->brand_id, // ✅ brand_id added
            'min_products' => $request->min_products,
            'max_products' => $request->max_products,
            'price' => $request->price,
            'new_price' => $request->new_price,
            'old_price' => $request->old_price ?? 0,
            'description' => $request->description,
            'stock' => $request->stock,
            'stockstatus' => $request->stockstatus,
            'note' => $request->note,
            'status' => $status,
        ]);


        // Combo images save (multiple)
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $key => $file) {
                if ($file->isValid()) {
                    // নাম clean করা
                    $name = time() . '-' . $file->getClientOriginalName();
                    $name = preg_replace('"\.(jpg|jpeg|png|gif|webp)$"', '.webp', $name);
                    $name = strtolower(Str::slug(pathinfo($name, PATHINFO_FILENAME))) . '-' . $key . '.webp';

                    $uploadPath = 'public/uploads/combos/';
                    $imageUrl = $uploadPath . $name;


                    $img = Image::make($file->getRealPath());
                    $img->encode('webp', 70);
                    $img->save($imageUrl);

                    // Database এ Save
                    $combo->images()->create([
                        'image' => $imageUrl,
                    ]);
                }
            }
        }

        return redirect()->route('combos.index')->with('success', 'Combo created successfully!');
    }




    // Show edit form
    public function edit($id)
    {
        $combo = Combo::findOrFail($id);
        $categories = Category::all();
        return view('backEnd.combos.edit', compact('combo', 'categories'));
    }

    // Update combo
    public function update(Request $request, $id)
    {
        $combo = Combo::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'min_products' => 'required|integer|min:1',
            'max_products' => 'required|integer|min:1|gte:min_products',
            'price' => 'required|numeric|min:0',
            'new_price' => 'required|numeric|min:0',
            'old_price' => 'nullable|numeric|min:0',
            'description' => 'required|string',
            'status' => 'nullable|boolean',

        ]);

        $status = $request->has('status') ? 1 : 0;

        // Combo update
        $combo->update([
            'name' => $request->name,
            'slug' => \Str::slug($request->name),
            'category_id' => $request->category_id,
            'brand_id' => $request->brand_id,
            'min_products' => $request->min_products,
            'max_products' => $request->max_products,
            'price' => $request->price,
            'new_price' => $request->new_price,
            'old_price' => $request->old_price ?? 0,
            'description' => $request->description,
            'stock' => $request->stock,
            'stockstatus' => $request->stockstatus,
            'note' => $request->note,
            'status' => $status,
        ]);

        // Combo images update (multiple)
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $key => $file) {
                if ($file->isValid()) {
                    // পুরানো নাম থেকে clean করে নতুন নাম বানানো
                    $name = time() . '-' . $file->getClientOriginalName();
                    $name = preg_replace('"\.(jpg|jpeg|png|gif|webp)$"', '.webp', $name);
                    $name = strtolower(Str::slug(pathinfo($name, PATHINFO_FILENAME))) . '-' . $key . '.webp';

                    $uploadPath = 'public/uploads/combos/';
                    $imageUrl = $uploadPath . $name;

                    // Intervention দিয়ে WebP তে convert করা
                    $img = Image::make($file->getRealPath());
                    $img->encode('webp', 70); // 70 মানে compression quality
                    $img->save($imageUrl);

                    // Database এ save
                    $combo->images()->create([
                        'image' => $imageUrl,
                    ]);
                }
            }
        }

        return redirect()->route('combos.index')->with('success', 'Combo updated successfully!');
    }




    public function destroyImage($id)
    {
        $image = Comboimage::findOrFail($id);

        // database path থেকে 'public/' remove করে public_path বানানো
        $imagePath = public_path(str_replace('public/', '', $image->image));

        if (file_exists($imagePath)) {
            @unlink($imagePath); // folder থেকে image delete, warning hide
        }

        $image->delete(); // database থেকে delete

        return back()->with('success', 'Image deleted successfully!');
    }


    // Delete combo
    public function destroy($id)
    {
        $combo = Combo::findOrFail($id);

        // Combo images delete from folder & database
        foreach ($combo->images as $img) {
            // database path থেকে 'public/' remove করে public_path তৈরি করা
            $imagePath = public_path(str_replace('public/', '', $img->image));

            if (file_exists($imagePath)) {
                @unlink($imagePath); // folder থেকে image delete, warning hide
            }

            $img->delete(); // database থেকে image record delete
        }

        // Delete combo itself
        $combo->delete();

        return back()->with('success', 'Combo and its images deleted successfully!');
    }
public function inactive(Request $request)
    {
        $combo = Combo::findOrFail($request->id); // Request থেকে ID নেওয়া
        $combo->status = 0; // inactive
        $combo->save();

        return redirect()->back()->with('success', 'Combo set to inactive successfully!');
    }

    public function active(Request $request)
    {
        $combo = Combo::findOrFail($request->id); // Request থেকে ID নেওয়া
        $combo->status = 1; // active
        $combo->save();

        return redirect()->back()->with('success', 'Combo set to active successfully!');
    }

}
