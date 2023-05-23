<?php

namespace App\Http\Controllers;

use App\Models\Juz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JuzController extends Controller
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
        return view('juz.index');
    }
    public function allJuz(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $search = $request->search['value'];
        $totaljuzs = Juz::count();
        $juz = Juz::when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('juz', 'like', "%$search%");
            });
        })->skip((int) $start)->take((int) $length)->get();
        $juzsCount = Juz::when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('juz', 'like', "%$search%");
            });
        })->skip((int) $start)->take((int) $length)->count();
        $data = array(
            'draw' => $draw,
            'recordsTotal' => $totaljuzs,
            'recordsFiltered' => $juzsCount,
            'data' => $juz,
        );
        return json_encode($data);
    }
    public function add()
    {
        return view('juz.add');
    }
    public function store(Request $request)
    {
        $juz = new Juz();
        $juz->juz = $request->juz;
        $juz->description = $request->description;
        $juz->added_by = $this->user->id;
        $juz->save();
        return redirect()->to('/juz')->with('msg', 'Juz Saved Successfully!');;
    }

    public function edit($id)
    {
        $juz = Juz::where('_id', $id)->first();
        return view('juz.edit', [
            'juz' => $juz
        ]);
    }

    public function update(Request $request)
    {
        $juz = Juz::where('_id', $request->id)->first();
        $juz->juz = $request->juz;
        $juz->description = $request->description;
        $juz->added_by = $this->user->id;
        $juz->save();

        return redirect()->to('/juz')->with('msg', 'Juz Saved Successfully!');;
    }
}
