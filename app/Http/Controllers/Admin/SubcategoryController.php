<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use Brian2694\Toastr\Facades\Toastr;
use DB;
use File;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class SubcategoryController extends Controller
{
    public function getCategory(Request $request)
    {
        $category = DB::table('categories')
            ->where('service_category', $request->service_category)
            ->pluck('name', 'id');

        return response()->json($category);
    }

    public function __construct()
    {
        $this->middleware('permission:subcategory-list|subcategory-create|subcategory-edit|subcategory-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:subcategory-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:subcategory-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:subcategory-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $data = Subcategory::orderBy('id', 'DESC')->with('category')->get();

        return view('backEnd.subcategory.index', compact('data'));
    }

    public function create()
    {
        $categories = Category::get();

        return view('backEnd.subcategory.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'category_id' => 'required',
            'subcategoryName' => 'required',
           
        ]);
        // image with intervention
        $image = $request->file('image');
        if ($image != null) {
            $name = time().'-'.$image->getClientOriginalName();
            $name = preg_replace('"\.(jpg|jpeg|png|webp)$"', '.webp', $name);
            $name = strtolower(preg_replace('/\s+/', '-', $name));
            $uploadpath = 'public/uploads/subcategory/';
            $imageUrl = $uploadpath.$name;
            $img = Image::make($image->getRealPath());
            $img->encode('webp', 90);
            $width = '';
            $height = '';
            $img->height() > $img->width() ? $width = null : $height = null;
            $img->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->save($imageUrl);
        } else {
            $imageUrl = null;
        }

        $input = $request->all();

        $input['slug'] = strtolower(preg_replace('/\s+/', '-', $request->subcategoryName));
        $input['slug'] = str_replace('/', '', $input['slug']);
        $input['status'] = $request->status ? 1 : 0;
        $input['front_view'] = $request->front_view ? 1 : 0;
        $input['image'] = $imageUrl;
        Subcategory::create($input);
        notify(
            null,
            'New subcategory Create!',
            'New subcategory "' . " $request->subcategoryName " .'"' . " Created by " . auth()->user()->name . '.',
            'category', 
            route('subcategories.index')
        );
        Toastr::success('Success', 'Data insert successfully');

        return redirect()->route('subcategories.index');
    }

    public function edit($id)
    {
        $edit_data = Subcategory::find($id);
        $categories = Category::select('id', 'name')->get();

        return view('backEnd.subcategory.edit', compact('edit_data', 'categories'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'category_id' => 'required',
            'subcategoryName' => 'required',
            
        ]);
        $update_data = Subcategory::find($request->id);
        $input = $request->all();
        $image = $request->file('image');

        if ($image) {
            // image with intervention
            $name = time().'-'.$image->getClientOriginalName();
            $name = preg_replace('"\.(jpg|jpeg|png|webp)$"', '.webp', $name);
            $name = strtolower(preg_replace('/\s+/', '-', $name));
            $uploadpath = 'public/uploads/subcategory/';
            $imageUrl = $uploadpath.$name;
            $img = Image::make($image->getRealPath());
            $img->encode('webp', 90);
            $width = '';
            $height = '';
            $img->height() > $img->width() ? $width = null : $height = null;
            $img->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->save($imageUrl);
            $input['image'] = $imageUrl;
            File::delete($update_data->image);
        } else {
            $input['image'] = $update_data->image;
        }

        $input['slug'] = strtolower(preg_replace('/\s+/', '-', $request->subcategoryName));
        $input['slug'] = str_replace('/', '', $input['slug']);
        $input['status'] = $request->status ? 1 : 0;
        $input['front_view'] = $request->front_view ? 1 : 0;
        $update_data->update($input);
        notify(
            null,
            'Subcategory "' . "$update_data->subcategoryName" . '" Updated!',
            'New subcategory "' . " $update_data->subcategoryName " .'"' . " Updated by " . auth()->user()->name . '.',
            'category', 
            route('subcategories.index')
        );
        Toastr::success('Success', 'Data update successfully');

        return redirect()->route('subcategories.index');
    }

    public function inactive(Request $request)
    {
        $inactive = Subcategory::find($request->hidden_id);
        $inactive->status = 0;
        $inactive->save();
        Toastr::success('Success', 'Data inactive successfully');
        notify(
        null,
        'Subcategory "' . "$inactive->subcategoryName" . '" inactive!',
        'Subcategory "' . " $inactive->subcategoryName " .'"' . " inactive by " . auth()->user()->name . '.',
        'category', 
        route('subcategories.index')
        );
        return redirect()->back();
    }

    public function active(Request $request)
    {
        $active = Subcategory::find($request->hidden_id);
        $active->status = 1;
        $active->save();
        Toastr::success('Success', 'Data active successfully');
        notify(
        null,
        'Subcategory "' . "$active->subcategoryName" . '" active!',
        'Subcategory "' . " $active->subcategoryName " .'"' . " active by " . auth()->user()->name . '.',
        'category', 
        route('subcategories.index')
        );
        return redirect()->back();
    }

    public function destroy(Request $request)
    {
        $delete_data = Subcategory::find($request->hidden_id);
        $delete_data->delete();
        notify(
        null,
        'Subcategory "' . "$delete_data->subcategoryName" . '" Deleted!',
        'Subcategory "' . " $delete_data->subcategoryName " .'"' . " Deleted by " . auth()->user()->name . '.',
        'category', 
        route('subcategories.index')
        );
        Toastr::success('Success', 'Data delete successfully');

        return redirect()->back();
    }
}
