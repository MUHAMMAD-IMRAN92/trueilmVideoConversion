<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;
use App\Models\Book;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

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
    public function index()
    {

        return view('category.index');
    }
    public function inActive()
    {

        return view('category.inactive');
    }
    public function allCategory(Request $request)
    {
        if (Session::get('type') == 'undefined') {
            Session::put('type', "1");
        }
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $search = $request->search['value'];
        $totalBrands = Category::active()->count();
        $brands = Category::active()->when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%");
            });
        })->orderBy('created_at', 'desc')->skip((int) $start)->take((int) $length)->get();
        $brandsCount = Category::active()->when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%");
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
        $pcategories = Category::where('parent_id', "0")->get();
        return view('category.add', [
            'pcategories' => $pcategories
        ]);
    }
    public function store(CategoryRequest $request)
    {
        $categoryExit = Category::where('title', $request->title)->first();
        if ($categoryExit) {
            return redirect()->to('categories')->with('dmsg', 'Category Already Exit!');
        } else {
            $category = new Category();
            $category->title = $request->title;
            $category->description = $request->description;
            $category->added_by = $this->user->id;
            $category->type = 0;
            $category->color = $request->color;
            $category->status = 1;
            $category->parent_id = $request->parent_id;
            $base_path = 'https://trueilm.s3.eu-north-1.amazonaws.com/';
            if ($request->has('icon')) {
                $file = $request->file('icon');
                $file_name = time() . '.' . $file->getClientOriginalExtension();
                $path =   $request->file('icon')->storeAs('categories_image', $file_name, 's3');
                Storage::disk('s3')->setVisibility($path, 'public');
                $category->image  = $base_path . $path;
            }
            $category->save();
            return redirect()->to('categories')->with('msg', 'Category Saved Successfully!');
        }
    }

    public function edit($id)
    {
        $pcategories = Category::active()->where('parent_id', "0")->get();
        $category = Category::where('_id', $id)->first();
        return view('category.edit', [
            'category' => $category,
            'pcategories' => $pcategories
        ]);
    }

    public function update(CategoryRequest $request)
    {
        $category = Category::where('_id', $request->id)->first();
        $category->title = $request->title;
        $category->description = $request->description;
        // $category->added_by = $this->user->id;
        $category->type = 0;
        $category->color = $request->color;
        $category->status = $category->status;
        $category->parent_id = $request->parent_id;
        $base_path = 'https://trueilm.s3.eu-north-1.amazonaws.com/';
        if ($request->has('icon')) {
            $file = $request->file('icon');
            $file_name = time() . '.' . $file->getClientOriginalExtension();
            $path =   $request->file('icon')->storeAs('categories_image', $file_name, 's3');
            Storage::disk('s3')->setVisibility($path, 'public');
            $category->image  = $base_path . $path;
        }
        $category->save();

        return redirect()->to('categories')->with('msg', 'Category Updated Successfully!');;
    }
    public function updateStatus($id)
    {
        $book = Book::where('category_id', $id)->get();
        $course = Course::where('category_id', $id)->get();
        $categories = Category::active()->where('_id', '!=', $id)->get();
        $currentCategory = Category::where('_id', $id)->first();
        if (count($book) > 0 || count($course) > 0) {

            return view('category.switch_category', [
                'books' => $book,
                'courses' => $course,
                'categories' => $categories,
                'currentCategory' => $currentCategory
            ]);
        } else {

            $category = Category::where('_id', $id)->first();
            $status = $category->status == 1 ? 0 : 1;

            $category->update([
                'status' => $status
            ]);

            return redirect()->back()->with('msg', 'Category Disabled Successfully!');
        }
    }

    public function allInactiveCategory(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $search = $request->search['value'];
        $totalBrands = Category::inactive()->count();
        $brands = Category::inactive()->when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%");
            });
        })->orderBy('created_at', 'desc')->skip((int) $start)->take((int) $length)->get();
        $brandsCount = Category::inactive()->when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%");
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
    public function updateContentCategory(Request $request)
    {
        if ($request->alternative_category) {
            $book = Book::where('category_id', $request->old_categroy)->update([
                'category_id' => $request->alternative_category
            ]);
            $course = Course::where('category_id', $request->old_categroy)->update([
                'category_id' => $request->alternative_category
            ]);
        }

        return redirect()->to('/categories')->with('msg', 'Category Disabled Successfully!');
    }
}
