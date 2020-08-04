<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\DataTables as YDT;

class UserController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function getUsers(Request $request, YDT $dataTables)
    {

        $users = User::whereHas('role', function ($query) {
            if(auth()->user()->role->name === 'B2bSfrAdmin'){
                $query->whereIn('name',['B2bSfr','B2bSfrAdmin']);
            }else{
                $query->where('name', 'not like', 'superAdmin');
                $query->whereNotIn('name',['B2bSfr','B2bSfrAdmin']);
            }
        })->get();

        return DataTables::of($users)
            ->setRowId(function ($user) {
                return 'user-' . $user->id;
            })
            ->editColumn('picture', function ($user) {
                return getPicture($user);
            })
            ->editColumn('role', function ($user) {
                return $user->role->name;
            })
//            ->addColumn('role', function ($user) {
//               return $user->role->name;
//            })
            ->toJson();
//            ->make(true);
    }

    public function index(Request $request)
    {
        $this->authorize('view', auth()->user());

        return view('users.index');
    }

    public function create()
    {
        $this->authorize('create', auth()->user());

        if(auth()->user()->role->name === 'B2bSfrAdmin'){
            $roles = Role::whereIn('name',['B2bSfr','B2bSfrAdmin'])->get();
        }else{
            $roles= Role::whereNotIn('name',['B2bSfr','B2bSfrAdmin'])->get();
        }
        return view('users.create')->with(['roles' => $roles]);
    }

    public function store(Request $request)
    {
        // Authorization
        $this->authorize('create', auth()->user());
        // validation
        $validation = $request->validate([
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'gender' => ['nullable', 'in:male,female'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'exists:roles,id'],
        ]);
        $user = User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'picture' => $request->gender == 'male' ? '/storage/users/male.png' : '/storage/users/female.png',
            'email' => $request->email,
            'gender' => $request->gender,
            'status' => $request->status ? true : false,
            'password' => Hash::make($request->password),
            'role_id' => $request->role,
            'agent_name' => ($request->role === 3) ? substr($request->firstname,0,1) .$request->lastname : $request->agent_name,
        ]);

        return redirect('/users');
    }

    public function changeStatus(Request $request, User $user)
    {
        // Authorization
        if (!auth()->user()->isInAdminGroup()) {
            return response()->json(['message' => 'You are not authorized'], 401);
        }

        $user->status = $request->status == 'true' ? true : false;
        $updated = $user->update();
        if ($updated) {
            return response()->json(['message' => 'User Updated Successfully'], 200);
        }
        return response()->json(['message' => 'Un problème est survenue'], 422);
    }

    public function updatePicture(Request $request)
    {
        // Authorization
        $user = auth()->user();

        // Validation
        $validation = $request->validate([
            'picture' => 'image64:jpeg,jpg,png',
        ]);
        // Update
//        $picture = $request->file('picture');
        $picture = $request->picture;
        if ($picture) {
//            $picture = $picture->storeAs('public/users/user_' . $user->id . '/images', 'profile.' . $picture->extension());
//            $picture = str_replace('public', '/storage', $picture);
            list($type, $picture) = explode(';', $picture);
            list(, $picture) = explode(',', $picture);
            $picture = base64_decode($picture);
            $image_name = 'profile.png';
            if (!is_dir('storage/users/user-' . $user->id)) {
                mkdir('storage/users/user-' . $user->id . '/images', 0777, true);
            }
            File::delete('storage/users/user-' . $user->id . '/images/' . $image_name);
            $path = public_path('storage/users/user-' . $user->id . '/images/' . $image_name);
            $result = file_put_contents($path, $picture);
            $picture = '/storage/users/user-' . $user->id . '/images/' . $image_name;
        }
        $user->picture = $picture ?? $user->picture;
        $user->update();

        return back()->with('message', 'Successfully updated');
    }

    public function update(Request $request, User $user)
    {
        // Authorization
//        $this->authorize('update', auth()->user());
        if ($request->get('method')) {
            $user->status = $request->status == 'true' ? true : false;
            $updated = $user->update();
            if ($updated) {
                return response()->json(['message' => 'User Updated Successfully'], 200);
            }
            return response()->json(['message' => 'Un problème est survenue'], 422);
        }
        // Validation
        $validation_rules = [
            'firstname' => ['string', 'max:255'],
            'lastname' => ['string', 'max:255'],
            'email' => ['email', 'max:255', 'unique:users,email,' . $user->id . ',id'],
            'picture' => 'image64:jpeg,jpg,png',
            'gender' => ['nullable', 'in:male,female'],
            'password' => ['nullable', 'string', 'min:8'],
            'role' => ['nullable', 'exists:roles,id']
        ];
        if ($user->isAgency()) {
            $validation_rules['agence_code'] = ['present', 'max:20'];
        } elseif ($user->isAgent()) {
            $validation_rules['agent_name'] = ['present', 'max:20'];
        }
        $validation = $request->validate($validation_rules);
        // Update
//        $picture = $request->file('picture');
        $picture = $request->picture;
        if ($picture) {
//            $picture = $picture->storeAs('public/users/user_' . $user->id . '/images', 'profile.' . $picture->extension());
//            $picture = str_replace('public', '/storage', $picture);
            list($type, $picture) = explode(';', $picture);
            list(, $picture) = explode(',', $picture);
            $picture = str_replace(' ', '+', $picture);
            $picture = base64_decode($picture);
            $image_name = 'profile.png';
            $path = 'storage/users/user-' . $user->id;
            if (!is_dir($path)) {
                mkdir($path . '/images', 0777, true);
            }
            $imagePath = public_path($path . '/images/' . $image_name);
            $result = file_put_contents($imagePath, $picture);
            $picture = '/' . $path . '/images/' . $image_name;
        }
        $user->firstname = $request->firstname ?? $user->firstname;
        $user->lastname = $request->lastname ?? $user->lastname;
        $user->picture = $picture ?? $user->picture;
        $user->email = $request->email ?? $user->email;
        $user->gender = $request->gender ?? $user->gender;
        $user->status = $request->status ? true : false;
        $user->password = $request->password ? Hash::make($request->password) : $user->password;
        $user->role_id = $request->role ?? $user->role_id;
        $user->agent_name = $request->agent_name ?? $user->agent_name;
        $user->save();

        return back()->with('message', 'Successfully updated');
    }

    public function profile()
    {
        $user = auth()->user();
        if(auth()->user()->role->name === 'B2bSfrAdmin'){
            $roles = Role::whereIn('name',['B2bSfr','B2bSfrAdmin'])->get();
        }else{
            $roles= Role::whereNotIn('name',['B2bSfr','B2bSfrAdmin'])->get();
        }
        return view('users.profile')->with(['user' => $user, 'roles' => $roles]);
    }

    public function show(User $user)
    {
        // Authorization
//        $this->authorize('view', auth()->user());

        if(auth()->user()->role->name === 'B2bSfrAdmin'){
            $roles = Role::whereIn('name',['B2bSfr','B2bSfrAdmin'])->get();
        }else{
            $roles= Role::whereNotIn('name',['B2bSfr','B2bSfrAdmin'])->get();
        }
        return view('users.show')->with(['user' => $user, 'roles' => $roles]);
    }


    public function destroy(User $user)
    {
        // Authorization
//        $this->authorize('deleteUser', $user, auth()->user());

        if ($user->isInAdminGroup()) {
            return response()->json(['message' => "Vous n'avez pas le droit de supprimer :<br>Admin / Super Admin"], 422);
        }
        $deleted = $user->delete();
        if ($deleted) {
            return response()->json(['message' => 'User Deleted Successfully'], 200);
        }
        return response()->json(['message' => 'Un problème est survenue'], 422);
    }
}
