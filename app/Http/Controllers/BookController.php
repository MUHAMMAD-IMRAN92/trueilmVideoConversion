<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;

class BookController extends Controller
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
        return view('eBook.index');
    }
    public function allPublisher(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $search = $request->search['value'];
        $totalBrands = Book::where('type', $this->type)->count();
        $brands = Book::where('type', $this->type)->when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%");
            });
        })->skip((int) $start)->take((int) $length)->get();
        $brandsCount = Book::where('type', $this->type)->when($search, function ($q) use ($search) {
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
        $categories = Category::where('type', $this->type)->get();
        return view('eBook.add', [
            'type' => $this->type,
            'categories' => $categories
        ]);
    }
    public function store(Request $request)
    {
        $book = new Book();
        $book->title = $request->title;
        $book->description = $request->description;
        $base_path = url('storage/app/public/');
        if ($request->has('file')) {
            $file = $request->file('file');
            $file_name = time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('files', $file_name, 'public');
            $book->file = $base_path . $path;
        }
        if ($request->has('cover')) {
            $file = $request->file('cover');
            $file_name = time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('files_covers', $file_name, 'public');
            $book->cover = $base_path . $path;
        }
        $book->added_by = $this->user->id;
        $book->category_id = $request->category;
        $book->type = $this->type;
        $book->save();

        return redirect()->to('books/' . $this->type)->with('msg', 'Content Saved Successfully!');;
    }

    public function edit($id)
    {
        $publisher = Book::where('_id', $id)->first();
        return view('publisher.edit', [
            'publisher' => $publisher
        ]);
    }

    public function update(BookRequest $request)
    {
        $book = Book::where('_id', $request->id)->first();
        $book->name = $request->name;
        $book->description = $request->description;
        $book->added_by = $this->user->id;
        $book->type = $book->type;
        $book->save();

        return redirect()->to('books/' .  $this->type)->with('msg', 'Content Updated Successfully!');;
    }
}
