<?php

namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\BaseCustomerController;
use App\Http\Controllers\Controller;
use App\Mail\ContactMail;
use App\Models\Banner;
use App\Models\Campaign;
use App\Models\Category;
use App\Models\Childcategory;
use App\Models\Contact;
use App\Models\CreatePage;
use App\Models\Customer;
use App\Models\District;
use App\Models\GeneralSetting;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Productcolor;
use App\Models\Productsize;
use App\Models\Review;
use App\Models\ShippingCharge;
use App\Models\Size;
use App\Models\Color;
use App\Models\Subcategory;
use App\Models\Collection;
use App\Models\CollectionItem;
use Auth;
use Brian2694\Toastr\Facades\Toastr;
use Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Session;
use shurjopayv2\ShurjopayLaravelPackage8\Http\Controllers\ShurjopayController;
use App\Models\Combo;


class FrontendController extends BaseCustomerController
{
    public function getSearchTopProducts()
    {
        // সর্বদা 4 product
        $search_top_products = Product::where('status', 1)
            ->with(['image', 'prosizes', 'procolors'])
            ->take(4)
            ->get();

        return $search_top_products;
    }

    public function index()
    {

        $generalsetting = GeneralSetting::where('status', 1)->limit(1)->first();

        $frontcategory = Category::where(['status' => 1])
            ->select('id', 'name', 'image', 'slug', 'status')
            ->get();

        $sliders = Banner::where(['status' => 1, 'category_id' => 1])
            ->select('id', 'image', 'link', 'title', 'subtitle', 'button_text', 'titlecolor', 'subtitlecolor', 'buttoncolor', 'buttontextcolor', 'text_status')
            ->get();

        $campaognads = Banner::where(['status' => 1, 'category_id' => 7])
            ->select('id', 'image', 'link')
            ->limit(1)
            ->get();


        $sliderbottomads = Banner::where(['status' => 1, 'category_id' => 5])
            ->select('id', 'image', 'link')
            ->limit(3)
            ->get();

        $footertopads = Banner::where(['status' => 1, 'category_id' => 6])
            ->select('id', 'image', 'link')
            ->limit(3)
            ->get();

        $flas_sales = Product::where(['status' => 1, 'flashsale' => 1])
            ->orderBy('id', 'DESC')
            ->select('id', 'name', 'slug', 'new_price', 'old_price', 'sold', 'stock', 'stockstatus')
            ->with('prosizes', 'procolors')
            ->limit(12)
            ->get();
        // return $hotdeal_top;

        $hotdeal_top = Product::where(['status' => 1, 'topsale' => 1])
            ->orderBy('id', 'DESC')
            ->select('id', 'name', 'slug', 'new_price', 'old_price', 'stock', 'stockstatus')
            ->with('prosizes', 'procolors')
            ->limit(12)
            ->get();
        // return $hotdeal_top;

        $hotdeal_bottom = Product::where(['status' => 1, 'topsale' => 1])
            ->select('id', 'name', 'slug', 'new_price', 'old_price', 'stock', 'stockstatus')
            ->skip(12)
            ->limit(12)
            ->get();

        $reviews = Banner::where(['status' => 1, 'category_id' => 8])
            ->select('id', 'image', 'link')
            ->limit(3)
            ->get();

        $generalsetting = Generalsetting::first();

        $homeproducts = collect(); // empty collection

        if ($generalsetting->show_category_wise_products) {

            // 1️⃣ Categories
            $categories = Category::where(['front_view' => 1, 'status' => 1])
                ->orderBy('sort_order', 'desc') // front_view অনুযায়ী
                ->with(['products' => function ($q) {
                    $q->select('id', 'category_id', 'name', 'slug', 'new_price', 'old_price', 'stock', 'stockstatus', 'status')
                    ->with('image', 'images');
                }])
                ->get()
                ->map(function ($category) {
                    $category->type = 'category';
                    $category->section_name = $category->name; 
                    $category->combo_products = Combo::where(['category_id' => $category->id, 'status' => 1])
                        ->with('images')
                        ->get();
                    return $category;
                });

            // 2️⃣ Subcategories
            $subcategories = Subcategory::where(['front_view' => 1, 'status' => 1])
                ->orderBy('sort_order', 'desc')
                ->with(['products' => function ($q) {
                    $q->select('id', 'subcategory_id', 'name', 'slug', 'new_price', 'old_price', 'stock', 'stockstatus', 'status')
                    ->with('image', 'images');
                }])
                ->get()
                ->map(function ($subcat) {
                    $subcat->type = 'subcategory';
                    $subcat->section_name = $subcat->subcategoryName;
                    $subcat->combo_products = Combo::where(['subcategory_id' => $subcat->id, 'status' => 1])
                        ->with('images')
                        ->get();
                    return $subcat;
                });

            // 3️⃣ Childcategories
            $childcategories = Childcategory::where(['front_view' => 1, 'status' => 1])
                ->orderBy('sort_order', 'desc')
                ->with(['products' => function ($q) {
                    $q->select('id', 'childcategory_id', 'name', 'slug', 'new_price', 'old_price', 'stock', 'stockstatus', 'status')
                    ->with('image', 'images');
                }])
                ->get()
                ->map(function ($childcat) {
                    $childcat->type = 'childcategory';
                    $childcat->section_name = $childcat->childcategoryName;
                    $childcat->combo_products = Combo::where(['childcategory_id' => $childcat->id, 'status' => 1])
                        ->with('images')
                        ->get();
                    return $childcat;
                });
                
            // Combine with categories, subcategories, childcategories if needed
            $homeproducts = $categories->merge($subcategories)->merge($childcategories)
        ->sortBy('sort_order')  // 🔥 Global serial sort
        ->values();


        } else {
            $homeproducts = null;
        }

        // all_products remain same
        if ($generalsetting->show_all_products) {
            $all_products = Product::where(['status' => 1])
                ->inRandomOrder()
                ->select('id', 'category_id', 'name', 'slug', 'new_price', 'old_price', 'sold', 'stock', 'stockstatus')
                ->with('prosizes', 'procolors')
                ->limit(30)
                ->get();
        } else {
            $all_products = null;
        }

        
        // collection item
        
        $collections = Collection::where('status', 1)
                         ->orderBy('sort_order', 'asc')
                         ->get();


        $collection_items = [];

        foreach($collections as $collection) {
            // get all items of this collection
            $items = CollectionItem::where('collection_id', $collection->id)->get();

            // Consolidate items: category + subcategory + childcategory
            $all_items = collect();

            foreach($items as $item) {
                // প্রথমে collection_item active কিনা চেক
                if ($item->status != 1) {
                    continue; // status = 0 হলে skip
                }

                if ($item->item_type == 'category') {
                    // category active কিনা চেক
                    $name = Category::where('id', $item->item_id)
                        ->where('status', 1)
                        ->value('name');
                    $slug = Category::where('id', $item->item_id)
                        ->where('status', 1)
                        ->value('slug');

                    // যদি category inactive হয়, skip
                    if (!$name || !$slug) continue;

                } elseif ($item->item_type == 'subcategory') {
                    $name = Subcategory::where('id', $item->item_id)
                        ->where('status', 1)
                        ->value('subcategoryName');
                    $slug = Subcategory::where('id', $item->item_id)
                        ->where('status', 1)
                        ->value('slug');

                    if (!$name || !$slug) continue;

                } elseif ($item->item_type == 'childcategory') {
                    $name = Childcategory::where('id', $item->item_id)
                        ->where('status', 1)
                        ->value('childcategoryName');
                    $slug = Childcategory::where('id', $item->item_id)
                        ->where('status', 1)
                        ->value('slug');

                    if (!$name || !$slug) continue;

                } else {
                    continue; // অন্য কোনো type হলে skip
                }


                $all_items->push((object)[
                    'item_type' => $item->item_type,
                    'item_name' => $name,
                    'item_slug' => $slug,
                    'item_badge' => $item->item_badge, // ✅ NEW
                ]);
            }

            // ✅ এটা important
            $collection_items[$collection->id] = $all_items;
        }



        return view('frontEnd.layouts.pages.index', compact(
            'sliders', 'frontcategory', 'hotdeal_top', 'hotdeal_bottom',
            'homeproducts', 'sliderbottomads', 'footertopads', 'flas_sales',
            'campaognads', 'reviews', 'all_products', 'collections', 'collection_items'
        ));
    }



