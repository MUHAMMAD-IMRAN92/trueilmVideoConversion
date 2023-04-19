<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public $user;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();

            return $next($request);
        });
    }
    public function index()
    {
        return view('user.index');
    }
    public function allUser(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $search = $request->search['value'];
        $totalBrands = User::count();
        $brands = User::when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")->orWhere('email', 'like',  "%$search%");
            });
        })->skip((int) $start)->take((int) $length)->get();
        $brandsCount = User::when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")->orWhere('email', 'like',  "%$search%");;
            });
        })->skip((int) $start)->take((int) $length)->count();
        $data = array(
            'draw' => $draw,
            'recordsTotal' => $totalBrands,
            'recordsFiltered' => $brandsCount,
            'data' => $brands,
        );
        return json_encode($data);
    }
    public function add()
    {
        $roles = Role::all();
        return view('user.add', [
            'roles' => $roles
        ]);
    }
    public function store(UserRequest $request)
    {
        $type = 0;
        if ($request->role == 'Admin') {
            $type = 1;
        } elseif ($request->role == 'Publisher') {
            $type = 2;
        } else {
            $type = 3;
        }
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = Hash::make($request->password);
        $user->added_by = $this->user->id;
        $user->type = $type;
        $user->save();

        $user->assignRole($request->input('role'));

        return redirect()->to('/user-management')->with('msg', 'User Saved Successfully!');;
    }

    public function edit($id)
    {
        $user = User::where('_id', $id)->first();
        $roles = Role::all();

        return view('user.edit', [
            'user' => $user,
            'roles' => $roles
        ]);
    }

    public function update(UserRequest $request)
    {
        $type = 0;
        if ($request->role == 'Admin') {
            $type = 1;
        } elseif ($request->role == 'Publisher') {
            $type = 2;
        } else {
            $type = 3;
        }
        $user = User::where('_id', $request->id)->first();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->added_by = $this->user->id;
        $user->type = $type;
        $user->save();

        return redirect()->to('/user-management')->with('msg', 'User Updated Successfully!');;
    }
}
