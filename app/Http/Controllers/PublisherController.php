<?php

namespace App\Http\Controllers;

use App\Http\Requests\PublisherRequest;
use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PublisherController extends Controller
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

        return view('publisher.index');
    }
    public function allPublisher(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $search = $request->search['value'];
        $totalBrands = Publisher::count();
        $brands = Publisher::when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%");
            });
        })->skip((int) $start)->take((int) $length)->get();
        $brandsCount = Publisher::when($search, function ($q) use ($search) {
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
    public function store(PublisherRequest $request)
    {
        $publisher = new Publisher();
        $publisher->name = $request->name;
        $publisher->description = $request->description;
        $publisher->added_by = $this->user->id;
        $publisher->save();

        return redirect()->to('/publisher')->with('msg', 'Publisher Saved Successfully!');;
    }

    public function edit($id)
    {
        $publisher = Publisher::where('_id', $id)->first();
        return view('publisher.edit', [
            'publisher' => $publisher
        ]);
    }

    public function update(PublisherRequest $request)
    {
        $publisher = Publisher::where('_id', $request->id)->first();
        $publisher->name = $request->name;
        $publisher->description = $request->description;
        $publisher->added_by = $this->user->id;
        $publisher->save();

        return redirect()->to('/publisher')->with('msg', 'Publisher Updated Successfully!');;
    }
}
