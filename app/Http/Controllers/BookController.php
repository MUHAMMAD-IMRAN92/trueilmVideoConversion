<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Models\Book;
use App\Models\BookContent;
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
        return view('eBook.index', [
            'type' => $type
        ]);
    }
    public function allBooks(Request $request)
    {
        $user_id = auth()->user()->id;
        if (auth()->user()->hasRole('Admin')) {
            $user_id = '';
        } else {
            $user_id = auth()->user()->id;
        }
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $search = $request->search['value'];
        $totalBrands = Book::where('type', Session::get('type'))->when($user_id, function ($query) use ($user_id) {
            $query->where('added_by', $user_id);
        })->count();
        $brands = Book::where('type', Session::get('type'))->when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%");
            });
        })->when($user_id, function ($query) use ($user_id) {
            $query->where('added_by', $user_id);
        })->skip((int) $start)->take((int) $length)->get();
        $brandsCount = Book::where('type', Session::get('type'))->when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%");
            });
        })->when($user_id, function ($query) use ($user_id) {
            $query->where('added_by', $user_id);
        })->skip((int) $start)->take((int) $length)->count();
        $data = array(
            'draw' => $draw,
            'recordsTotal' => $totalBrands,
            'recordsFiltered' => $brandsCount,
            'data' => $brands,
        );
        return json_encode($data);
    }
    public function add($type)
    {
        $categories = Category::active()->where('type', $type)->get();
        return view('eBook.add', [
            'type' => $type,
            'categories' => $categories
        ]);
    }
    public function store(Request $request)
    {
        if (Session::get('type') == 1) {
            $validated = $request->validate([
                'title' => 'required',
                'file' => 'required|file|mimes:epub',
            ]);
        } elseif (Session::get('type') == 2) {
            $validated = $request->validate([
                'title' => 'required',
                'file' => 'required|file|mimes:mp3',
            ]);
        } elseif (Session::get('type') == 3) {
            $validated = $request->validate([
                'title' => 'required',
                'file' => 'required|file|mimes:epub,pdf',
            ]);
        }
        $book = new Book();
        $book->title = $request->title;
        $book->description = $request->description;
        $base_path = 'https://trueilm.s3.eu-north-1.amazonaws.com/';
        if ($request->has('file')) {
            $file = $request->file('file');
            $file_name = time() . '.' . $file->getClientOriginalExtension();
            $path =   $request->file('file')->storeAs('files', $file_name, 's3');
            Storage::disk('s3')->setVisibility($path, 'public');
            $book->file = $base_path . $path;
        }
        if ($request->has('cover')) {
            $file = $request->file('cover');
            $file_name = time() . '.' . $file->getClientOriginalExtension();
            $path =   $request->file('cover')->storeAs('files_covers', $file_name, 's3');
            Storage::disk('s3')->setVisibility($path, 'public');
            $book->image = $base_path . $path;
        }
        $book->added_by = $this->user->id;
        $book->category_id = $request->category;
        $book->type = $request->type;
        $book->status = 1;
        $book->approved = 0;
        $book->author = $request->author;
        $book->save();

        // $bookContent = new BookContent();
        // if ($request->has('file')) {
        //     $file = $request->file('file');
        //     $file_name = time() . '.' . $file->getClientOriginalExtension();
        //     $path =   $request->file('file')->storeAs('files', $file_name, 's3');
        //     Storage::disk('s3')->setVisibility($path, 'public');
        //     $book->file = $base_path . $path;
        // }

        return redirect()->to('books/' . $request->type)->with('msg', 'Content Saved Successfully!');
    }

    public function edit($type, $id)
    {
        $categories = Category::active()->where('type', Session::get('type'))->get();
        $book = Book::where('_id', $id)->first();
        return view('eBook.edit', [
            'book' => $book,
            'type' => $type,
            'categories' => $categories
        ]);
    }

    public function update(Request $request)
    {
        $book = Book::where('_id', $request->id)->first();
        $book->title = $request->title;
        $book->description = $request->description;
        $base_path = 'https://trueilm.s3.eu-north-1.amazonaws.com/';
        if ($request->has('file')) {
            $file = $request->file('file');
            $file_name = time() . '.' . $file->getClientOriginalExtension();
            $path =   $request->file('file')->storeAs('files', $file_name, 's3');
            Storage::disk('s3')->setVisibility($path, 'public');
            $book->file =  $base_path . $path;
        }
        if ($request->has('cover')) {
            $file = $request->file('cover');
            $file_name = time() . '.' . $file->getClientOriginalExtension();
            $path =   $request->file('cover')->storeAs('files_covers', $file_name, 's3');
            Storage::disk('s3')->setVisibility($path, 'public');
            $book->image = $base_path . $path;
        }

        $book->added_by = $this->user->id;
        $book->category_id = $request->category;
        $book->type = $request->type;
        $book->status =  $book->status;
        $book->approved =  $book->approved;
        $book->author = $request->author;
        $book->save();

        return redirect()->to('books/' .  $request->type)->with('msg', 'Content Updated Successfully!');
    }
    public function updateStatus($id)
    {
        $book = Book::where('_id', $id)->first();
        $status = $book->status == 1 ? 0 : 1;

        $book->update([
            'status' => $status
        ]);

        return redirect()->back();
    }
    public function pendingForApprove()
    {
        return view('eBook.pending_index', [
            'type' => Session::get('type')
        ]);
    }
    public function allPendingForApprovalBooks(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $search = $request->search['value'];
        $totalBrands = Book::pendingApprove()->count();
        $brands = Book::pendingApprove()->when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%");
            });
        })->skip((int) $start)->take((int) $length)->get();
        $brandsCount = Book::pendingApprove()->when($search, function ($q) use ($search) {
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
    public function approveBook($id)
    {
        $book = Book::where('_id', $id)->first();
        $approved = 1;

        $book->update([
            'approved' => $approved
        ]);

        return redirect()->back()->with('msg', 'Content Approved Successfully!');
    }

    public function rejectBook($id)
    {
        $book = Book::where('_id', $id)->first();
        $approved = 2;

        $book->update([
            'approved' => $approved
        ]);

        return redirect()->back()->with('msg', 'Content Reject Successfully!');
    }
}