    public function allCategories()
    {
        $products = Product::where('status', 1);
        $category = $subcategory = $childcategory = null;
        $subcategories = collect();
        $childcategories = collect();
        $all_categories = Category::where('status', 1)->get();
        $all_sizes = Size::select('sizeName')->distinct()->get();
        $categories = Category::where('status', 1)->get();
        $combo_products = Combo::where('status', 1) // শুধুমাত্র active combos
            ->get();


        return view('frontEnd.layouts.pages.all', compact(
            'categories',
            'products',
            'category',
            'subcategories',
            'childcategories',
            'all_categories',
            'all_sizes',

        ));
    }

    public function hotdeals(Request $request)
    {
        // Base query: Only Top Sale products
        $products = Product::where(['status' => 1, 'topsale' => 1]);

        $category = $subcategory = $childcategory = null;
        $subcategories = collect();
        $childcategories = collect();

        // For sidebar filters
        $all_categories = Category::where('status', 1)->get();
        $all_sizes = Size::select('sizeName')->distinct()->get();


        // CATEGORY FILTER
        if ($request->has('category') && $request->category != '') {
            $category = Category::where('slug', $request->category)->where('status', 1)->first();
            if ($category) {
                $products->where('category_id', $category->id);
                $subcategories = Subcategory::where('category_id', $category->id)->where('status', 1)->get();
            }
        }

        // SUBCATEGORY FILTER
        if ($request->has('subcategory') && $request->subcategory != '') {
            $subcategory = Subcategory::where('slug', $request->subcategory)->where('status', 1)->first();
            if ($subcategory) {
                $products->where('subcategory_id', $subcategory->id);
                $childcategories = Childcategory::where('subcategory_id', $subcategory->id)->where('status', 1)->get();
            }
        }

        // CHILDCATEGORY FILTER
        if ($request->has('childcategory') && $request->childcategory != '') {
            $childcategory = Childcategory::where('slug', $request->childcategory)->where('status', 1)->first();
            if ($childcategory) {
                $products->where('childcategory_id', $childcategory->id);
            }
        }

        // SIZE FILTER (multiple select / checkbox)
        if ($request->has('size') && !empty($request->size)) {
            $products->whereHas('sizes', function ($q) use ($request) {
                $q->whereIn('sizeName', (array) $request->size);
            });
        }

        // STOCK FILTER
        if ($request->has('stock')) {
            $products->whereIn('stockstatus', (array) $request->stock);
        }

        // SORTING
        switch ($request->sort) {
            case 1:
                $products->orderBy('created_at', 'desc');
                break;
            case 2:
                $products->orderBy('created_at', 'asc');
                break;
            case 3:
                $products->orderBy('new_price', 'desc');
                break;
            case 4:
                $products->orderBy('new_price', 'asc');
                break;
            case 5:
                $products->orderBy('name', 'asc');
                break;
            case 6:
                $products->orderBy('name', 'desc');
                break;
            default:
                $products->latest();
        }

        // PRICE FILTER
        $min_price = $products->min('new_price');
        $max_price = $products->max('new_price');
        if ($request->min_price && $request->max_price) {
            $products->whereBetween('new_price', [$request->min_price, $request->max_price]);
        }

        // PAGINATION
        $products = $products->paginate(36)->withQueryString();

        // AJAX response
        if ($request->ajax()) {
            return view('frontEnd.layouts.pages.hotdeals', compact(
                'products',
                'category',
                'subcategory',
                'childcategory',
                'subcategories',
                'childcategories',
                'min_price',
                'max_price',
                'all_categories',
                'all_sizes',

            ))->render();
        }

        // Normal page load
        return view('frontEnd.layouts.pages.hotdeals', compact(
            'products',
            'category',
            'subcategory',
            'childcategory',
            'subcategories',
            'childcategories',
            'min_price',
            'max_price',
            'all_categories',
            'all_sizes',

        ));
    }


