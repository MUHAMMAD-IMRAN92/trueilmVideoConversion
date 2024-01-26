<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Imports\UsersImport;
use App\Models\Book;
use App\Models\BookLastSeen;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maklad\Permission\Models\Role;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

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
        })->orderBy('created_at', 'desc')->skip((int) $start)->take((int) $length)->get();
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
        if (auth()->user()->hasRole('Super Admin')) {
            $roles = Role::all();
        } else {
            $roles = Role::whereIn('name', ['Admin', 'Publisher', 'Institute'])->get();
        }

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
        } else if ($request->role == 'Institute') {
            $type = 3;
        } else {
            $type = 4;
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

        $books = Book::where('added_by', $id)->update([
            'status', 0
        ]);
        $courses = Course::where('added_by', $id)->update([
            'status', 0
        ]);
        return redirect()->to('/user-management')->with('msg', 'User Deleted Successfully!');
    }

    public function appUsers()
    {
        $brands = User::whereNull('deleted_at')->whereNull('type')->get();
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
        $bookRead = Book::whereHas('bookTraking', function ($q) use ($id, $request) {
            $q->where('user_id', $id)->when($request->e_date, function ($q) use ($request) {
                $q->whereBetween('createdAt', [new Carbon($request->s_date),  new Carbon($request->e_date)]);
            });
        })->with(['bookTraking' => function ($q1) {
            $q1->first();
        }])->paginate(10);
        return view('user.user_book_details', [
            'book_read' => $bookRead,
            'user_id' => $id,
            's_date' => $request->s_date,
            'e_date' => $request->e_date
        ]);
    }
    public function instituteUsers()
    {
        return view('institute.users');
    }
    public function allInstituteUsers(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $search = $request->search['value'];
        $totalBrands = User::where('institute_id', $this->user->_id)->whereNull('deleted_at')->count();
        $brands = User::where('institute_id', $this->user->_id)->whereNull('deleted_at')->when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")->orWhere('email', 'like',  "%$search%");
            });
        })->skip((int) $start)->take((int) $length)->get();
        $brandsCount = User::where('institute_id', $this->user->_id)->whereNull('deleted_at')->when($search, function ($q) use ($search) {
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
    public function addInstituteUsers()
    {
        return view('institute.add');
    }
    public function storeInstituteUsers(UserRequest $request)
    {

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = Hash::make($request->password);
        $user->added_by = $this->user->id;
        $user->institute_id =  $this->user->id;
        $user->save();

        return redirect()->to('/institute/users')->with('msg', 'User Saved Successfully!');
    }
    public function deleteInstituteUsers($id)
    {
        $user = User::where('_id', $id)->first();
        $user->forceDelete();
        return redirect()->to('/institute/users')->with('msg', 'User Deleted Successfully!');
    }
    public function downloadSample()
    {
        $filepath = public_path('/files/sample.xlsx');
        return Response::download($filepath);
    }
    public function importUser(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|file|mimes:csv,xlsx',
        ]);

        $file = $request->file;
        Excel::import(new UsersImport, $file);

        return redirect('/institute/users')->with('msg', 'User Imported Successfully!');
    }
    public function affiliate()
    {
        $users =   User::whereHas('refferer')->with('refferer')->paginate(10);

        return view('affliate_users.index', [
            'users' => $users
        ]);
    }
    public function reffered($id)
    {
        $users =   User::where('reffer_id', $id)->paginate(10);

        return view('affliate_users.reffered', [
            'users' => $users
        ]);
    }
    public function family()
    {
        $users =   User::whereHas('family')->with('family')->paginate(10);

        return view('family_users.index', [
            'users' => $users
        ]);
    }
    public function members($id)
    {
        $users =   User::where('parentId', $id)->paginate(10);

        return view('family_users.reffered', [
            'users' => $users
        ]);
    }
    public function cancelSubscription()
    {
        $brands = User::whereNull('deleted_at')->whereNull('type')->get();
        $table = 'cancel-subsciption';
        return view('user.app_users', [
            'table' => $table
        ]);
    }
    public function allCancelSubscription(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $search = $request->search['value'];
        $totalBrands = User::whereHas('cancelSubscription')->whereNull('deleted_at')->whereNull('type')->count();
        $brands = User::whereHas('cancelSubscription')->whereNull('deleted_at')->whereNull('type')->when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")->orWhere('email', 'like',  "%$search%");
            });
        })->skip((int) $start)->take((int) $length)->get();
        $brandsCount = User::whereHas('cancelSubscription')->whereNull('deleted_at')->whereNull('type')->when($search, function ($q) use ($search) {
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
}
