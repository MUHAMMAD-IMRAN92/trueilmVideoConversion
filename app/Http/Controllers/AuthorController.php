<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthorRequest;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;

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
        if($request->input('type') == null){
            if(!Gate::allows('hasPermission', 'translations-author-view')) {
                abort(403, 'Unauthorized action.');
            }
        }else{
            if(!Gate::allows('hasPermission', 'author-view')) {
                abort(403, 'Unauthorized action.');
            }

        }
        $type =  $request->input('type');
        return view('author.index', [
            'type' => $type
        ]);
    }
    public function allAuthor(Request $request)
    {
        $action=false;
        if($request->type == null){
            if(!Gate::allows('hasPermission', 'translations-author-view')) {
                abort(403, 'Unauthorized action.');
            }

            $action=Gate::allows('hasPermission', 'translations-author-view');
        }
        else{
            if(!Gate::allows('hasPermission', 'author-view')) {
                abort(403, 'Unauthorized action.');
            }
            $action=Gate::allows('hasPermission', 'translations-author-view');

        }
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

        $new_brand=[];
        foreach( $brands as  $brands){
            $new_brand[]=[
                "added_by"      =>  $brands->added_by ,
                "created_at"    =>  $brands->created_at,
                "updated_at"    =>  $brands->updated_at,
                "description"   =>  $brands->description,
                "name"          =>  $brands->name,
                "type"          =>  $brands->type,
                "_id"           =>  $brands->_id,
                "action"        =>  $action
            ];

        }
        $data = array(
            'draw' => $draw,
            'recordsTotal' => $totalBrands,
            'recordsFiltered' => $brandsCount,
            'data' => $new_brand,
           
        );
        return json_encode($data);
    }
    public function add(Request $request)
    {

        if($request->input('type') == null){
            if(!Gate::allows('hasPermission', 'translations-author-create')) {
                abort(403, 'Unauthorized action.');
            }
        }
        else{
            if(!Gate::allows('hasPermission', 'author-create')) {
                abort(403, 'Unauthorized action.');
            }

        }

        
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

        

        if($author->type  == null){
            if(!Gate::allows('hasPermission', 'translations-author-edit')) {
                abort(403, 'Unauthorized action.');
            }
        }
        else{
            if(!Gate::allows('hasPermission', 'author-edit')) {
                abort(403, 'Unauthorized action.');
            }

        }
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