    public function shop(Request $request)
    {
        $products = Product::where('status', 1);

        $category = $subcategory = $childcategory = null;
        $subcategories = collect();
        $childcategories = collect();

        $all_categories = Category::where('status', 1)->get();
        $all_sizes = Size::select('sizeName')->distinct()->get();

        // CATEGORY FILTER
        if ($request->has('category') && $request->category != '') {
            $category = Category::where('slug', $request->category)->where('status', 1)->first();
            if ($category) {
                $products->where('category_id', $category->id);
                $subcategories = Subcategory::where('category_id', $category->id)->where('status', 1)->get();
            }
        }
        // SIZE FILTER
        // SIZE FILTER
        if ($request->has('size') && $request->size != '') {
            $products->whereHas('sizes', function ($q) use ($request) {
                $q->where('sizeName', $request->size);
            });
        }

        // SUBCATEGORY FILTER
        if ($request->has('subcategory') && $request->subcategory != '') {
            $subcategory = Subcategory::where('slug', $request->subcategory)->where('status', 1)->first();
            if ($subcategory) {
                $products->where('subcategory_id', $subcategory->id);
                $childcategories = Childcategory::where('subcategory_id', $subcategory->id)->where('status', 1)->get();
            }
        }

        // CHILDCATEGORY FILTER
        if ($request->has('childcategory') && $request->childcategory != '') {
            $childcategory = Childcategory::where('slug', $request->childcategory)->where('status', 1)->first();
            if ($childcategory) {
                $products->where('childcategory_id', $childcategory->id);
            }
        }

        // SORTING
        switch ($request->sort) {
            case 1:
                $products->orderBy('created_at', 'desc');
                break;
            case 2:
                $products->orderBy('created_at', 'asc');
                break;
            case 3:
                $products->orderBy('new_price', 'desc');
                break;
            case 4:
                $products->orderBy('new_price', 'asc');
                break;
            case 5:
                $products->orderBy('name', 'asc');
                break;
            case 6:
                $products->orderBy('name', 'desc');
                break;
            default:
                $products->latest();
        }

        // PRICE FILTER
        $min_price = $products->min('new_price');
        $max_price = $products->max('new_price');
        if ($request->min_price && $request->max_price) {
            $products->whereBetween('new_price', [$request->min_price, $request->max_price]);
        }

        // STOCK FILTER
        if ($request->has('stock')) {
            $products->whereIn('stockstatus', (array) $request->stock);
        }
        // SIZE FILTER (multiple)
        // SIZE FILTER (multiple select/checkbox)
        // SIZE FILTER (multiple select)
        if ($request->has('size') && !empty($request->size)) {
            $products->whereHas('sizes', function ($q) use ($request) {
                $q->whereIn('sizeName', $request->size);
            });
        }

        // PAGINATION
        $products = $products->paginate(36)->withQueryString();

        // AJAX check
        if ($request->ajax()) {
            return view('frontEnd.layouts.pages.shop', compact(
                'products',
                'products',
                'category',
                'subcategory',
                'childcategory',
                'subcategories',
                'childcategories',
                'min_price',
                'max_price',
                'all_categories',
                'all_sizes',

            ))->render();
        }

        return view('frontEnd.layouts.pages.shop', compact(
            'products',
            'category',
            'subcategory',
            'childcategory',
            'subcategories',
            'childcategories',
            'min_price',
            'max_price',
            'all_categories',
            'all_sizes',

        ));
    }

    public function flashsales(Request $request)
    {
        // Base query: Only Flash Sale products
        $products = Product::where(['status' => 1, 'flashsale' => 1]);

        $category = $subcategory = $childcategory = null;
        $subcategories = collect();
        $childcategories = collect();

        // Sidebar filters data
        $all_categories = Category::where('status', 1)->get();
        $all_sizes = Size::select('sizeName')->distinct()->get();


        // CATEGORY FILTER
        if ($request->has('category') && $request->category != '') {
            $category = Category::where('slug', $request->category)->where('status', 1)->first();
            if ($category) {
                $products->where('category_id', $category->id);
                $subcategories = Subcategory::where('category_id', $category->id)->where('status', 1)->get();
            }
        }

        // SUBCATEGORY FILTER
        if ($request->has('subcategory') && $request->subcategory != '') {
            $subcategory = Subcategory::where('slug', $request->subcategory)->where('status', 1)->first();
            if ($subcategory) {
                $products->where('subcategory_id', $subcategory->id);
                $childcategories = Childcategory::where('subcategory_id', $subcategory->id)->where('status', 1)->get();
            }
        }

        // CHILDCATEGORY FILTER
        if ($request->has('childcategory') && $request->childcategory != '') {
            $childcategory = Childcategory::where('slug', $request->childcategory)->where('status', 1)->first();
            if ($childcategory) {
                $products->where('childcategory_id', $childcategory->id);
            }
        }

        // SIZE FILTER (multiple)
        if ($request->has('size') && !empty($request->size)) {
            $products->whereHas('sizes', function ($q) use ($request) {
                $q->whereIn('sizeName', (array) $request->size);
            });
        }

        // STOCK FILTER
        if ($request->has('stock')) {
            $products->whereIn('stockstatus', (array) $request->stock);
        }

        // SORTING
        switch ($request->sort) {
            case 1:
                $products->orderBy('created_at', 'desc');
                break;
            case 2:
                $products->orderBy('created_at', 'asc');
                break;
            case 3:
                $products->orderBy('new_price', 'desc');
                break;
            case 4:
                $products->orderBy('new_price', 'asc');
                break;
            case 5:
                $products->orderBy('name', 'asc');
                break;
            case 6:
                $products->orderBy('name', 'desc');
                break;
            default:
                $products->latest();
        }

        // PRICE FILTER
        $min_price = $products->min('new_price');
        $max_price = $products->max('new_price');
        if ($request->min_price && $request->max_price) {
            $products->whereBetween('new_price', [$request->min_price, $request->max_price]);
        }

        // PAGINATION
        $products = $products->paginate(36)->withQueryString();

        // AJAX response
        if ($request->ajax()) {
            return view('frontEnd.layouts.pages.flashsales', compact(
                'products',
                'category',
                'subcategory',
                'childcategory',
                'subcategories',
                'childcategories',
                'min_price',
                'max_price',
                'all_categories',
                'all_sizes',

            ))->render();
        }

        // Normal page load
        return view('frontEnd.layouts.pages.flashsales', compact(
            'products',
            'category',
            'subcategory',
            'childcategory',
            'subcategories',
            'childcategories',
            'min_price',
            'max_price',
            'all_categories',
            'all_sizes',

        ));
    }


