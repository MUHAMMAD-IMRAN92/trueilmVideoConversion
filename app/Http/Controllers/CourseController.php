<?php

namespace App\Http\Controllers;

use App\Jobs\SendNotifications;
use App\Models\Author;
use App\Models\AppSectionContent;
use App\Models\Category;
use App\Models\Course;
use App\Models\AppSection;
use App\Models\CourseLesson;
use App\Models\LessonVideo;
use Illuminate\Http\Request;
use App\Models\ContentTag;
use App\Models\Languages;
use App\Models\Questionaire;
use App\Models\QuestionaireOptions;
use App\Models\QuizAttempts;
use App\Models\Scopes\DeletedAtScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Tag;
use Carbon\Carbon;
use Meilisearch\Client;
use JamesHeinrich\GetID3\GetID3;
use GuzzleHttp\Psr7\Utils;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\CachingStream;
use Aws\Exception\MultipartUploadException;
use Aws\S3\MultipartUploader;
use Aws\S3\ObjectUploader;
use Aws\S3\S3Client;

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
        $categories = Category::active()->get();
        $authors = Author::where('type', '1')->get();

        return view('courses.index', [
            'categories' => $categories,
            'authors' => $authors
        ]);
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
        })->when($request->category, function ($query) use ($user_id, $request) {
            $query->where('category_id', $request->category);
        })->when($request->price, function ($query) use ($user_id, $request) {
            $query->where('p_type', $request->price);
        })->when($request->aproval, function ($query) use ($user_id, $request) {
            $query->where('approved', (int)$request->aproval);
        })->when($request->uncategorized, function ($query) use ($request) {
            if ($request->uncategorized == "true") {
                $query->whereDoesntHave('category');
            }
        })->when($request->author, function ($query) use ($request) {
            $query->where('author_id', $request->author);
        })->count();

        $brands = Course::when($user_id, function ($query) use ($user_id) {
            $query->where('added_by', $user_id);
        })->when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%");
            });
        })->when($request->category, function ($query) use ($user_id, $request) {
            $query->where('category_id', $request->category);
        })->when($request->price, function ($query) use ($user_id, $request) {
            $query->where('p_type', $request->price);
        })->when($request->aproval, function ($query) use ($user_id, $request) {
            $query->where('approved', (int)$request->aproval);
        })->when($request->uncategorized, function ($query) use ($request) {
            if ($request->uncategorized == "true") {
                $query->whereDoesntHave('category');
            }
        })->when($request->author, function ($query) use ($request) {
            $query->where('author_id', $request->author);
        })->orderBy('created_at', 'desc')->with('user', 'category')->skip((int) $start)->take((int) $length)->get();


        $brandsCount = Course::when($user_id, function ($query) use ($user_id) {
            $query->where('added_by', $user_id);
        })->when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%");
            });
        })->when($request->category, function ($query) use ($user_id, $request) {
            $query->where('category_id', $request->category);
        })->when($request->price, function ($query) use ($user_id, $request) {
            $query->where('p_type', $request->price);
        })->when($request->aproval, function ($query) use ($user_id, $request) {
            $query->where('approved', (int)$request->aproval);
        })->when($request->uncategorized, function ($query) use ($request) {
            if ($request->uncategorized == "true") {
                $query->whereDoesntHave('category');
            }
        })->when($request->author, function ($query) use ($request) {
            $query->where('author_id', $request->author);
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
        $categories = Category::active()->get();
        $author = Author::where('type', '1')->get();
        $section = AppSection::where('status', 1)->with('eBook', 'audioBook', 'podcast')->get();
        $languages = Languages::get();

        return view('courses.add', [
            'tags' => $tags,
            'categories' => $categories,
            'author' => $author,
            'section' => $section,
            'languages' => $languages
        ]);
    }
    public function store(Request $request)
    {
        ini_set("memory_limit", "-1");
        ini_set('max_execution_time', '0');
        $client = new  Client('http://localhost:7700', '3bc7ba18215601c4de218ef53f0f90e830a7f144');

        $course = new Course();
        $course->title = $request->title;
        $course->description = $request->description;
        $course->added_by = $this->user->id;
        $course->status = 1;
        $course->approved = 0;
        $course->age = $request->age;
        $course->p_type = $request->pRadio;
        $course->price = $request->price;
        $course->category_id = $request->category_id;
        $course->lang_id = $request->lang_id;
        $course->inside = $request->inside;
        $course->author_id = $request->author_id;
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
        if ($request->section) {
            foreach ($request->section as $key => $sec) {
                $sectionContent = new AppSectionContent();
                $sectionContent->content_id = $course->_id;
                $sectionContent->section_id = $sec;
                $sectionContent->order_no = (int)$request->$sec;
                $sectionContent->content_type = (int)6;
                $sectionContent->save();
            }
        }
        $courseIndex = $client->index('course')->addDocuments(array($course), '_id');
        return redirect()->to('/course/edit/' . $course->_id)->with('msg', 'Course Saved Successfully!');;
    }

    public function edit(Request $request, $id)
    {

        $course = Course::where('_id', $id)->with('lessons', 'trashedCourse')->first();
        $contentTag = ContentTag::where('content_id', $id)->get();
        $categories = Category::active()->get();
        $tags = Tag::all();
        $author = Author::where('type', '1')->get();
        $section = AppSection::where('status', 1)->get();
        $selectedSection = AppSectionContent::where('content_id', $course->id)->get(['section_id', 'order_no']);
        $languages = Languages::get();

        return view('courses.edit', [
            'course' => $course,
            'tags' => $tags,
            'contentTags' =>  $contentTag,
            'categories' => $categories,
            'author' => $author,
            'pending_for_approval' => $request->pending_for_approval,
            'section' => $section,
            'selectedSection' => $selectedSection,
            'languages' => $languages
        ]);
    }

    public function update(Request $request)
    {
        ini_set("memory_limit", "-1");
        ini_set('max_execution_time', '0');
        $course = Course::where('_id', $request->id)->first();
        $course->title = $request->title;
        $course->description = $request->description;
        // $course->added_by = $this->user->id;
        // $course->status = 1;
        $course->age = $request->age;
        $course->category_id = $request->category_id;
        $course->p_type = $request->pRadio;
        $course->price = $request->price;
        $course->inside = $request->inside;
        $course->author_id = $request->author_id;
        $course->lang_id = $request->lang_id;
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
        if ($request->section) {
            AppSectionContent::where('content_id', $course->id)->delete();
            foreach ($request->section as $key => $sec) {
                $sectionContent = new AppSectionContent();
                $sectionContent->content_id = $course->_id;
                $sectionContent->section_id = $sec;
                $sectionContent->order_no = (int)$request->$sec;
                $sectionContent->content_type = (int)6;
                $sectionContent->save();
            }
        } else {
            AppSectionContent::where('content_id', $course->id)->delete();
        }
        if ($request->pending_for_approval == "true") {
            return redirect()->to('/book/pending-for-approval/6')->with('msg', 'Content Saved Successfully!');
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

        ini_set("memory_limit", "-1");
        ini_set('max_execution_time', '0');

        $base_path = 'https://trueilm.s3.eu-north-1.amazonaws.com/';
        if ($request->les_id) {
            $courseLesson = CourseLesson::where('_id', $request->les_id)->first();
        } else {
            $courseLesson = new CourseLesson();
        }

        $courseLesson->title = $request->lesson_title;
        $courseLesson->description = $request->description ?? '';
        $courseLesson->course_id = $request->course_id;
        $courseLesson->added_by = $this->user->id;
        $s3Client = new S3Client([
            'profile' => 'default',
            'region' => env('AWS_DEFAULT_REGION'),
            'version' => '2024-01-01'
        ]);

        // Use multipart upload
        $source = $request->podcast_file;
        $uploader = new MultipartUploader($s3Client, $source, [
            'bucket' => env('AWS_BUCKET'),
            'key' => env('AWS_SECRET_ACCESS_KEY'),
        ]);

        try {
            $result = $uploader->upload();
            echo "Upload complete: {$result['ObjectURL']}\n";
        } catch (MultipartUploadException $e) {
            echo $e->getMessage() . "\n";
        }

        dd('working on it');
        // if ($request->podcast_file) {
        //     // return 'here';
        //     $originalFile = $request->file('podcast_file');
        //     $fileExtension = $originalFile->getClientOriginalExtension();
        //     $fileName = time() . '.' . $fileExtension;

        //     // Define paths
        //     $originalPath = $originalFile->getPathname();
        //     $compressedFilePath = storage_path('app/temp/') . $fileName; // Temporary storage for the compressed file

        //     // Create temporary directory if it doesn't exist
        //     if (!file_exists(storage_path('app/temp'))) {
        //         mkdir(storage_path('app/temp'), 0755, true);
        //     }

        //     // Compress video if it's not an MP3 file
        //     if ($fileExtension != 'mp3') {
        //         // FFmpeg command to compress the video
        //         $ffmpegCommand = "ffmpeg -i $originalPath -vcodec libx264 -crf 28 -preset slow -acodec aac -b:a 128k $compressedFilePath";
        //         exec($ffmpegCommand, $output, $status);

        //         if ($status !== 0) {
        //             return response()->json(['error' => 'Video compression failed.'], 500);
        //         }

        //         // Use the compressed file path for upload
        //         $path = Storage::disk('s3')->putFileAs('uploads', new \Illuminate\Http\File($compressedFilePath), $fileName);
        //     } else {
        //         // Directly use the original file for upload if it's an MP3 file
        //         $path = Storage::disk('s3')->putFileAs('uploads', $originalFile, $fileName);
        //     }

        //     // Set visibility to public
        //     Storage::disk('s3')->setVisibility($path, 'public');

        //     // Store file path and other information in the database
        //     $base_path = 'https://trueilm.s3.eu-north-1.amazonaws.com/'; // Adjust this to your actual base path
        //     $courseLesson->file = $base_path . $path;
        //     $courseLesson->type = $fileExtension == 'mp3' ? 1 : 2;
        //     $courseLesson->book_name = $originalFile->getClientOriginalName();
        //     $courseLesson->save();

        //     // Clean up temporary file
        //     if (file_exists($compressedFilePath)) {
        //         unlink($compressedFilePath);
        //     }

        //     return response()->json(['success' => 'File uploaded successfully.']);
        // } else {
        //     return response()->json(['error' => 'No file uploaded.'], 400);
        // }

        dd('working on it');

        if ($request->lesson_notes) {
            $file_name = time() . '.' . $request->lesson_notes->getClientOriginalExtension();
            $path =   $request->lesson_notes->storeAs('courses_videos', $file_name, 's3');
            Storage::disk('s3')->setVisibility($path, 'public');
            $courseLesson->lesson_notes = $base_path . $path;

            $courseLesson->lesson_notes_name = $request->lesson_notes->getClientOriginalName();
        }
        if ($request->thumbnail) {
            $file_name = time() . '.' . $request->thumbnail->getClientOriginalExtension();
            $path =   $request->thumbnail->storeAs('courses_videos', $file_name, 's3');
            Storage::disk('s3')->setVisibility($path, 'public');
            $courseLesson->thumbnail = $base_path . $path;

            // $courseLesson->thumbnail = $request->thumbnail->getClientOriginalName();
        }
        $courseLesson->sequence = (int) @$request->sequence ?? 0;
        $courseLesson->is_kwl = $request->is_kwl;
        $courseLesson->hls_conversion = @$courseLesson->hls_conversion ?? 0;

        $courseLesson->save();

        $count = CourseLesson::where('course_id', $courseLesson->course_id)->count();

        $course = Course::where('_id',  $courseLesson->course_id)->first();
        $course->lesson_count = $count;
        $course->save();
        if ($course->approved == 1) {
            indexing(6, $course);
        }
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
                $question->sequence = (int) $key;
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
        $question  = Questionaire::where('lesson_id', $id)->with(['allOptions' => function ($q) {
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
                $question->sequence = (int) $key;
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

    public function quizResults($course_id, $lesson_id)
    {
        $attemptResults =  QuizAttempts::where('lesson_id', $lesson_id)->where('is_ended', 1)->get()->groupBy('user');
        $attemptResults2 =  QuizAttempts::where('lesson_id', $lesson_id)->where('is_ended', 1)->get();
        return view('courses.result', [
            'result' =>  $attemptResults,
            'attemptResults2' => $attemptResults2
        ]);
    }
    public function userAttemptsResults($user_id)
    {
        $attemptResults =  QuizAttempts::where('user_id', $user_id)->where('is_ended', 1)->get();
        return view('courses.user_result', [
            'result' =>  $attemptResults,
        ]);
    }

    public function allPendingCourses(Request $request)
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
        $totalBrands = Course::pendingapprove()->when($request->category, function ($query) use ($request) {
            $query->where('category_id', $request->category);
        })->when($request->price, function ($query) use ($request) {
            $query->where('p_type', $request->price);
        })->when($request->aproval, function ($query) use ($request) {
            $query->where('aproved', (int)$request->aproval);
        })->when($request->uncategorized, function ($query) use ($request) {
            if ($request->uncategorized == "true") {
                $query->whereDoesntHave('category');
            }
        })->when($request->author, function ($query) use ($request) {
            $query->where('author_id', $request->author);
        })->when($user_id, function ($query) use ($user_id) {
            // $query->where('added_by', $user_id);
        })->count();
        $brands = Course::pendingapprove()->when($request->category, function ($query) use ($request) {
            $query->where('category_id', $request->category);
        })->when($request->price, function ($query) use ($request) {
            $query->where('p_type', $request->price);
        })->when($request->aproval, function ($query) use ($request) {
            $query->where('aproved', (int)$request->aproval);
        })->when($request->uncategorized, function ($query) use ($request) {
            if ($request->uncategorized == "true") {
                $query->whereDoesntHave('category');
            }
        })->when($request->author, function ($query) use ($request) {
            $query->where('author_id', $request->author);
        })->when($user_id, function ($query) use ($user_id) {
            // $query->where('added_by', $user_id);
        })->when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%");
            });
        })->orderBy('created_at', 'desc')->with('user', 'category')->skip((int) $start)->take((int) $length)->get();
        $brandsCount = Course::pendingapprove()->when($request->category, function ($query) use ($request) {
            $query->where('category_id', $request->category);
        })->when($request->price, function ($query) use ($request) {
            $query->where('p_type', $request->price);
        })->when($request->aproval, function ($query) use ($request) {
            $query->where('aproved', (int)$request->aproval);
        })->when($request->uncategorized, function ($query) use ($request) {
            if ($request->uncategorized == "true") {
                $query->whereDoesntHave('category');
            }
        })->when($request->author, function ($query) use ($request) {
            $query->where('author_id', $request->author);
        })->when($user_id, function ($query) use ($user_id) {
            // $query->where('added_by', $user_id);
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
    public function allRejectedByYouCourses(Request $request)
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
        $totalBrands = Course::rejected()->when($user_id, function ($query) use ($user_id) {
        })->count();
        $brands = Course::rejected()->when($user_id, function ($query) use ($user_id) {
        })->when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%");
            });
        })->orderBy('created_at', 'desc')->with('user', 'approver', 'category')->skip((int) $start)->take((int) $length)->get();
        $brandsCount = Course::rejected()->when($user_id, function ($query) use ($user_id) {
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
    public function allApprovedByYouCourses(Request $request)
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
        $totalBrands = Course::approved()->when($user_id, function ($query) use ($user_id) {
        })->count();
        $brands = Course::approved()->when($user_id, function ($query) use ($user_id) {
        })->when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%");
            });
        })->orderBy('created_at', 'desc')->with('user', 'approver', 'category')->skip((int) $start)->take((int) $length)->get();
        $brandsCount = Course::approved()->when($user_id, function ($query) use ($user_id) {
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

    public function allRejectedCourses(Request $request)
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
        $totalBrands = Course::rejected()->when($user_id, function ($query) use ($user_id) {
            $query->where('added_by', $user_id);
        })->count();
        $brands = Course::rejected()->when($user_id, function ($query) use ($user_id) {
            $query->where('added_by', $user_id);
        })->when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%");
            });
        })->orderBy('created_at', 'desc')->with('user', 'approver', 'category')->skip((int) $start)->take((int) $length)->get();
        $brandsCount = Course::rejected()->when($user_id, function ($query) use ($user_id) {
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

    public function approveCourse($id)
    {
        $course = Course::where('_id', $id)->first();
        $approved = 1;
        if ($course->approved = 0 || $course->approved = 2) {
            $course->update([
                'approved' => $approved,
                'approved_by' => $this->user->id,
                'published_at' => Carbon::now('UTC')->format('Y-m-d\TH:i:s.uP')
            ]);

            // SendNotifications::dispatch($course->added_by, 'A new Course has been uploaded to TrueILM.', 0);
            // SendNotifications::dispatch($course->added_by, 'Your Course Has Been Published Approved.', 1);
        }
        // activity(1, $id, 1);
        indexing(6, $course);

        return redirect()->back()->with('msg', 'Content Approved Successfully!');
    }
    public function rejectCourse(Request $request, $id)
    {
        $course = Course::where('_id', $id)->first();
        $approved = 2;
        if ($course->approved == 0 || $course->approved == 1) {
            $course->update([
                'approved' => $approved,
                'approved_by' => $this->user->id,
                'reason' => $request->reason
            ]);

            // SendNotifications::dispatch($course->added_by, 'Your Course Has Rejected.', 1);
        }

        // activity(2, $id, 1);
        return redirect()->back()->with('msg', 'Content Reject Successfully!');
    }
    public function  courseBulkEpisode(Request $request)
    {

        $course = Course::where('_id', $request->course_id)->first();

        $base_path = 'https://trueilm.s3.eu-north-1.amazonaws.com/';

        if ($request->podcast_file) {
            foreach ($request->podcast_file as $file) {
                $bookContent = new CourseLesson();
                $file_name = time() . '.' . $file->getClientOriginalExtension();
                $path =   $file->storeAs('files', $file_name, 's3');
                Storage::disk('s3')->setVisibility($path, 'public');
                $bookContent->file = $base_path . $path;

                $bookContent->book_name = $file->getClientOriginalName();

                $bookContent->course_id = $course->_id;
                $bookContent->title = \Str::beforelast($bookContent->book_name, '.');

                $getID3 = new \JamesHeinrich\GetID3\GetID3;
                $file = $getID3->analyze(@$file);
                $duration = date('H:i:s', $file['playtime_seconds']);
                list($hours, $minutes, $seconds) = explode(':', $duration);

                // Calculate total duration in minutes
                $total_minutes = $hours * 60 + $minutes;

                // Construct the duration in the format MM:SS
                $duration_minutes_seconds = sprintf("%02d:%02d", $total_minutes, $seconds);
                $bookContent->file_duration = @$duration_minutes_seconds;
                $bookContent->hls_conversion = 0;

                $bookContent->save();
            }
        }

        return redirect()->back()->with('msg', 'Episode Saved !');
    }
    public function updateLessonName(Request $request)
    {
        $boookContent = CourseLesson::where('_id', $request->content_id)->update(['title' => $request->name, 'sequence' => (int)$request->sequence]);

        return 'updated';
    }
    public function deleteLesson($id)
    {
        $bookContent = CourseLesson::where('_id', $id)->delete();

        return redirect()->back()->with('msg', 'Lesson Deleted Successfully!');
    }
    public function UndoDeleteLesson($id)
    {
        $bookContent = CourseLesson::withoutGlobalScope(DeletedAtScope::class)->where('_id', $id)->update([
            'deleted_at' => null
        ]);

        return redirect()->back()->with('msg', 'Lesson Reverted Successfully!');
    }
}
