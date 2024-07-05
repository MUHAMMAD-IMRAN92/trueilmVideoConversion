<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseSeries;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CourseSeriesController extends Controller
{
    public $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }
    public function seriesIndex()
    {
        return view('course_series.index');
    }
    public function allSeries(Request $request)
    {
        $user_id = auth()->user()->id;
        if(auth()->user()->email == env('super_admin_email')) {
            $user_id = '';
        } else {
            $user_id = auth()->user()->id;
        }

        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $search = $request->search['value'];
        $totalBrands = CourseSeries::when($user_id, function ($query) use ($user_id) {
            $query->where('added_by', $user_id);
        })->count();
        $brands = CourseSeries::when($user_id, function ($query) use ($user_id) {
            $query->where('added_by', $user_id);
        })->when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%");
            });
        })->orderBy('created_at', 'desc')->skip((int) $start)->take((int) $length)->get();
        $brandsCount = CourseSeries::when($user_id, function ($query) use ($user_id) {
            $query->where('added_by', $user_id);
        })->when($search, function ($q) use ($search) {
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
    public function add()
    {
        $courses = Course::approved()->get(['_id', 'title']);
        return view('course_series.add', [
            'courses' =>  $courses
        ]);
    }
    public function store(Request $request)
    {
        $courseSeries = new CourseSeries();
        $courseSeries->title = $request->title;
        $courseSeries->description = $request->description;
        $courseSeries->added_by = $this->user->id;
        $courseSeries->status = 1;
        $courseSeries->courses = $request->courses;
        if ($request->has('image')) {
            $base_path = 'https://trueilm.s3.eu-north-1.amazonaws.com/';
            $file = $request->file('image');
            $file_name = time() . '.' . $file->getClientOriginalExtension();
            $path =   $request->file('image')->storeAs('courses_series_images', $file_name, 's3');
            Storage::disk('s3')->setVisibility($path, 'public');
            $courseSeries->image  = $base_path . $path;
        }
        $courseSeries->save();
        return redirect()->to('/series')->with('msg', 'Series Saved Successfully!');
    }

    public function edit(Request $request, $id)
    {
        $series =  CourseSeries::where('_id', $id)->first();
        $courses = Course::approved()->get(['_id', 'title']);
        return view('course_series.edit', [
            'series' =>  $series,
            'courses' =>  $courses
        ]);
    }

    public function update(Request $request)
    {
        $courseSeries =  CourseSeries::findOrFail($request->id);
        $courseSeries->title = $request->title;
        $courseSeries->description = $request->description;
        $courseSeries->added_by = $this->user->id;
        $courseSeries->status = 1;
        $courseSeries->courses = $request->courses;
        if ($request->has('image')) {
            $base_path = 'https://trueilm.s3.eu-north-1.amazonaws.com/';
            $file = $request->file('image');
            $file_name = time() . '.' . $file->getClientOriginalExtension();
            $path =   $request->file('image')->storeAs('courses_series_images', $file_name, 's3');
            Storage::disk('s3')->setVisibility($path, 'public');
            $courseSeries->image  = $base_path . $path;
        }
        $courseSeries->save();
        return redirect()->to('/series')->with('msg', 'Series Updated Successfully!');
    }
    public function updateStatus($id)
    {
        $courseSeries = CourseSeries::findOrFail($id);

        $status = $courseSeries->status == 1 ? 0 : 1;

        $courseSeries->update([
            'status' => $status
        ]);

        return redirect()->back();
    }
}