    public function contactPage()
    {
        // প্রথম contact record load করা
        $contact = Contact::first();

        return view('frontEnd.layouts.pages.contact', compact('contact'));
    }

    public function category($slug, Request $request)
    {
        $soldShow = $request->sold == 'show' ? true : false;

        $category = Category::where(['slug' => $slug, 'status' => 1])->first();

        if (!$category) {
            abort(404); // অথবা redirect, বা empty response
        }
        $all_sizes = Size::select('sizeName')->distinct()->get();

        $all_products = Product::where('category_id', $category->id)
            ->with('image', 'images', 'procolors', 'prosizes')
            ->get();
        $all_colors = $all_products->flatMap(function ($product) {
            return $product->procolors->pluck('colorName');
        })->unique();
        $all_combos = Combo::where('status', 1)
            ->with(['products', 'images', 'category'])
            ->get();
        // Regular products query
        $products = Product::where(['status' => 1, 'category_id' => $category->id])
            ->select('id', 'name', 'slug', 'new_price', 'old_price', 'category_id', 'sold', 'stock', 'stockstatus', 'subcategory_id');

        // Subcategories
        $subcategories = Subcategory::where('category_id', $category->id)->get();

        // --- Combo products query with filters ---
        $combo_products = Combo::where('category_id', $category->id)
            ->where('status', 1)
            ->where(function ($query) use ($request) {
                // Price filter
                if ($request->min_price && $request->max_price) {
                    $query->whereBetween('price', [$request->min_price, $request->max_price]);
                }

                // Stock filter (assuming combo has stockstatus field)
                if ($request->has('stock')) {
                    $query->whereIn('stockstatus', (array) $request->stock);
                }
            })
            ->with([
                'products' => function ($q) use ($request) {
                    // Size filter inside products
                    if ($request->has('size') && !empty($request->size)) {
                        $q->whereHas('sizes', function ($sq) use ($request) {
                            $sq->whereIn('sizeName', $request->size);
                        });
                    }

                    // Product sorting inside combo (optional)
                    switch ($request->sort) {
                        case 3:
                            $q->orderBy('new_price', 'desc');
                            break;
                        case 4:
                            $q->orderBy('new_price', 'asc');
                            break;
                        case 5:
                            $q->orderBy('name', 'asc');
                            break;
                        case 6:
                            $q->orderBy('name', 'desc');
                            break;
                        default:
                            $q->latest();
                    }
                },
                'category',
                'images'
            ])
            ->get();


        // Sorting for regular products
        switch ($request->sort) {
            case 1:
                $products->orderBy('created_at', 'desc');
                break;
            case 2:
                $products->orderBy('created_at', 'asc');
                break;
            case 3:
                $products->orderBy('new_price', 'desc');
                break;
            case 4:
                $products->orderBy('new_price', 'asc');
                break;
            case 5:
                $products->orderBy('name', 'asc');
                break;
            case 6:
                $products->orderBy('name', 'desc');
                break;
            default:
                $products->latest();
        }

        // Price filter for regular products
        $min_price = $products->min('new_price');
        $max_price = $products->max('new_price');

        if ($request->min_price && $request->max_price) {
            $products->whereBetween('new_price', [$request->min_price, $request->max_price]);
        }

        // Size filter for regular products
        if ($request->has('size') && $request->size != '') {
            $products->whereHas('sizes', function ($q) use ($request) {
                $q->where('sizeName', $request->size);
            });
        }

        // Subcategory filter
        $selectedSubcategories = $request->input('subcategory', []);
        $products->when($selectedSubcategories, function ($query) use ($selectedSubcategories) {
            $query->whereIn('subcategory_id', $selectedSubcategories);
        });

        // Stockstatus filter
        $selectedStock = $request->input('stock', []);
        $products->when($selectedStock, function ($query) use ($selectedStock) {
            $query->whereIn('stockstatus', $selectedStock);
        });

        // Pagination
        $products = $products->paginate(24)->withQueryString();

        $comboProducts = $combo_products ?? collect();
        $normalProducts = $products->getCollection() ?? collect(); // paginator থেকে collection নাও

        // Merge এবং created_at অনুযায়ী sort
        $allItems = $comboProducts->merge($normalProducts)
            ->sortBy('created_at'); // old to new
        // ->sortByDesc('created_at'); // new to old

        // Pagination recreate
        $perPage = $products->perPage();
        $page = request()->get('page', 1);
        $paginatedItems = new \Illuminate\Pagination\LengthAwarePaginator(
            $allItems->forPage($page, $perPage),
            $allItems->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );


        // AJAX response
        if ($request->ajax()) {
            return view('frontEnd.layouts.pages.category', compact(
                'paginatedItems',
                'category',
                'products',
                'combo_products', // sorted & filtered combos
                'subcategories',
                'min_price',
                'max_price',
                'soldShow',
                'all_products',
                'all_sizes',
                'all_colors',
                'all_combos'


            ))->render();

        }

        // Normal page load
        return view('frontEnd.layouts.pages.category', compact(
            'paginatedItems',
            'category',
            'products',
            'combo_products', // sorted & filtered combos
            'subcategories',
            'min_price',
            'max_price',
            'soldShow',
            'all_products',
            'all_sizes',
            'all_colors',
            'all_combos'

        ));
    }


