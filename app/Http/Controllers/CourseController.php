<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
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
        return view('courses.index');
    }
    public function allCourses(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $search = $request->search['value'];
        $totalBrands = Course::count();
        $brands = Course::when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%");
            });
        })->skip((int) $start)->take((int) $length)->get();
        $brandsCount = Course::when($search, function ($q) use ($search) {
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
        return view('course.add');
    }
    public function store(Request $request)
    {
        $Course = new Course();
        $Course->title = $request->title;
        $Course->description = $request->description;
        $Course->added_by = $this->user->id;
        $Course->type = $request->type;
        $Course->status = 1;
        if ($request->has('image')) {
            $base_path = url('storage');
            $file = $request->file('image');
            $file_name = time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('categories_image', $file_name, 'public');
            $Course->image = $base_path . '/' . $path;
        }
        $Course->save();

        return redirect()->to('index')->with('msg', 'Course Updated Successfully!');;
    }

    public function edit($type, $id)
    {
        $Course = Course::where('_id', $id)->first();
        return view('Course.edit', [
            'Course' => $Course
        ]);
    }

    public function update(Request $request)
    {
        $Course = Course::where('_id', $request->id)->first();
        $Course->title = $request->title;
        $Course->description = $request->description;
        $Course->added_by = $this->user->id;
        $Course->type = $request->type;
        $Course->status = $Course->status;
        if ($request->has('image')) {
            $base_path = url('storage');
            $file = $request->file('image');
            $file_name = time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('categories_image', $file_name, 'public');
            $Course->image = $base_path . '/' . $path;
        }
        $Course->save();

        return redirect()->to('index')->with('msg', 'Course Updated Successfully!');
    }
    public function updateStatus($id)
    {
        $Course = Course::where('_id', $id)->first();
        $status = $Course->status == 1 ? 0 : 1;

        $Course->update([
            'status' => $status
        ]);

        return redirect()->back();
    }
}
