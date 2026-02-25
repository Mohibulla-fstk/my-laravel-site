<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use DB;
use File;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Image;
use Spatie\Permission\Models\Role;
use Toastr;
use Carbon;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        // Role priority define করা
        $rolePriority = [
            'Admin'        => 1,
            'Moderator'    => 2,
            'Editor'       => 3,
            'Salesman'     => 4,
            'Analyst'      => 5,
            'Manager'      => 6,
            'Support'      => 7,
            'Guest'        => 8,
            'SuperAdmin'   => 9,
            'Developer'    => 10,
            'Accountant'   => 11,
            'HR'           => 12,
            'Marketing'    => 13,
            'Analitics'    => 14,
        ];

        // সব user নিয়ে আসা + role priority অনুযায়ী sort করা
        $data = User::with('roles')->get()->sortBy(function($user) use ($rolePriority) {
            $minPriority = 999;
            foreach ($user->roles as $role) {
                $minPriority = min($minPriority, $rolePriority[$role->name] ?? 999);
            }
            return $minPriority;
        });

        return view('backEnd.users.index', compact('data'));
    }



    public function showAllUsers()
    {
        // Role priority define করা
        $rolePriority = [
        'Admin'        => 1,
        'Moderator'    => 2,
        'Editor'       => 3,
        'Salesman'     => 4,
        'Analyst'      => 5,
        'Manager'      => 6,
        'Support'      => 7,
        'Guest'        => 8,
        'SuperAdmin'   => 9,
        'Developer'    => 10,
        'Accountant'   => 11,
        'HR'           => 12,
        'Marketing'    => 13,
        'Analitics'    => 14,
    ];

        // সব user নিয়ে আসা
        $users = User::with('roles')->get()->sortBy(function($user) use ($rolePriority) {
            // যদি user multiple role থাকে, priority এর min value নাও
            $minPriority = 999;
            foreach ($user->roles as $role) {
                $minPriority = min($minPriority, $rolePriority[$role->name] ?? 999);
            }
            return $minPriority;
        });

        return view('backEnd.users.alluser', compact('users'));
    }

// Current user last_activity update
     public function updateActivity(Request $request)
    {
        if(auth()->check()){
            $user = auth()->user();
            $user->last_activity = Carbon::now();
            $user->save();
        }

        return response()->json(['status' => 'success']);
    }

    // Fetch all users with last_activity
    public function fetchStatus()
    {
        $users = User::select('id','last_activity','updated_at')->get();
        return response()->json($users);
    }


    public function create()
    {
        $roles = Role::select('name')->get();

        return view('backEnd.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'     => 'required',
            'company_position'     => 'required',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles'    => 'required',
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        // image handle
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $name = time() . '-' . $file->getClientOriginalName();
            $name = strtolower(preg_replace('/\s+/', '-', $name));
            $uploadPath = 'public/uploads/users/';
            $file->move($uploadPath, $name);
            $fileUrl = $uploadPath . $name;
            $input['image'] = $fileUrl;
        } else {
            $input['image'] = null;
        }

        $input['status'] = $request->status ? 1 : 0;

        // create user
        $user = User::create($input);
        $user->assignRole($request->input('roles'));
    notify(
        null, // null = all users
        'New User Added',
        'User "' . $user->name . '" has been added by ' . auth()->user()->name . '.',
        'user', // notification type
        route('users.index') // link to users list
    );
        Toastr::success('Success', 'Data insert successfully');
        return redirect()->route('users.index');
    }


    public function edit($id)
    {
        $edit_data = User::find($id);
        $roles = Role::get();
        
        return view('backEnd.users.edit', compact('edit_data', 'roles'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'name'   => 'required',
            'company_position'     => 'required',
            'email'  => 'required|email|unique:users,email,' . $request->hidden_id,
            'password' => 'same:confirm-password',
            'roles'  => 'required',
        ]);

        $update_data = User::find($request->hidden_id);
        $input = $request->all();

        // password handle
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, ['password']);
        }

        // image handle
        $image = $request->file('image');
        if ($image) {
            $file = $request->file('image');
            $name = time() . '-' . $file->getClientOriginalName();
            $name = strtolower(preg_replace('/\s+/', '-', $name));
            $uploadPath = 'public/uploads/users/';
            $file->move($uploadPath, $name);
            $fileUrl = $uploadPath . $name;
            $input['image'] = $fileUrl;

            // পুরোনো ইমেজ থাকলে ডিলিট করো
            if ($update_data->image && File::exists($update_data->image)) {
                File::delete($update_data->image);
            }
        } else {
            $input['image'] = $update_data->image;
        }

        $input['status'] = $request->status ? 1 : 0;
        $update_data->update($input);

        // role assign
        DB::table('model_has_roles')->where('model_id', $request->hidden_id)->delete();
        // Example: in user update function