    public function subcategory($slug, Request $request)
    {
        $soldShow = $request->sold == 'show' ? true : false;

        $subcategory = Subcategory::where(['slug' => $slug, 'status' => 1])->firstOrFail();

        $childcategories = Childcategory::where('subcategory_id', $subcategory->id)->get();
        $all_sizes = Size::select('sizeName')->distinct()->get();

        // All products (for colors & filter sidebar)
        $all_products = Product::where('subcategory_id', $subcategory->id)
            ->with('image', 'images', 'procolors', 'prosizes')
            ->get();

        $all_colors = $all_products->flatMap(function ($product) {
            return $product->procolors->pluck('colorName');
        })->unique();

        // --- Regular products query ---
        $products = Product::where(['status' => 1, 'subcategory_id' => $subcategory->id])
            ->select('id', 'name', 'slug', 'new_price', 'old_price', 'category_id', 'subcategory_id', 'sold', 'stock', 'stockstatus');



        // Sorting for regular products
        switch ($request->sort) {
            case 1:
                $products->orderBy('created_at', 'desc');
                break;
            case 2:
                $products->orderBy('created_at', 'asc');
                break;
            case 3:
                $products->orderBy('new_price', 'desc');
                break;
            case 4:
                $products->orderBy('new_price', 'asc');
                break;
            case 5:
                $products->orderBy('name', 'asc');
                break;
            case 6:
                $products->orderBy('name', 'desc');
                break;
            default:
                $products->latest();
        }

        // Price filter
        $min_price = $products->min('new_price');
        $max_price = $products->max('new_price');

        if ($request->min_price && $request->max_price) {
            $products->whereBetween('new_price', [$request->min_price, $request->max_price]);
        }

        // Size filter
        if ($request->has('size') && $request->size != '') {
            $products->whereHas('sizes', function ($q) use ($request) {
                $q->where('sizeName', $request->size);
            });
        }

        // Childcategory filter
        $selectedChildcategories = $request->input('childcategory', []);
        $products->when($selectedChildcategories, function ($query) use ($selectedChildcategories) {
            $query->whereIn('childcategory_id', $selectedChildcategories);
        });

        // Stockstatus filter
        $selectedStock = $request->input('stock', []);
        $products->when($selectedStock, function ($query) use ($selectedStock) {
            $query->whereIn('stockstatus', $selectedStock);
        });

        // Pagination
        $products = $products->paginate(24)->withQueryString();

        // AJAX response
        if ($request->ajax()) {
            return view('frontEnd.layouts.pages.subcategory', compact(
                'subcategory',
                'products',
                'childcategories',
                'min_price',
                'max_price',
                'soldShow',
                'all_products',
                'all_sizes',
                'all_colors'
            ));
        }

        // Normal page load
        return view('frontEnd.layouts.pages.subcategory', compact(
            'subcategory',
            'products',
            'childcategories',
            'min_price',
            'max_price',
            'soldShow',
            'all_products',
            'all_sizes',
            'all_colors'
        ));
    }


    public function childcategory($slug, Request $request)
    {
        $soldShow = $request->sold == 'show' ? true : false;

        // Current childcategory
        $childcategory = Childcategory::where(['slug' => $slug, 'status' => 1])->firstOrFail();

        // Related childcategories (for sidebar filter)
        $childcategories = Childcategory::where('subcategory_id', $childcategory->subcategory_id)->get();

        // Parent subcategory
        $subcategory = Subcategory::where('id', $childcategory->subcategory_id)->first();

        // All products (for sidebar filters: sizes, colors)
        $all_products = Product::where('childcategory_id', $childcategory->id)
            ->with('image', 'images', 'procolors', 'prosizes')
            ->get();

        // Collect unique sizes
        $all_sizes = $all_products->flatMap(function ($product) {
            return $product->prosizes->pluck('sizeName');
        })->unique();

        // Collect unique colors
        $all_colors = $all_products->flatMap(function ($product) {
            return $product->procolors->pluck('colorName');
        })->unique();

        // Base product query
        $products = Product::where(['status' => 1, 'childcategory_id' => $childcategory->id])
            ->select('id', 'name', 'slug', 'new_price', 'old_price', 'category_id', 'subcategory_id', 'childcategory_id', 'sold', 'stock', 'stockstatus');

        // Sorting
        switch ($request->sort) {
            case 1:
                $products->orderBy('created_at', 'desc');
                break;
            case 2:
                $products->orderBy('created_at', 'asc');
                break;
            case 3:
                $products->orderBy('new_price', 'desc');
                break;
            case 4:
                $products->orderBy('new_price', 'asc');
                break;
            case 5:
                $products->orderBy('name', 'asc');
                break;
            case 6:
                $products->orderBy('name', 'desc');
                break;
            default:
                $products->latest();
        }

        // Price filter
        $min_price = $products->min('new_price');
        $max_price = $products->max('new_price');

        if ($request->min_price && $request->max_price) {
            $products->whereBetween('new_price', [$request->min_price, $request->max_price]);
        }

        // Size filter
        if ($request->has('size') && $request->size != '') {
            $products->whereHas('sizes', function ($q) use ($request) {
                $q->where('sizeName', $request->size);
            });
        }

        // Stockstatus filter
        $selectedStock = $request->input('stock', []);
        $products->when($selectedStock, function ($query) use ($selectedStock) {
            $query->whereIn('stockstatus', $selectedStock);
        });

        // Pagination
        $products = $products->paginate(24)->withQueryString();

        // Top sold products (extra sidebar section)
        $impproducts = Product::where(['status' => 1, 'topsale' => 1])
            ->with('image')
            ->limit(6)
            ->select('id', 'name', 'slug', 'stock')
            ->get();

        // AJAX response
        if ($request->ajax()) {
            return view('frontEnd.layouts.pages.childcategory', compact(
                'subcategory',
                'childcategory',
                'products',
                'impproducts',
                'childcategories',
                'min_price',
                'max_price',
                'soldShow',
                'all_products',
                'all_sizes',
                'all_colors'
            ));
        }

        // Normal page load
        return view('frontEnd.layouts.pages.childcategory', compact(
            'subcategory',
            'childcategory',
            'products',
            'impproducts',
            'childcategories',
            'min_price',
            'max_price',
            'soldShow',
            'all_products',
            'all_sizes',
            'all_colors'
        ));
    }




