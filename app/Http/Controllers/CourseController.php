<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseLesson;
use App\Models\LessonVideo;
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
                $q->where('title', 'like', "%$search%");
            });
        })->skip((int) $start)->take((int) $length)->get();
        $brandsCount = Course::when($search, function ($q) use ($search) {
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
        return view('courses.add');
    }
    public function store(Request $request)
    {
        $course = new Course();
        $course->title = $request->title;
        $course->description = $request->description;
        $course->added_by = $this->user->id;
        $course->status = 1;
        if ($request->has('image')) {
            $base_path = url('storage');
            $file = $request->file('image');
            $file_name = time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('courses_images', $file_name, 'public');
            $course->image = $base_path . '/' . $path;
        }
        $course->save();
        if ($request->lessons) {
            foreach ($request->lessons as $key => $lesson) {
                $courseLesson = new CourseLesson();
                $courseLesson->title = $lesson;
                $courseLesson->description = $request->descriptions[$key];
                $courseLesson->course_id = $course->id;
                $courseLesson->added_by = $this->user->id;

                if ($request->videos[$key]) {
                    $base_path = url('storage');
                    $file = $request->videos[$key];
                    $file_name = time() . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs('courses_videos', $file_name, 'public');

                    $courseLesson->video = $base_path . '/' . $path;
                }
                $courseLesson->save();
            }
        }
        return redirect()->to('/courses')->with('msg', 'Course Saved Successfully!');;
    }

    public function edit($id)
    {
        $course = Course::where('_id', $id)->with('lessons')->first();
        return view('courses.edit', [
            'course' => $course
        ]);
    }

    public function update(Request $request)
    {
        $course = Course::where('_id', $request->id)->first();
        $course->title = $request->title;
        $course->description = $request->description;
        $course->added_by = $this->user->id;
        $course->status = 1;
        if ($request->has('image')) {
            $base_path = url('storage');
            $file = $request->file('image');
            $file_name = time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('courses_images', $file_name, 'public');
            $course->image = $base_path . '/' . $path;
        }
        $course->save();
        if ($request->lessons) {
            foreach ($request->lessons as $key => $lesson) {
                $courseLesson = new CourseLesson();
                $courseLesson->title = $lesson;
                $courseLesson->description = $request->descriptions[$key];
                $courseLesson->course_id = $course->id;
                $courseLesson->added_by = $this->user->id;

                if ($request->videos[$key]) {
                    $base_path = url('storage');
                    $file = $request->videos[$key];
                    $file_name = time() . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs('courses_videos', $file_name, 'public');

                    $courseLesson->video = $base_path . '/' . $path;
                }
                $courseLesson->save();
            }
        }
        return redirect()->to('/courses')->with('msg', 'Course Saved Successfully!');;
    }
    public function updateStatus($id)
    {
        $course = Course::where('_id', $id)->first();
        $status = $course->status == 1 ? 0 : 1;

        $course->update([
            'status' => $status
        ]);

        return redirect()->back();
    }
}
