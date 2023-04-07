<?php

namespace App\Http\Controllers;

use App\Http\Requests\HadeesRequest;
use App\Models\Hadees;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HadeesController extends Controller
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
        return view('hadees.index');
    }
    public function allPublisher(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $search = $request->search['value'];
        $totalBrands = Hadees::count();
        $brands = Hadees::when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%");
            });
        })->skip((int) $start)->take((int) $length)->get();
        $brandsCount = Hadees::when($search, function ($q) use ($search) {
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
        return view('publisher.add');
    }
    public function store(HadeesRequest $request)
    {
        $publisher = new Hadees();
        $publisher->name = $request->name;
        $publisher->description = $request->description;
        $publisher->added_by = $this->user->id;
        $publisher->save();

        return redirect()->to('/publisher')->with('msg', 'Publisher Saved Successfully!');;
    }

    public function edit($id)
    {
        $publisher = Hadees::where('_id', $id)->first();
        return view('publisher.edit', [
            'publisher' => $publisher
        ]);
    }

    public function update(HadeesRequest $request)
    {
        $publisher = Hadees::where('_id', $request->id)->first();
        $publisher->name = $request->name;
        $publisher->description = $request->description;
        $publisher->added_by = $this->user->id;
        $publisher->save();

        return redirect()->to('/publisher')->with('msg', 'Publisher Updated Successfully!');;
    }
}