    // Normal product page
    public function details($slug)
    {
        $details = Product::with([
            'image',
            'images' => fn($q) => $q->orderBy('id', 'asc'),
            'category',
            'subcategory',
            'childcategory',
            'combos' // Combo relation
        ])
            ->where(['slug' => $slug, 'status' => 1])
            ->firstOrFail();

        // Products of same category
        $products = Product::where('category_id', $details->category_id)
            ->where('status', 1)
            ->select('id', 'name', 'slug', 'new_price', 'old_price', 'stock', 'stockstatus')
            ->get();

        $shippingcharge = ShippingCharge::where('status', 1)->get();
        $reviews = Review::where('product_id', $details->id)->get();
        $productcolors = Productcolor::where('product_id', $details->id)->with('color')->get();
        $productsizes = Productsize::where('product_id', $details->id)->with('size')->get();

        // Recently viewed
        $recentlyViewed = session()->get('recently_viewed', []);
        if (($key = array_search($details->id, $recentlyViewed)) !== false) {
            unset($recentlyViewed[$key]);
        }
        array_unshift($recentlyViewed, $details->id);
        $recentlyViewed = array_slice($recentlyViewed, 0, 10);
        session()->put('recently_viewed', $recentlyViewed);

        $recentlyProducts = Product::with('image')
            ->whereIn('id', $recentlyViewed)
            ->orderByRaw('FIELD(id,' . implode(',', $recentlyViewed) . ')')
            ->get();

        // **Combo logic using is_combo column**
        $isCombo = $details->is_combo; // directly from DB
        $combo = $isCombo ? $details->combos->first() : null;

        $minProducts = $combo ? $combo->min_products : 1; // default 1
        $maxProducts = $combo ? $combo->max_products : 3; // default 3

        // Category products (combo selection)
        $comboProducts = Product::where('category_id', $details->category_id)
            ->where('status', 1)
            ->where('is_combo', 0)
            ->select('id', 'name')
            ->get();


        // ✅ Check if current logged-in customer can review this product
        $canReview = false;

        if (auth('customer')->check()) {
            $customerId = auth('customer')->id();

            // শুধুমাত্র purchased এবং review_id = 0 row check করা হচ্ছে
            $canReview = \App\Models\OrderDetails::where('product_id', $details->id)
                ->where('review_id', 1) // এখনো review দেয়নি
                ->whereHas('order', function ($query) use ($customerId) {
                    $query->where('customer_id', $customerId)
                        ->where('order_status', '!=', 'cancelled');
                })
                ->exists(); // boolean return করবে
        }







        return view('frontEnd.layouts.pages.details', compact(
            'details',
            'products',
            'shippingcharge',
            'productcolors',
            'productsizes',
            'reviews',
            'recentlyProducts',
            'isCombo',
            'comboProducts',
            'minProducts',
            'maxProducts',
            'canReview' // ✅ send to view
        ));
    }




    // Quick-view Ajax call
    public function quickView($slug)
    {
        $details = Product::where(['slug' => $slug, 'status' => 1])
            ->with('image', 'images', 'category', 'subcategory', 'childcategory')
            ->firstOrFail();

        $all_products = Product::where('status', 1)
            ->with('category', 'image', 'images', 'procolors', 'prosizes')
            ->get();
        $all_combos = Combo::where('status', 1)->with('images', 'category', 'products')->get();

        $shippingcharge = ShippingCharge::where('status', 1)->get();
        $reviews = Review::where('product_id', $details->id)->get();
        $productcolors = Productcolor::where('product_id', $details->id)->with('color')->get();
        $productsizes = Productsize::where('product_id', $details->id)->with('size')->get();

        // Recently viewed
        $recentlyViewed = session()->get('recently_viewed', []);
        if (($key = array_search($details->id, $recentlyViewed)) !== false) {
            unset($recentlyViewed[$key]);
        }
        array_unshift($recentlyViewed, $details->id);
        $recentlyViewed = array_slice($recentlyViewed, 0, 10);
        session()->put('recently_viewed', $recentlyViewed);

        $recentlyProducts = Product::with('image')
            ->whereIn('id', $recentlyViewed)
            ->orderByRaw('FIELD(id, ' . implode(',', $recentlyViewed) . ')')
            ->get();

        return view('partials.quick-view', compact(
            'details',
            'products',
            'shippingcharge',
            'productcolors',
            'productsizes',
            'reviews',
            'recentlyProducts',
            'all_combos',
            'all_products'
        ));
    }
    public function quickViewCombo($slug)
    {
        $combo = Combo::where('slug', $slug)
            ->where('status', 1)
            ->with(['products', 'images', 'category'])
            ->firstOrFail();

        $comboOptions = [
            'is_combo' => true,
            'image' => $combo->images->first()?->image ?? 'public/default.png',
            'combo_items' => $combo->products->map(function ($p) {
                return [
                    'id' => $p->id,
                    'name' => $p->name,
                    'qty' => 1,
                    'image' => $p->image?->image ?? 'public/default.png',
                    'price' => $p->new_price,
                ];
            })->toArray(),
            'old_price' => $combo->old_price ?? $combo->price,
        ];

        $combo->options = collect($comboOptions);

        return view('partials.quick-view-combo', compact('combo'));
    }








