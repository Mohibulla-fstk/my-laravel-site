<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\ChildCategory;
use App\Models\CollectionItem;
use App\Models\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CollectionController extends Controller
{
   public function index()
{
    $collections = Collection::orderBy('sort_order', 'asc')->get();
    return view('backEnd.collections.index', compact('collections'));
}


    public function create()
    {
        return view('backEnd.collections.create');
    }
    public function sort(Request $request)
    {
        foreach ($request->order as $item) {
            Collection::where('id', $item['id'])
                ->update(['sort_order' => $item['position']]);
        }

        return response()->json(['success' => true]);
    }


        // Create collection
public function store(Request $request)
{
    $request->validate([
        'name' => 'required'
    ]);

    $name = $request->name;
    $slug = \Str::slug($name);
    $originalSlug = $slug;

    $counter = 1;
    while(\App\Models\Collection::where('slug', $slug)->exists()) {
        $slug = $originalSlug . '-' . $counter;
        $counter++;
    }

    $collection = Collection::create([
        'name' => $name,
        'slug' => $slug,
        'status' => $request->status ?? 1,
        'created_by' => auth()->id() // <-- যে user create করছে সেই id
    ]);

    // Notification for all users except the creator
    notify(
        null, // null = all users
        'New Collection Added',
        'Collection "' . $collection->name . '" has been added by ' . auth()->user()->name,
        'collection',
        route('collections.index'),
        auth()->id() // pass creator id, so that self doesn't get notification if you want
    );

    return redirect()->route('collections.index')
        ->with('success', 'Collection Created Successfully');
}


    
    public function manageItems($id)
    {
        $collection = Collection::findOrFail($id);

        $categories = Category::where('status',1)->get();
        $subcategories = SubCategory::where('status',1)->get();
        $childcategories = ChildCategory::where('status',1)->get();

        $addedItems = CollectionItem::where('collection_id', $id)->get();

        return view('backEnd.collections.items', compact(
            'collection',
            'categories',
            'subcategories',
            'childcategories',
            'addedItems'
        ));
    }

    // Add category/subcategory/child
    public function addItem(Request $request)
    {
        
        CollectionItem::create([
            'collection_id' => $request->collection_id,
            'item_id' => $request->item_id,
            'item_type' => $request->item_type,
            'item_badge'    => $request->item_badge ?? null,
        ]);
        
        return response()->json(['status' => 'added']);
    }

    // Remove item
    public function removeItem(Request $request)
    {
        CollectionItem::where([
            'collection_id' => $request->collection_id,
            'item_id' => $request->item_id,
            'item_type' => $request->item_type
        ])->delete();

        return response()->json(['status' => 'removed']);
    }
     // ✅ Edit collection page
    public function edit($id)
    {
        $collection = Collection::findOrFail($id);
        return view('backEnd.collections.edit', compact('collection'));
    }

    public function updateBadge(Request $request)
    {
        CollectionItem::where([
            'collection_id' => $request->collection_id,
            'item_id' => $request->item_id,
            'item_type' => $request->item_type
        ])->update([
            'item_badge' => $request->item_badge
        ]);

        return response()->json(['status' => 'success']);
    }

    // ✅ Update collection
    public function update(Request $request, $id)
{
    $collection = Collection::findOrFail($id);

    $request->validate([
        'name' => 'required'
    ]);

    $collection->update([
        'name' => $request->name,
        'slug' => \Str::slug($request->name),
        'status' => $request->status ?? 1,
        'updated_by' => auth()->id() // <-- যে user update করছে
    ]);

    // Notification for all users except the updater
    notify(
        null, // null = all users
        'Collection Updated',
        'Collection "' . $collection->name . '" has been updated by ' . auth()->user()->name,
        'collection',
        route('collections.index'),
        auth()->id() // pass updater id, so that self doesn't get notification if desired
    );

    return redirect()->route('collections.index')
        ->with('success', 'Collection Updated Successfully');
}


    // ✅ Destroy / Delete collection
    public function destroy(Request $request)
    {
        $collection = Collection::findOrFail($request->hidden_id);
        $collection->delete();

        return back()->with('success','Collection Deleted Successfully');
    }

    // ✅ Active toggle
    public function active(Request $request)
    {
        $collection = Collection::findOrFail($request->hidden_id);
        $collection->status = 1;
        $collection->save();

        return back()->with('success', 'Collection Activated Successfully');
    }

    // ✅ Inactive toggle
    public function inactive(Request $request)
    {
        $collection = Collection::find($request->hidden_id);
        $collection->status = 0;
        $collection->save();

        return back()->with('success', 'Collection Inactivated Successfully');
    }
}
