<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{
    public $user;
    public $type;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            $this->type =  Session::get('type');
            return $next($request);
        });
    }
    public function index($type)
    {
        Session::put('type', $type);
        return view('category.index', [
            'type' => $type
        ]);
    }
    public function allCategory(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $search = $request->search['value'];
        $totalBrands = Category::where('type', $this->type)->count();
        $brands = Category::where('type', $this->type)->when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%");
            });
        })->skip((int) $start)->take((int) $length)->get();
        $brandsCount = Category::where('type', $this->type)->when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%");
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
    public function create()
    {
        return view('category.add', [
            'type' => $this->type
        ]);
    }
    public function store(CategoryRequest $request)
    {
        $category = new Category();
        $category->title = $request->title;
        $category->description = $request->description;
        $category->added_by = $this->user->id;
        $category->type = $request->type;
        $category->status = 1;
        $category->save();

        return redirect()->to('categories/' . $this->type)->with('msg', 'Publisher Saved Successfully!');;
    }

    public function edit($type, $id)
    {
        $category = Category::where('_id', $id)->first();
        return view('category.edit', [
            'category' => $category,
            'type' => $this->type
        ]);
    }

    public function update(CategoryRequest $request)
    {
        $category = Category::where('_id', $request->id)->first();
        $category->title = $request->title;
        $category->description = $request->description;
        $category->added_by = $this->user->id;
        $category->type = $request->type;
        $category->status = $category->status;
        $category->save();

        return redirect()->to('categories/' . $this->type)->with('msg', 'Publisher Updated Successfully!');;
    }
    public function updateStatus($id)
    {
        $category = Category::where('_id', $id)->first();
        $status = $category->status == 1 ? 0 : 1;

        $category->update([
            'status' => $status
        ]);

        return redirect()->back();
    }
}
