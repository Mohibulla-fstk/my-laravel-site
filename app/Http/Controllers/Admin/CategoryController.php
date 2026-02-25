<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use File;
use Illuminate\Http\Request;
use Image;
use Toastr;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:category-list|category-create|category-edit|category-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:category-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:category-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:category-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $data = Category::orderBy('id', 'DESC')->with('category')->get();

        // return $data;
        return view('backEnd.category.index', compact('data'));
    }

    public function create()
    {
        $categories = Category::orderBy('id', 'DESC')->select('id', 'name')->get();

        return view('backEnd.category.create', compact('categories'));
    }

   public function store(Request $request)
{
    $this->validate($request, [
        'name' => 'required',
        'status' => 'required',
        // 'image' => 'image', // comment out to avoid fileinfo dependency
    ]);

    $imageUrl = null;
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        if ($image->isValid()) {
            $name = time() . '-' . $image->getClientOriginalName();
            $name = strtolower(preg_replace('/\s+/', '-', $name));
            $uploadPath = 'public/uploads/category/';
            $image->move($uploadPath, $name);
            $imageUrl = $uploadPath . $name;
        }
    }

    $input = $request->all();
    $input['slug'] = strtolower(preg_replace('/\s+/', '-', $request->name));
    $input['slug'] = str_replace('/', '', $input['slug']);
    $input['parent_id'] = $request->parent_id ?? 0;
    $input['front_view'] = $request->front_view ? 1 : 0;
    $input['image'] = $imageUrl;

    Category::create($input);
    notify(
        null,
        'New category Create!',
        'New Category "' . " $request->name " .'"' . " Created by " . auth()->user()->name . '.',
        'category', 
        route('categories.index')
    );
    Toastr::success('Success', 'Data insert successfully');

    return redirect()->route('categories.index');
}


    public function edit($id)
    {
        $edit_data = Category::find($id);
        $categories = Category::select('id', 'name')->get();
        
        return view('backEnd.category.edit', compact('edit_data', 'categories'));
    }

    public function update(Request $request)
{
    $this->validate($request, [
        'name' => 'required',
        // 'image' => 'image', // comment out to avoid fileinfo dependency
    ]);

    $update_data = Category::find($request->id);
    $input = $request->all();

    if ($request->hasFile('image')) {
        $image = $request->file('image');
        if ($image->isValid()) {
            $name = time() . '-' . $image->getClientOriginalName();
            $name = strtolower(preg_replace('/\s+/', '-', $name));
            $uploadPath = 'public/uploads/category/';
            $image->move($uploadPath, $name);
            $imageUrl = $uploadPath . $name;

            // old image delete
            if ($update_data->image && file_exists($update_data->image)) {
                @unlink($update_data->image);
            }

            $input['image'] = $imageUrl;
        }
    } else {
        $input['image'] = $update_data->image;
    }

    $input['slug'] = strtolower(preg_replace('/\s+/', '-', $request->name));
    $input['slug'] = str_replace('/', '', $input['slug']);
    $input['parent_id'] = $request->parent_id ?? 0;
    $input['front_view'] = $request->front_view ? 1 : 0;
    $input['status'] = $request->status ? 1 : 0;

    $update_data->update($input);
    notify(
        null,
        'Category "' . "$request->name" . '" Updated!',
        'Category "' . " $request->name " .'"' . " Updated by " . auth()->user()->name . '.',
        'category', 
        route('categories.index')
    );
    Toastr::success('Success', 'Data update successfully');

    return redirect()->route('categories.index');
}


    public function inactive(Request $request)
    {
        $inactive = Category::find($request->hidden_id);
        $inactive->status = 0;
        $inactive->save();
        notify(
        null,
        'Category "' . "$inactive->name" . '" inactive!',
        'Category "' . " $inactive->name " .'"' . " inactive by " . auth()->user()->name . '.',
        'category', 
        route('categories.index')
    );
        Toastr::success('Success', 'Data inactive successfully');

        return redirect()->back();
    }

    public function active(Request $request)
    {
        $active = Category::find($request->hidden_id);
        $active->status = 1;
        $active->save();
        notify(
        null,
        'Category "' . "$active->name" . '" active!',
        'Category "' . " $active->name " .'"' . " active by " . auth()->user()->name . '.',
        'category', 
        route('categories.index')
    );
        Toastr::success('Success', 'Data active successfully');

        return redirect()->back();
    }

    public function destroy(Request $request)
    {
        $delete_data = Category::find($request->hidden_id);
        $delete_data->delete();
        notify(
        null,
        'Category "' . "$delete_data->name" . '" Delete!',
        'Category "' . " $delete_data->name " .'"' . " Deleted by " . auth()->user()->name . '.',
        'category', 
        route('categories.index')
    );
        Toastr::success('Success', 'Data delete successfully');

        return redirect()->back();
    }
}