if ($update_data->id === auth()->id()) {
    // Case 1: User updated their own info
    notify(
        auth()->id(),
        'Profile Updated',
        'You recently updated your info.',
        'user',
        route('users.index')
    );

    // Notify all other users except updater
    $otherUsers = User::where('id', '!=', auth()->id())->pluck('id');
    foreach ($otherUsers as $userId) {
        notify(
            $userId,
            'User Updated',
            'User "' . $update_data->name . '" updated their info.',
            'user',
            route('users.index')
        );
    }

} else {
    // Case 2: Someone else updated this user
    // Notify the user who was updated
    notify(
        $update_data->id,
        'Profile Updated',
        'Your info was updated by ' . auth()->user()->name . '.',
        'user',
        route('users.index')
    );

    // Notify the updater/admin
    notify(
        auth()->id(),
        'User Updated',
        'You updated "' . $update_data->name . '" info.',
        'user',
        route('users.index')
    );

    // Notify all other users except updater and updated
    $otherUsers = User::whereNotIn('id', [$update_data->id, auth()->id()])->pluck('id');
    foreach ($otherUsers as $userId) {
        notify(
            $userId,
            'User Updated',
            'User "' . $update_data->name . '" updated by ' . auth()->user()->name . '.',
            'user',
            route('users.index')
        );
    }
}



        $update_data->assignRole($request->input('roles'));

        Toastr::success('Success', 'Data update successfully');
        return redirect()->route('users.index');
    }


    public function inactive(Request $request)
    {
        $inactive = User::find($request->hidden_id);
        $inactive->status = 0;
        $inactive->save();
        Toastr::success('Success', 'Data inactive successfully');
        notify(
                null, // null = all users
                'User Inactive',
                'User "' . $inactive->name . '" inactive by ' . auth()->user()->name . ' on this site' . '.',
                'user', // notification type
                route('users.index') // link to users list
            );
        return redirect()->back();
    }

    public function active(Request $request)
    {
        $active = User::find($request->hidden_id);
        $active->status = 1;
        $active->save();
        Toastr::success('Success', 'Data active successfully');
        notify(
                null, // null = all users
                'User Active',
                'User "' . $active->name . '" active by ' . auth()->user()->name . ' on this site' . '.',
                'user', // notification type
                route('users.index') // link to users list
            );
        return redirect()->back();
    }

    public function destroy(Request $request)
    {

        $delete_data = User::find($request->hidden_id);
        if ($delete_data->id != 1) {
            File::delete($delete_data->image);
            $delete_data->delete();
            Toastr::success('Success', 'Data delete successfully');
            notify(
                null, // null = all users
                'User Remove',
                'User "' . $delete_data->name . '" removed by ' . auth()->user()->name . '.',
                'user', // notification type
                route('users.index') // link to users list
            );
        } else {
            Toastr::success('error', 'Data delete unsuccessfully');
        }

        return redirect()->back();
    }
}
