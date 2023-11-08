<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthorRequest;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AuthorController extends Controller
{
    public $user;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();

            return $next($request);
        });
    }
    public function index(Request $request)
    {
        $type =  $request->input('type');
        return view('author.index', [
            'type' => $type
        ]);
    }
    public function allAuthor(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $search = $request->search['value'];
        $totalBrands = Author::count();
        $brands = Author::when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%");
            });
        })->when($request->type, function ($q) use ($request) {
            $q->where('type', $request->type);
        })->when($request->type, function ($q) use ($request) {
            $q->where('type', $request->type);
        })->skip((int) $start)->take((int) $length)->get();
        $brandsCount = Author::when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%");
            });
        })->when($request->type, function ($q) use ($request) {
            $q->where('type', $request->type);
        })->skip((int) $start)->take((int) $length)->count();
        $data = array(
            'draw' => $draw,
            'recordsTotal' => $totalBrands,
            'recordsFiltered' => $brandsCount,
            'data' => $brands,
        );
        return json_encode($data);
    }
    public function add(Request $request)
    {
        $type =  $request->input('type');
        return view('author.add', [
            'type' => $type
        ]);
    }
    public function store(AuthorRequest $request)
    {
        $author = new Author();
        $author->name = $request->name;
        $author->description = $request->description;
        $author->added_by = $this->user->id;
        $author->type = $request->type;
        $base_path = 'https://trueilm.s3.eu-north-1.amazonaws.com/';
        if ($request->has('image')) {
            $file = $request->file('image');
            $file_name = time() . '.' . $file->getClientOriginalExtension();
            $path =   $request->file('image')->storeAs('author_images', $file_name, 's3');
            Storage::disk('s3')->setVisibility($path, 'public');
            $author->image  = $base_path . $path;
        }
        $author->save();

        return redirect()->to('/authors?type=' . $request->type)->with('msg', 'Author Saved Successfully!');
    }

    public function edit($id)
    {
        $author = Author::where('_id', $id)->first();
        return view('author.edit', [
            'author' => $author
        ]);
    }

    public function update(AuthorRequest $request)
    {
        $author = Author::where('_id', $request->id)->first();
        $author->name = $request->name;
        $author->description = $request->description;
        $author->added_by = $this->user->id;
        $base_path = 'https://trueilm.s3.eu-north-1.amazonaws.com/';
        if ($request->has('image')) {
            $file = $request->file('image');
            $file_name = time() . '.' . $file->getClientOriginalExtension();
            $path =   $request->file('image')->storeAs('author_images', $file_name, 's3');
            Storage::disk('s3')->setVisibility($path, 'public');
            $author->image  = $base_path . $path;
        }
        $author->save();

        return redirect()->to('/author')->with('msg', 'Author Updated Successfully!');
    }
}
