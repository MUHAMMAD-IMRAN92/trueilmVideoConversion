<?php

namespace App\Http\Controllers;

use App\Http\Requests\HadeesRequest;
use App\Models\Hadees;
use App\Models\HadeesReference;
use App\Models\HadeesTranslation;
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
    public function allHadith(Request $request)
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
        return view('hadees.add');
    }
    public function store(HadeesRequest $request)
    {
        $hadees = new Hadees();
        $hadees->hadees = $request->hadith;
        $hadees->type = $request->type;
        $hadees->added_by = $this->user->id;
        $hadees->save();

        if ($request->translations) {
            foreach ($request->langs as $key => $lang) {
                $hadeesTranslation = new HadeesTranslation();
                $hadeesTranslation->lang = $lang;
                $hadeesTranslation->translation = $request->translations[$key];
                $hadeesTranslation->hadees_id = $hadees->id;
                $hadeesTranslation->added_by = $this->user->id;
                $hadeesTranslation->save();
            }
        }
        if ($request->ref_number) {
            foreach ($request->reference_book as $key => $book) {
                $hadeesReference = new HadeesReference();
                $hadeesReference->reference_book = $book;
                $hadeesReference->reference_number = $request->ref_number[$key];
                $hadeesReference->hadees_id = $hadees->id;
                $hadeesReference->added_by = $this->user->id;
                $hadeesReference->save();
            }
        }

        return redirect()->to('/hadith')->with('msg', 'Hadith Saved Successfully!');;
    }

    public function edit($id)
    {
        $hadees = Hadees::where('_id', $id)->with('translations', 'references')->first();
        return view('hadees.edit', [
            'hadees' => $hadees
        ]);
    }

    public function update(HadeesRequest $request)
    {
        $hadees = Hadees::where('_id', $request->id)->first();
        $hadees->hadees = $request->hadith;
        $hadees->type = $request->type;
        $hadees->added_by = $this->user->id;
        $hadees->save();

        HadeesTranslation::where('hadees_id', $request->id)->delete();
        HadeesReference::where('hadees_id', $request->id)->delete();


        if ($request->translations) {
            foreach ($request->langs as $key => $lang) {
                $hadeesTranslation = new HadeesTranslation();
                $hadeesTranslation->lang = $lang;
                $hadeesTranslation->translation = $request->translations[$key];
                $hadeesTranslation->hadees_id = $hadees->id;
                $hadeesTranslation->added_by = $this->user->id;
                $hadeesTranslation->save();
            }
        }
        if ($request->ref_number) {
            foreach ($request->reference_book as $key => $book) {
                $hadeesReference = new HadeesReference();
                $hadeesReference->reference_book = $book;
                $hadeesReference->reference_number = $request->ref_number[$key];
                $hadeesReference->hadees_id = $hadees->id;
                $hadeesReference->added_by = $this->user->id;
                $hadeesReference->save();
            }
        }
        return redirect()->to('/hadith')->with('msg', 'Hadith Updated Successfully!');;
    }
}
