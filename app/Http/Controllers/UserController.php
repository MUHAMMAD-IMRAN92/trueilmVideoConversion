<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\BookLastSeen;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maklad\Permission\Models\Role;
use Carbon\Carbon;

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
        $totalBrands = User::whereNull('deleted_at')->whereNotNull('type')->count();
        $brands = User::whereNull('deleted_at')->whereNotNull('type')->when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")->orWhere('email', 'like',  "%$search%");
            });
        })->skip((int) $start)->take((int) $length)->get();
        $brandsCount = User::whereNull('deleted_at')->whereNotNull('type')->when($search, function ($q) use ($search) {
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
        $user = User::where('name', 'dev')->first();
        $role = Role::where('name', 'Admin')->first();
        // $permission = Permission::create(['name' => 'all']);
        // $role->givePermissionTo($permission);
        // $user->assignRole($role);


        $user = User::where('_id', $id)->first();
        $roles = Role::all();

        return view('user.edit', [
            'user' => $user,
            'roles' => $roles
        ]);
    }

    public function update(Request $request)
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

    public function delete($id)
    {
        $user = User::where('_id', $id)->first();
        $user->delete();
        return redirect()->to('/user-management')->with('msg', 'User Deleted Successfully!');
    }

    public function appUsers()
    {
        return view('user.app_users');
    }
    public function allAppUser(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $search = $request->search['value'];
        $totalBrands = User::whereNull('deleted_at')->whereNull('type')->count();
        $brands = User::whereNull('deleted_at')->whereNull('type')->when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")->orWhere('email', 'like',  "%$search%");
            });
        })->skip((int) $start)->take((int) $length)->get();
        $brandsCount = User::whereNull('deleted_at')->whereNull('type')->when($search, function ($q) use ($search) {
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
    public function userBookReadingDetail(Request $request, $id)
    {
        // return $request->all();
        $bookRead =  BookLastSeen::where('user_id', $id)->when($request->e_date, function ($q) use ($request) {
            $q->whereBetween('created_at', [new Carbon($request->s_date),  new Carbon($request->e_date)]);
        })->with('book')->get();
        return view('user.user_book_details', [
            'book_read' => $bookRead,
            'user_id' => $id,
            's_date' => $request->s_date,
            'e_date' => $request->e_date
        ]);
    }
}
