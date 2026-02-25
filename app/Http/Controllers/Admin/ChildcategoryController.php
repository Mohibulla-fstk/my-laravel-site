<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Childcategory;
use App\Models\Subcategory;
use DB;
use Illuminate\Http\Request;
use Image;
use Toastr;

class ChildcategoryController extends Controller
{
    public function getSubCategory(Request $request)
    {
        $category = DB::table('subcategories')
            ->where('subcategorytype', $request->childcategorytype)
            ->pluck('subcategoryName', 'id');

        return response()->json($category);
    }

    public function __construct()
    {
        $this->middleware('permission:childcategory-list|childcategory-create|childcategory-edit|childcategory-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:childcategory-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:childcategory-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:childcategory-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $data = Childcategory::orderBy('id', 'DESC')->with('subcategory')->get();

        return view('backEnd.childcategory.index', compact('data'));
    }

    public function create()
    {
        return view('backEnd.childcategory.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'subcategory_id' => 'required',
            'childcategoryName' => 'required',
         
        ]);
        // image with intervention

        $input = $request->all();

        $input['slug'] = strtolower(preg_replace('/\s+/', '-', $request->childcategoryName));
        $input['slug'] = str_replace('/', '', $input['slug']);
        $input['status'] = $request->status ? 1 : 0;
        $input['front_view'] = $request->front_view ? 1 : 0;
        Childcategory::create($input);
        notify(
        null,
        'New childcategory Create!',
        'New childcategory "' . " $request->childcategoryName " .'"' . " Created by " . auth()->user()->name . '.',
        'category', 
        route('childcategories.index')
    );
        Toastr::success('Success', 'Data insert successfully');

        return redirect()->route('childcategories.index');
    }

    public function edit($id)
    {
        $edit_data = Childcategory::find($id);
        $categories = Subcategory::select('id', 'subcategoryName')->get();

        return view('backEnd.childcategory.edit', compact('edit_data', 'categories'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'subcategory_id' => 'required',
            'childcategoryName' => 'required',
            
        ]);
        $update_data = Childcategory::find($request->id);
        $input = $request->all();

        $input['slug'] = strtolower(preg_replace('/\s+/', '-', $request->childcategoryName));
        $input['slug'] = str_replace('/', '', $input['slug']);
        $input['status'] = $request->status ? 1 : 0;
        $input['front_view'] = $request->front_view ? 1 : 0;
        $update_data->update($input);
        notify(
        null,
        'Childcategory "' . "$update_data->childcategoryName" . '" Updated!',
        'Childcategory "' . " $update_data->childcategoryName " .'"' . " Updated by " . auth()->user()->name . '.',
        'category', 
        route('childcategories.index')
        );
        Toastr::success('Success', 'Data update successfully');

        return redirect()->route('childcategories.index');
    }

    public function inactive(Request $request)
    {
        $inactive = Childcategory::find($request->hidden_id);
        $inactive->status = 0;
        $inactive->save();
        Toastr::success('Success', 'Data inactive successfully');
        notify(
        null,
        'Childcategory "' . "$inactive->childcategoryName" . '" inactive!',
        'Childcategory "' . " $inactive->childcategoryName " .'"' . " inactive by " . auth()->user()->name . '.',
        'category', 
        route('childcategories.index')
        );
        return redirect()->back();
    }

    public function active(Request $request)
    {
        $active = Childcategory::find($request->hidden_id);
        $active->status = 1;
        $active->save();
        Toastr::success('Success', 'Data active successfully');
        notify(
        null,
        'Childcategory "' . "$active->childcategoryName" . '" active!',
        'Childcategory "' . " $active->childcategoryName " .'"' . " active by " . auth()->user()->name . '.',
        'category', 
        route('childcategories.index')
        );
        return redirect()->back();
    }

    public function destroy(Request $request)
    {
        $delete_data = Childcategory::find($request->hidden_id);

        if (! $delete_data) {
            Toastr::error('Error', 'Childcategory পাওয়া যায়নি');

            return redirect()->back();
        }

        $delete_data->delete();
        notify(
        null,
        'Childcategory "' . "$delete_data->childcategoryName" . '" Delete!',
        'Childcategory "' . " $delete_data->childcategoryName " .'"' . " Deleted by " . auth()->user()->name . '.',
        'category', 
        route('childcategories.index')
        );
        Toastr::success('Success', 'Data delete successfully');

        return redirect()->back();
    }
}