    public function recentlyViewed()
    {
        $recentlyViewed = session()->get('recently_viewed', []);

        if (empty($recentlyViewed)) {
            $products = collect(); // ফাঁকা collection return করব
        } else {
            $products = Product::with('image')
                ->whereIn('id', $recentlyViewed)
                ->orderByRaw('FIELD(id, ' . implode(',', $recentlyViewed) . ')')
                ->get();
        }

        return view('frontend.product.recently', compact('products'));
    }

    public function livesearch(Request $request)
    {
        $products = Product::select('id', 'name', 'slug', 'new_price', 'old_price', 'stock', 'stockstatus')
            ->where('status', 1)
            ->with('image');

        if ($request->keyword) {
            $products = $products->where('name', 'LIKE', '%' . $request->keyword . '%');
        }
        if ($request->category) {
            $products = $products->where('category_id', $request->category);
        }
        $products = $products->get();

        if (empty($request->category) && empty($request->keyword)) {
            $products = [];
        }

        return view('frontEnd.layouts.ajax.search', compact('products'));
    }

    public function search(Request $request)
    {
        $products = Product::where('status', 1);
        $category = $subcategory = $childcategory = null;
        $subcategories = collect();
        $childcategories = collect();
        $all_categories = Category::where('status', 1)->get();
        $all_sizes = Size::select('sizeName')->distinct()->get();

        // CATEGORY FILTER
        if ($request->has('category') && $request->category != '') {
            $category = Category::where('slug', $request->category)->where('status', 1)->first();
            if ($category) {
                $products->where('category_id', $category->id);
                $subcategories = Subcategory::where('category_id', $category->id)->where('status', 1)->get();
            }
        }
        // SIZE FILTER
        // SIZE FILTER
        if ($request->has('size') && $request->size != '') {
            $products->whereHas('sizes', function ($q) use ($request) {
                $q->where('sizeName', $request->size);
            });
        }

        // SUBCATEGORY FILTER
        if ($request->has('subcategory') && $request->subcategory != '') {
            $subcategory = Subcategory::where('slug', $request->subcategory)->where('status', 1)->first();
            if ($subcategory) {
                $products->where('subcategory_id', $subcategory->id);
                $childcategories = Childcategory::where('subcategory_id', $subcategory->id)->where('status', 1)->get();
            }
        }

        // CHILDCATEGORY FILTER
        if ($request->has('childcategory') && $request->childcategory != '') {
            $childcategory = Childcategory::where('slug', $request->childcategory)->where('status', 1)->first();
            if ($childcategory) {
                $products->where('childcategory_id', $childcategory->id);
            }
        }

        // SORTING
        switch ($request->sort) {
            case 1:
                $products->orderBy('created_at', 'desc');
                break;
            case 2:
                $products->orderBy('created_at', 'asc');
                break;
            case 3:
                $products->orderBy('new_price', 'desc');
                break;
            case 4:
                $products->orderBy('new_price', 'asc');
                break;
            case 5:
                $products->orderBy('name', 'asc');
                break;
            case 6:
                $products->orderBy('name', 'desc');
                break;
            default:
                $products->latest();
        }

        // PRICE FILTER
        $min_price = $products->min('new_price');
        $max_price = $products->max('new_price');
        if ($request->min_price && $request->max_price) {
            $products->whereBetween('new_price', [$request->min_price, $request->max_price]);
        }

        // STOCK FILTER
        if ($request->has('stock')) {
            $products->whereIn('stockstatus', (array) $request->stock);
        }
        // SIZE FILTER (multiple)
        // SIZE FILTER (multiple select/checkbox)
        // SIZE FILTER (multiple select)
        if ($request->has('size') && !empty($request->size)) {
            $products->whereHas('sizes', function ($q) use ($request) {
                $q->whereIn('sizeName', $request->size);
            });
        }

        // PAGINATION

        $products = $products->paginate(36)->withQueryString();
        $keyword = $request->keyword;

        // AJAX check
        if ($request->ajax()) {
            return view('frontEnd.layouts.pages.search', compact(
                'products',
                'products',
                'keyword',
                'category',
                'subcategory',
                'childcategory',
                'subcategories',
                'childcategories',
                'min_price',
                'max_price',
                'all_categories',
                'all_sizes',

            ))->render();
        }

        return view('frontEnd.layouts.pages.search', compact(
            'products',
            'keyword',
            'category',
            'subcategory',
            'childcategory',
            'subcategories',
            'childcategories',
            'min_price',
            'max_price',
            'all_categories',
            'all_sizes',

        ));
    }

    public function shipping_charge(Request $request)
    {

        $shipping = ShippingCharge::where(['id' => $request->id])->first();
        Session::put('shipping', $shipping ? $shipping->amount : 0);

        return view('frontEnd.layouts.ajax.cart');
    }

