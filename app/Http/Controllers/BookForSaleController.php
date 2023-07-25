<?php

namespace App\Http\Controllers;

use App\Models\BookForSale;
use App\Models\BookForSaleInventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class BookForSaleController extends Controller
{
    public $user;
    public $type;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();

            return $next($request);
        });
    }
    public function index()
    {
        return view('book_for_sale.index');
    }
    public function allBookForSale(Request $request)
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
        $totalBrands = BookForSale::when($user_id, function ($query) use ($user_id) {
            $query->where('added_by', $user_id);
        })->count();
        $brands = BookForSale::when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%");
            });
        })->when($user_id, function ($query) use ($user_id) {
            $query->where('added_by', $user_id);
        })->skip((int) $start)->take((int) $length)->get();
        $brandsCount = BookForSale::when($search, function ($q) use ($search) {
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
    public function add()
    {
        $categories = Category::active()->get();
        return view('book_for_sale.add', [

            'categories' => $categories,
        ]);
    }
    public function store(Request $request)
    {
        // return $request->all();
        $validated = $request->validate([
            'title' => 'required',
            'price*' => 'required|',
        ]);

        $book = new BookForSale();
        $book->title = $request->title;
        $book->description = $request->description;
        $base_path = 'https://trueilm.s3.eu-north-1.amazonaws.com/';

        if ($request->has('cover')) {
            $file = $request->file('cover');
            $file_name = time() . '.' . $file->getClientOriginalExtension();
            $path =   $request->file('cover')->storeAs('files_covers', $file_name, 's3');
            Storage::disk('s3')->setVisibility($path, 'public');
            $book->image = $base_path . $path;
        }
        $book->added_by = $this->user->id;
        $book->category_id = $request->category;
        $book->author = $request->author;
        $book->serial_no = $request->sr_no;
        $book->price = $request->price;
        $book->save();

        $bookForSale =new BookForSaleInventory();
        $bookForSale->book_id   =    $book->_id;
        $bookForSale->quantity   =    $request->quantity;
        $bookForSale->added_by = $this->user->id;
        $bookForSale->status = 1;
        $bookForSale->save();

        return redirect()->to('books_for_sale/' . $request->type)->with('msg', 'Book Saved Successfully!');
    }

    public function edit($id)
    {
        $categories = Category::active()->get();
        $book = BookForSale::where('_id', $id)->with('inventory')->first();


        return view('book_for_sale.edit', [
            'book' => $book,
            'categories' => $categories,

        ]);
    }

    public function update(Request $request)
    {
        $book = BookForSale::where('_id', $request->id)->first();
        $book->title = $request->title;
        $book->description = $request->description;
        $base_path = 'https://trueilm.s3.eu-north-1.amazonaws.com/';

        if ($request->has('cover')) {
            $file = $request->file('cover');
            $file_name = time() . '.' . $file->getClientOriginalExtension();
            $path =   $request->file('cover')->storeAs('files_covers', $file_name, 's3');
            Storage::disk('s3')->setVisibility($path, 'public');
            $book->image = $base_path . $path;
        }
        $book->added_by = $this->user->id;
        $book->category_id = $request->category;
        $book->author = $request->author;
        $book->serial_no = $request->sr_no;
        $book->price = $request->price;

        $book->save();
        $updateStatus=  BookForSaleInventory::where('book_id' , $book->_id)->where('status' , 1)->update([
            'status'=>0
        ]);
        $bookForSale =new BookForSaleInventory();
        $bookForSale->book_id   =    $book->_id;
        $bookForSale->quantity   =    $request->quantity;
        $bookForSale->added_by = $this->user->id;
        $bookForSale->status = 1;
        $bookForSale->save();


        return redirect()->to('books_for_sale/' . $request->type)->with('msg', 'Book Updated Successfully!');
    }
}
