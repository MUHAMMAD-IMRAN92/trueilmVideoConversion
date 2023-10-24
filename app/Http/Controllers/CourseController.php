<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use App\Models\CourseLesson;
use App\Models\LessonVideo;
use Illuminate\Http\Request;
use App\Models\ContentTag;
use App\Models\Questionaire;
use App\Models\QuestionaireOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Tag;

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
        $user_id = auth()->user()->id;
        if (auth()->user()->hasRole('Super Admin')) {
            $user_id = '';
        } else {
            $user_id = auth()->user()->id;
        }

        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $search = $request->search['value'];
        $totalBrands = Course::when($user_id, function ($query) use ($user_id) {
            $query->where('added_by', $user_id);
        })->count();
        $brands = Course::when($user_id, function ($query) use ($user_id) {
            $query->where('added_by', $user_id);
        })->when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%");
            });
        })->orderBy('created_at', 'desc')->skip((int) $start)->take((int) $length)->get();
        $brandsCount = Course::when($user_id, function ($query) use ($user_id) {
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
        $tags = Tag::all();
        $categories = Category::active()->where('type', "4")->get();
        return view('courses.add', [
            'tags' => $tags,
            'categories' => $categories,
        ]);
    }
    public function store(Request $request)
    {
        $course = new Course();
        $course->title = $request->title;
        $course->description = $request->description;
        $course->added_by = $this->user->id;
        $course->status = 1;
        $course->age = $request->age;
        $course->p_type = $request->pRadio;
        $course->price = $request->price;
        $course->category_id = $request->category_id;
        $base_path = 'https://trueilm.s3.eu-north-1.amazonaws.com/';
        if ($request->has('image')) {
            $file = $request->file('image');
            $file_name = time() . '.' . $file->getClientOriginalExtension();
            $path =   $request->file('image')->storeAs('courses_images', $file_name, 's3');
            Storage::disk('s3')->setVisibility($path, 'public');
            $course->image  = $base_path . $path;
        }
        if ($request->has('intro_video')) {
            $file = $request->file('intro_video');
            $file_name = time() . '.' . $file->getClientOriginalExtension();
            $path =   $request->file('intro_video')->storeAs('courses_images', $file_name, 's3');
            Storage::disk('s3')->setVisibility($path, 'public');
            $course->introduction_video  = $base_path . $path;
        }
        if ($request->has('module_overview')) {
            $file = $request->file('module_overview');
            $file_name = time() . '.' . $file->getClientOriginalExtension();
            $path =   $request->file('module_overview')->storeAs('courses_images', $file_name, 's3');
            Storage::disk('s3')->setVisibility($path, 'public');
            $course->module_overview  = $base_path . $path;
        }

        $course->save();
        if ($request->tags) {
            foreach ($request->tags as $key => $tag) {

                $tag = Tag::firstOrCreate(['title' => $tag]);

                $contentTag = ContentTag::firstOrCreate(['tag_id' => $tag->id, 'content_id' => $course->id, 'content_type' => "6"]);
            }
        }
        if ($request->lessons) {
            foreach ($request->lessons as $key => $lesson) {
                $courseLesson = new CourseLesson();
                $courseLesson->title = $lesson;
                $courseLesson->description = $request->descriptions[$key];
                $courseLesson->course_id = $course->id;
                $courseLesson->added_by = $this->user->id;

                if ($request->videos[$key]) {

                    $file = $request->videos[$key];
                    $file_name = time() . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs('courses_videos', $file_name, 's3');
                    Storage::disk('s3')->setVisibility($path, 'public');

                    $courseLesson->video =  $base_path . $path;
                }
                $courseLesson->save();
            }
        }

        return redirect()->to('/courses/edit/' . $course->_id)->with('msg', 'Course Saved Successfully!');;
    }

    public function edit($id)
    {
        $course = Course::where('_id', $id)->with('lessons')->first();
        $contentTag = ContentTag::where('content_id', $id)->get();
        $categories = Category::active()->where('type', "4")->get();
        $tags = Tag::all();
        return view('courses.edit', [
            'course' => $course,
            'tags' => $tags,
            'contentTags' =>  $contentTag,
            'categories' => $categories,
        ]);
    }

    public function update(Request $request)
    {
        $course = Course::where('_id', $request->id)->first();
        $course->title = $request->title;
        $course->description = $request->description;
        $course->added_by = $this->user->id;
        $course->status = 1;
        $course->age = $request->age;
        $course->category_id = $request->category_id;
        $course->p_type = $request->pRadio;
        $course->price = $request->price;
        $base_path = 'https://trueilm.s3.eu-north-1.amazonaws.com/';
        if ($request->has('image')) {
            $file = $request->file('image');
            $file_name = time() . '.' . $file->getClientOriginalExtension();
            $path =   $request->file('image')->storeAs('courses_images', $file_name, 's3');
            Storage::disk('s3')->setVisibility($path, 'public');
            $course->image  = $base_path . $path;
        }
        if ($request->has('intro_video')) {
            $file = $request->file('intro_video');
            $file_name = time() . '.' . $file->getClientOriginalExtension();
            $path =   $request->file('intro_video')->storeAs('courses_images', $file_name, 's3');
            Storage::disk('s3')->setVisibility($path, 'public');
            $course->introduction_video  = $base_path . $path;
        }
        if ($request->has('module_overview')) {
            $file = $request->file('module_overview');
            $file_name = time() . '.' . $file->getClientOriginalExtension();
            $path =   $request->file('module_overview')->storeAs('courses_images', $file_name, 's3');
            Storage::disk('s3')->setVisibility($path, 'public');
            $course->module_overview  = $base_path . $path;
        }
        $course->save();
        if ($request->tags) {

            ContentTag::where('content_id', $course->id)->delete();
            foreach ($request->tags as $key => $tag) {
                $tag = Tag::firstOrCreate(['title' => $tag]);

                $contentTag = ContentTag::firstOrCreate(['tag_id' => $tag->id, 'content_id' => $course->id, 'content_type' => "6"]);
            }
        }
        if ($request->lessons) {
            foreach ($request->lessons as $key => $lesson) {
                $courseLesson = new CourseLesson();
                $courseLesson->title = $lesson;
                $courseLesson->description = $request->descriptions[$key];
                $courseLesson->course_id = $course->id;
                $courseLesson->added_by = $this->user->id;


                if ($request->videos[$key]) {

                    $file = $request->videos[$key];
                    $file_name = time() . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs('courses_videos', $file_name, 's3');
                    Storage::disk('s3')->setVisibility($path, 'public');

                    $courseLesson->video = $base_path . $path;
                }
                $courseLesson->save();
            }
        }
        return redirect()->back()->with('msg', 'Course Saved Successfully!');;
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
    public function courseLessons(Request $request)
    {
        $base_path = 'https://trueilm.s3.eu-north-1.amazonaws.com/';
        if ($request->les_id) {
            $courseLesson = CourseLesson::where('_id', $request->les_id)->first();
        } else {
            $courseLesson = new CourseLesson();
        }

        $courseLesson->title = $request->lesson_title;
        $courseLesson->description = $request->description;
        $courseLesson->course_id = $request->course_id;
        $courseLesson->added_by = $this->user->id;
        $courseLesson->file_duration = @$request->duration[0];
        if ($request->podcast_file) {
            $file_name = time() . '.' . $request->podcast_file->getClientOriginalExtension();
            $path =   $request->podcast_file->storeAs('courses_videos', $file_name, 's3');
            Storage::disk('s3')->setVisibility($path, 'public');
            $courseLesson->file = $base_path . $path;
            if ($request->podcast_file->getClientOriginalExtension() == 'mp3') {
                $courseLesson->type = 1;
            } else {
                $courseLesson->type = 2;
            }
            $courseLesson->book_name = $request->podcast_file->getClientOriginalName();
        }

        if ($request->lesson_notes) {
            $file_name = time() . '.' . $request->lesson_notes->getClientOriginalExtension();
            $path =   $request->lesson_notes->storeAs('courses_videos', $file_name, 's3');
            Storage::disk('s3')->setVisibility($path, 'public');
            $courseLesson->lesson_notes = $base_path . $path;

            $courseLesson->lesson_notes_name = $request->lesson_notes->getClientOriginalName();
        }
        $courseLesson->save();
        return redirect()->back()->with('msg', 'Episode Saved !');
    }

    public function addQuiz($course_id)
    {
        $course =    Course::where('_id', $course_id)->first();
        $courseLesson = CourseLesson::where('course_id', $course_id)->get(['id', 'title']);

        return view('courses.create_quiz', [
            'course' => $course,
            'courseLesson' => $courseLesson
        ]);
    }
    public function postQuiz(Request $request)
    {
        if ($request->question) {
            foreach ($request->question as $key => $q) {
                $question = new Questionaire();
                $question->question = $q;
                $question->lesson_id = $request->lesson_id;
                $question->sequence = $key;
                $question->added_by = $this->user->_id;
                $question->save();

                $correct = 'correct-' . $key;
                $incorrect = 'incorrect-' . $key;

                foreach ($request->$correct as $key1 => $corr) {
                    $questionOpt = new QuestionaireOptions();
                    $questionOpt->question_id =  $question->_id;
                    $questionOpt->option =  $corr;
                    $questionOpt->type =  1;
                    $questionOpt->added_by = $this->user->_id;
                    $questionOpt->save();
                }
                foreach ($request->$incorrect as $key2 => $incorr) {
                    $questionOpt = new QuestionaireOptions();
                    $questionOpt->question_id =  $question->_id;
                    $questionOpt->option =  $incorr;
                    $questionOpt->type =  0;
                    $questionOpt->added_by = $this->user->_id;
                    $questionOpt->save();
                }
            }

            $course =    CourseLesson::where('_id', $request->lesson_id)->update([
                'quiz' => 1
            ]);
        }
        return redirect()->to('/course/edit/' . $request->course_id);
    }
    public function manageQuiz($course_id, $id)
    {
        $courseLesson = CourseLesson::where('course_id', $course_id)->get(['id', 'title']);

        $course =    Course::where('_id', $course_id)->first();
        $question  = Questionaire::where('lesson_id', $id)->with(['options' => function ($q) {
            $q->orderBy('type', 'desc');
        }])->get();
        return view('courses.edit_quiz', [
            'lesson_id' => $id,
            'course' => $course,
            'question' => $question,
            'courseLesson' => $courseLesson
        ]);
    }
    public function updateQuiz(Request $request)
    {
        $questiondel =  Questionaire::where('lesson_id', $request->lesson_id)->pluck('_id');
        QuestionaireOptions::whereIn('question_id', $questiondel)->delete();
        Questionaire::where('lesson_id', $request->lesson_id)->delete();

        if ($request->question) {
            foreach ($request->question as $key => $q) {
                $question = new Questionaire();
                $question->question = $q;
                $question->lesson_id = $request->lesson_id;
                $question->sequence = $key;
                $question->added_by = $this->user->_id;
                $question->save();

                $correct = 'correct-' . $key;
                $incorrect = 'incorrect-' . $key;

                foreach ($request->$correct as $key1 => $corr) {
                    $questionOpt = new QuestionaireOptions();
                    $questionOpt->question_id =  $question->_id;
                    $questionOpt->option =  $corr;
                    $questionOpt->type =  1;
                    $questionOpt->added_by = $this->user->_id;
                    $questionOpt->save();
                }
                foreach ($request->$incorrect as $key2 => $incorr) {
                    $questionOpt = new QuestionaireOptions();
                    $questionOpt->question_id =  $question->_id;
                    $questionOpt->option =  $incorr;
                    $questionOpt->type =  0;
                    $questionOpt->added_by = $this->user->_id;
                    $questionOpt->save();
                }
            }

            $course =    CourseLesson::where('_id', $request->lesson_id)->update([
                'quiz' => 1
            ]);
        }
        return redirect()->to('/course/edit/' . $request->course_id);
    }
}
