<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Toastr;

class ContactController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:contact-list|contact-create|contact-edit|contact-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:contact-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:contact-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:contact-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $show_data = Contact::orderBy('id', 'DESC')->get();

        return view('backEnd.contact.index', compact('show_data'));
    }

    public function create()
    {
        return view('backEnd.contact.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'phone' => 'required',
            'email' => 'required',
            'address' => 'required',
            'status' => 'required',
            'maplink' => 'nullable|string',
        ]);

        $input = $request->all();

        // map_link থেকে lat/lng বের করা
        if ($request->filled('maplink')) {
            if ($coords = $this->extractLatLng($request->maplink)) {
                $input['lat'] = $coords['lat'];
                $input['lng'] = $coords['lng'];
            }
        } else {
            $input['lat'] = null;
            $input['lng'] = null;
        }

        Contact::create($input);

        Toastr::success('Success', 'Data insert successfully');

        return redirect()->route('contact.index');
    }

    public function edit($id)
    {
        $edit_data = Contact::find($id);

        return view('backEnd.contact.edit', compact('edit_data'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'phone' => 'required',
            'hotmail' => 'required',
            'address' => 'required',
            'maplink' => 'nullable|string',
        ]);

        $update_data = Contact::findOrFail($request->hidden_id);

        // প্রথমে সব field update করি, lat/lng বাদ দিয়ে
        $update_data->fill($request->except('hidden_id', 'lat', 'lng'));

        // map_link থেকে lat/lng update
        if ($request->filled('maplink')) {
            if ($coords = $this->extractLatLng($request->maplink)) {
                $update_data->lat = $coords['lat'];
                $update_data->lng = $coords['lng'];
            }
        } else {
            $update_data->lat = null;
            $update_data->lng = null;
        }

        $update_data->save();

        Toastr::success('Success', 'Data update successfully');

        return redirect()->route('contact.index');
    }

    private function extractLatLng($url)
    {
        $coords = null;

        // Improved regex: @lat,lng optionally followed by z
        if (preg_match('/@([-0-9\.]+),([-0-9\.]+)/', $url, $matches)) {
            $coords = [
                'lat' => $matches[1],
                'lng' => $matches[2],
            ];
        }

        return $coords;
    }

    public function inactive(Request $request)
    {
        $inactive = Contact::find($request->hidden_id);
        $inactive->status = 1;
        $inactive->save();
        Toastr::success('Success', 'Data inactive successfully');

        return redirect()->back();
    }

    public function active(Request $request)
    {
        $active = Contact::find($request->hidden_id);
        $active->status = 1;
        $active->save();
        Toastr::success('Success', 'Data active successfully');

        return redirect()->back();
    }

    public function destroy(Request $request)
    {
        $delete_data = Contact::find($request->hidden_id);
        $delete_data->delete();
        Toastr::success('Success', 'Data delete successfully');

        return redirect()->back();
    }
}