    public function contact(Request $request)
    {
        $products = Product::where('status', 1);
        $category = $subcategory = $childcategory = null;
        $subcategories = collect();
        $childcategories = collect();
        $all_categories = Category::where('status', 1)->get();
        $all_sizes = Size::select('sizeName')->distinct()->get();
        $contact = Contact::where('status', 1)->first();
        $maplink = $contact ? $contact->maplink : '';
        // Check if form data is present
        if ($request->has(['name', 'phone', 'email', 'subject', 'message'])) {
            // Validate input
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'phone' => 'required|numeric',
                'email' => 'required|email|max:255',
                'subject' => 'required|string|max:255',
                'message' => 'required|string',

            ]);

            // Prepare data for email
            $data = [
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'subject' => $request->subject,
                'message' => $request->message,
            ];

            // Send email

            if ($contact->email) {
                try {
                    Mail::to($contact->email)->send(new ContactMail($data));
                } catch (Exception $e) {
                    // Log the exception message
                    Log::error('Email sending failed: ' . $e->getMessage());
                }
            }

            // Redirect to the same page with a success message in query parameters
            return redirect()->route('contact')->with('success', 'Your message has been sent successfully!');
        }

        // Load the contact form view with any success message
        return view('frontEnd.layouts.pages.contact', compact(
            'products',
            'category',
            'subcategories',
            'childcategories',
            'all_categories',
            'all_sizes',
            'maplink'
        ));
    }

    public function page($slug)
    {
        $products = Product::where('status', 1);
        $category = $subcategory = $childcategory = null;
        $subcategories = collect();
        $childcategories = collect();
        $all_categories = Category::where('status', 1)->get();
        $all_sizes = Size::select('sizeName')->distinct()->get();

        $page = CreatePage::where('slug', $slug)->firstOrFail();

        return view('frontEnd.layouts.pages.page', compact(
            'page',
            'products',
            'category',
            'subcategories',
            'childcategories',
            'all_categories',
            'all_sizes',

        ));
    }

    public function districts(Request $request)
    {
        $areas = District::where(['district' => $request->id])->pluck('area_name', 'id');

        return response()->json($areas);
    }

    public function campaign($slug)
    {
        $campaign_data = Campaign::where('slug', $slug)->with('images')->first();

        $products = Product::whereIn('id', function ($query) use ($campaign_data) {
            $query->select('product_id')
                ->from('campaign_product')
                ->where('campaign_id', $campaign_data->id);
        })->orWhere('id', $campaign_data->product_id)
            ->where('status', 1)
            ->with('image')
            ->get();

        Cart::instance('shopping')->destroy();
        $cart_count = Cart::instance('shopping')->count();
        $product = $products->first();
        if ($cart_count == 0) {
            Cart::instance('shopping')->add([
                'id' => $product->id,
                'name' => $product->name,
                'qty' => 1,
                'price' => $product->new_price,
                'options' => [
                    'slug' => $product->slug,
                    'image' => $product->image->image,
                    'old_price' => $product->old_price,
                    'purchase_price' => $product->purchase_price,
                ],
            ]);
        }
        // return $products;
        $shippingcharge = ShippingCharge::where('status', 1)->get();
        $select_charge = ShippingCharge::where('status', 1)->first();
        Session::put('shipping', $select_charge->amount);

        return view('frontEnd.layouts.pages.campaign.campaign', compact('campaign_data', 'products', 'shippingcharge'));
    }

    public function payment_success(Request $request)
    {
        $order_id = $request->order_id;
        $shurjopay_service = new ShurjopayController;
        $json = $shurjopay_service->verify($order_id);
        $data = json_decode($json);

        if ($data[0]->sp_code != 1000) {
            Toastr::error('Your payment failed, try again', 'Oops!');
            if ($data[0]->value1 == 'customer_payment') {
                return redirect()->route('home');
            } else {
                return redirect()->route('home');
            }
        }

        if ($data[0]->value1 == 'customer_payment') {

            $customer = Customer::find(Auth::guard('customer')->user()->id);

            // order data save
            $order = new Order;
            $order->invoice_id = $data[0]->id;
            $order->amount = $data[0]->amount;
            $order->customer_id = Auth::guard('customer')->user()->id;
            $order->order_status = $data[0]->bank_status;
            $order->save();

            // payment data save
            $payment = new Payment;
            $payment->order_id = $order->id;
            $payment->customer_id = Auth::guard('customer')->user()->id;
            $payment->payment_method = 'shurjopay';
            $payment->amount = $order->amount;
            $payment->trx_id = $data[0]->bank_trx_id;
            $payment->sender_number = $data[0]->phone_no;
            $payment->payment_status = 'paid';
            $payment->save();
            // order details data save
            foreach (Cart::instance('shopping')->content() as $cart) {
                $order_details = new OrderDetails;
                $order_details->order_id = $order->id;
                $order_details->product_id = $cart->id;
                $order_details->product_name = $cart->name;
                $order_details->purchase_price = $cart->options->purchase_price;
                $order_details->sale_price = $cart->price;
                $order_details->qty = $cart->qty;
                $order_details->save();
            }

            Cart::instance('shopping')->destroy();
            Toastr::error('Thanks, Your payment send successfully', 'Success!');

            return redirect()->route('home');
        }

        Toastr::error('Something wrong, please try agian', 'Error!');

        return redirect()->route('home');
    }

    public function payment_cancel(Request $request)
    {
        $order_id = $request->order_id;
        $shurjopay_service = new ShurjopayController;
        $json = $shurjopay_service->verify($order_id);
        $data = json_decode($json);

        Toastr::error('Your payment cancelled', 'Cancelled!');
        if ($data[0]->sp_code != 1000) {
            if ($data[0]->value1 == 'customer_payment') {
                return redirect()->route('home');
            } else {
                return redirect()->route('home');
            }
        }
    }

    public function offers()
    {
        return view('frontEnd.layouts.pages.offers');
    }
}
