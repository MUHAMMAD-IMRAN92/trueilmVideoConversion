<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
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
        return view('eBook.index');
    }
    public function allPublisher(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $search = $request->search['value'];
        $totalBrands = Book::count();
        $brands = Book::when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%");
            });
        })->skip((int) $start)->take((int) $length)->get();
        $brandsCount = Book::when($search, function ($q) use ($search) {
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
        return view('eBook.add');
    }
    public function store(BookRequest $request)
    {
        $book = new Book();
        $book->title = $request->title;
        $book->description = $request->description;
        if ($request->has('file')) {
            $file = $request->file;
            $file_name = time() . '.' . $file->getClientOriginalExtension();
            $path =   $request->file('idcard_picture')->storeAs('images', $file_name, 's3');
            Storage::disk('s3')->setVisibility($path, 'public');
        }
        $book->added_by = $this->user->id;
        $book->save();

        return redirect()->to('/publisher')->with('msg', 'Publisher Saved Successfully!');;
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
        $publisher = Book::where('_id', $request->id)->first();
        $publisher->name = $request->name;
        $publisher->description = $request->description;
        $publisher->added_by = $this->user->id;
        $publisher->save();

        return redirect()->to('/publisher')->with('msg', 'Publisher Updated Successfully!');;
    }
}
