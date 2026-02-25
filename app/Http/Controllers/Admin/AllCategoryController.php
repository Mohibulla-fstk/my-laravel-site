<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Childcategory;
use App\Models\CollectionItem;
use Illuminate\Http\Request;

class AllCategoryController extends Controller
{
    
   public function index()
{
    $categories = Category::select(
        'id',
        'name as name',
        'status',
        'front_view',
        'sort_order',
        'badge',
        \DB::raw("'category' as type")
    );

    $subcategories = Subcategory::select(
        'id',
        'subcategoryName as name',
        'status',
        'front_view',
        'sort_order',
        'badge',
        \DB::raw("'subcategory' as type")
    );

    $childcategories = Childcategory::select(
        'id',
        'childcategoryName as name',
        'status',
        'front_view',
        'sort_order',
        'badge',
        \DB::raw("'childcategory' as type")
    );

    // 🔥 UNION + GLOBAL SORT
    $allCategories = $categories
        ->unionAll($subcategories)
        ->unionAll($childcategories)
        ->orderBy('sort_order', 'asc')
        ->get();

    return view('backEnd.allCategories.index', compact('allCategories'));
}



    // 🔥 STATUS + FRONT VIEW UPDATE
public function statusUpdate(Request $request)
{
    $type = $request->type;   // category / subcategory / childcategory
    $id = $request->id;
    $field = $request->field; // status / front_view
    $value = $request->value;

    $model = match ($type) {
        'category' => Category::class,
        'subcategory' => Subcategory::class,
        'childcategory' => Childcategory::class,
        default => null,
    };

    if(!$model) return response()->json(['error'=>'Invalid type'], 400);

    $item = $model::find($id);
    if(!$item) return response()->json(['error'=>'Item not found'], 404);

    $item->$field = $value;
    $item->save();

    // 🔹 Update collection_items for Polymorphic setup
    if($field === 'status'){
        CollectionItem::where('item_type', ucfirst($type))
            ->where('item_id', $id)
            ->update(['status' => $value]);
    }

    $typeLabel = ucfirst($type); // Category / Subcategory / Childcategory
    $fieldLabel = str_replace('_', ' ', ucfirst($field)); // Status / Front view
    $statusText = $value ? 'Enabled' : 'Disabled';

    $itemName =
        $type === 'category' ? $item->name :
        ($type === 'subcategory' ? $item->subcategoryName :
        $item->childcategoryName);

    notify(
        null,
        "$typeLabel Updated!",
        "$typeLabel \"$itemName\" $fieldLabel has been $statusText by " . auth()->user()->name . '.',
        'category',
        match ($type) {
            'category'      => route('allCategories.index'),
            'subcategory'   => route('allCategories.index'),
            'childcategory' => route('allCategories.index'),
        }
    );

    return response()->json(['success'=>true]);
}



    public function updateSort(Request $request)
    {
        foreach ($request->order as $item) {

            $model = match ($item['type']) {
                'category' => Category::class,
                'subcategory' => Subcategory::class,
                'childcategory' => Childcategory::class,
            };

            // Update sort_order
            $model::where('id', $item['id'])
                ->update(['sort_order' => $item['sort_order']]);
        }
        
        return response()->json(['success' => true]);
    }

public function updateBadge(Request $request)
{
    // validation
    $request->validate([
        'item_id'    => 'required',
        'item_type'  => 'required|in:category,subcategory,childcategory',
        'item_badge' => 'nullable|string',
    ]);

    $type  = $request->item_type;
    $badge = $request->item_badge;

    /* ================= MAIN TABLE UPDATE ================= */

    switch ($type) {

        case 'category':
            $item = Category::findOrFail($request->item_id);
            $oldBadge = $item->badge; // capture old badge
            $item->update(['badge' => $badge]);
            $itemName = $item->name;
            break;

        case 'subcategory':
            $item = Subcategory::findOrFail($request->item_id);
            $oldBadge = $item->badge;
            $item->update(['badge' => $badge]);
            $itemName = $item->subcategoryName;
            break;

        case 'childcategory':
            $item = Childcategory::findOrFail($request->item_id);
            $oldBadge = $item->badge;
            $item->update(['badge' => $badge]);
            $itemName = $item->childcategoryName;
            break;
    }

    /* ================= COLLECTION ITEM SYNC ================= */

    CollectionItem::where([
        'item_id'   => $request->item_id,
        'item_type' => $type,
    ])->update([
        'item_badge' => $badge
    ]);

    /* ================= NOTIFY ================= */

    $typeLabel  = ucfirst($type);
    $fieldLabel = 'Badge';
    $statusText = $badge ? 'updated' : 'removed';

    $oldBadgeText = $oldBadge ?: 'None';
    $newBadgeText = $badge ?: 'None';

    notify(
        null,
        "$typeLabel Badge Updated!",
        "$typeLabel \"$itemName\" badge has been $statusText (from \"$oldBadgeText\" → \"$newBadgeText\") by " 
        . auth()->user()->name . '.',
        'category',
        match ($type) {
            'category'      => route('allCategories.index'),
            'subcategory'   => route('allCategories.index'),
            'childcategory' => route('allCategories.index'),
        }
    );

    return response()->json([
        'status' => 'success',
        'badge'  => $badge
    ]);
}



}

