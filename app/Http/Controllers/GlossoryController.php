<?php

namespace App\Http\Controllers;

use App\Models\Glossory;
use App\Models\GlossoryAttribute;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class GlossoryController extends Controller
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
        return view('glossary.index');
    }
    public function allglossory(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $search = $request->search['value'];
        $totalBrands = Glossory::count();
        $brands = Glossory::when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%");
            });
        })->orderBy('created_at' , 'desc')->skip((int) $start)->take((int) $length)->get();
        $brandsCount = Glossory::when($search, function ($q) use ($search) {
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
        return view('glossary.add');
    }
    public function store(Request $request)
    {
        $glossory = new Glossory();
        $glossory->title = $request->title;
        $glossory->save();

        $attributes = ['Translation' => 1, 'Litteral_Meaning' => 2, 'Usage' => 3];
        $type = 0;
        foreach ($attributes as $key => $attr) {
            if ($key == 'Translation') {
                $type = 1;
                $lang = "646db549a4707e6f4d3e61a5";
                $attr = $request->translation;
            } else if ($key == 'Litteral_Meaning') {
                $type = 2;
                $lang = "646db548a4707e6f4d3e61a3";
                $attr = $request->meaning;
            } else {
                $type = 3;
                $lang = "646db548a4707e6f4d3e61a3";
                $attr = $request->usage;
            }
            $glossoryAttribute = new GlossoryAttribute();
            $glossoryAttribute->glossory_id =  $glossory->_id;
            $glossoryAttribute->type =  $type;
            $glossoryAttribute->language_id =  $lang;
            $glossoryAttribute->attribute =  $attr;
            $glossoryAttribute->save();
        }

        return redirect()->to('/glossary')->with('msg', 'Glossory Saved Successfully!');;
    }

    public function edit($id)
    {
        $glossary = Glossory::where('_id', $id)->with('attributes')->first();

        return view('glossary.edit', [
            'glossary' => $glossary,

        ]);
    }

    public function update(Request $request)
    {
        $glossory = Glossory::where('_id', $request->id)->first();
        $glossory->title = $request->title;
        $glossory->save();
        GlossoryAttribute::where('glossory_id', $request->id)->delete();
        $attributes = ['Translation' => 1, 'Litteral_Meaning' => 2, 'Usage' => 3];
        $type = 0;
        foreach ($attributes as $key => $attr) {
            if ($key == 'Translation') {
                $type = 1;
                $lang = "646db549a4707e6f4d3e61a5";
                $attr = $request->translation;
            } else if ($key == 'Litteral_Meaning') {
                $type = 2;
                $lang = "646db548a4707e6f4d3e61a3";
                $attr = $request->meaning;
            } else {
                $type = 3;
                $lang = "646db548a4707e6f4d3e61a3";
                $attr = $request->usage;
            }
            $glossoryAttribute = new GlossoryAttribute();
            $glossoryAttribute->glossory_id =  $glossory->_id;
            $glossoryAttribute->type =  $type;
            $glossoryAttribute->language_id =  $lang;
            $glossoryAttribute->attribute =  $attr;
            $glossoryAttribute->save();
        }

        return redirect()->to('/glossary')->with('msg', 'Glossory Saved Successfully!');;
    }
}
