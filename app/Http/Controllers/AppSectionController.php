<?php

namespace App\Http\Controllers;

use App\Models\AppSection;
use App\Models\AppSectionContent;
use App\Models\Book;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppSectionController extends Controller
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
        $section = AppSection::with('user', 'eBook', 'audioBook', 'podcast', 'course')->orderBy('created_at', 'desc')->get();
        return view('app_section.index', [
            'section' => $section
        ]);
    }
    public function allSection(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $search = $request->search['value'];
        $totalBrands = AppSection::count();
        $brands = AppSection::when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%");
            });
        })->with('user', 'eBook', 'audioBook', 'podcast', 'course')->orderBy('created_at', 'desc')->skip((int) $start)->take((int) $length)->get();
        $brandsCount = AppSection::when($search, function ($q) use ($search) {
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
        return view('app_section.add');
    }
    public function store(Request $request)
    {
        $section = new AppSection();
        $section->title = $request->title;
        $section->sub_title = $request->sub_title;
        $section->added_by = $this->user->id;
        $section->status = 1;
        $section->sequence = $request->sequence ?? 0;
        $section->save();

        return redirect()->to('/app-section')->with('msg', 'Section Saved Successfully!');
    }

    public function edit($id)
    {
        $section = AppSection::where('_id', $id)->with('course.course', 'ebook.books', 'audioBook.books', 'podcast.books')->first();
        $booksectionContent = AppSectionContent::where('section_id', $section->_id)->whereIn('content_type', [1, 2, 3, 7])->get()->pluck('content_id');
        $books = Book::wherein('_id', $booksectionContent)->with('author', 'user', 'approver', 'category')->get();
        $coursesectionContent = AppSectionContent::where('section_id', $section->_id)->whereIn('content_type', [6])->get()->pluck('content_id');

        $course = Course::wherein('_id', $coursesectionContent)->get();
        return view('app_section.edit', [
            'section' => $section,
            'course' => $course,
            'books' => $books
        ]);
    }

    public function update(Request $request)
    {
        $section = AppSection::where('_id', $request->id)->first();
        $section->title = $request->title;
        $section->sub_title = $request->sub_title;
        $section->added_by = $this->user->id;
        $section->status = $section->status;
        $section->save();

        return redirect()->to('/app-section')->with('msg', 'Section Updated Successfully!');;
    }
    public function updateSectionStatus($id)
    {
        $book = AppSection::where('_id', $id)->first();
        $status = $book->status == 1 ? 0 : 1;

        $book->update([
            'status' => $status
        ]);

        return redirect()->to('/app-section')->with('msg', 'Section Status Updated Successfully!');
    }
}
