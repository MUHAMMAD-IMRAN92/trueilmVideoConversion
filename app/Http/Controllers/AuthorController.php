<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthorRequest;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


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
    public function index()
    {
        return view('author.index');
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
        })->skip((int) $start)->take((int) $length)->get();
        $brandsCount = Author::when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%");
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
        return view('author.add');
    }
    public function store(AuthorRequest $request)
    {
        $author = new Author();
        $author->name = $request->name;
        $author->description = $request->description;
        $author->added_by = $this->user->id;
        $author->save();

        return redirect()->to('/author')->with('msg', 'Author Saved Successfully!');
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
        $author->save();

        return redirect()->to('/author')->with('msg', 'Author Updated Successfully!');
    }
}
