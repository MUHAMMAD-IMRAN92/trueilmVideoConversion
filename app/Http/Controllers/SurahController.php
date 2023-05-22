<?php

namespace App\Http\Controllers;

use App\Models\AlQuran;
use App\Models\Surah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SurahController extends Controller
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
        return view('surah.index');
    }
    public function allSurah(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $search = $request->search['value'];
        $totalBrands = Surah::count();
        $brands = Surah::when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('surah', 'like', "%$search%");
            });
        })->skip((int) $start)->take((int) $length)->get();
        $brandsCount = Surah::when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('surah', 'like', "%$search%");
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
        return view('surah.add_ayat');
    }
    public function store(Request $request)
    {
        $alQuran = new Surah();
        $alQuran->surah = $request->surah;
        $alQuran->description = $request->description;
        $alQuran->type = $request->type;
        $alQuran->added_by = $this->user->id;

        $alQuran->save();


        return redirect()->to('/al-Quran')->with('msg', 'Surah Saved Successfully!');
    }

    public function edit($surahId, $ayatId = null)
    {
        $surah = Surah::where('_id', $surahId)->with('ayats')->first();
        $ayat = AlQuran::where('surah_id', $surahId)->where('id', $ayatId)->with('translations')->first();
        return view('surah.edit_ayat', [
            'surah' => $surah,
            'ayat' => $ayat
        ]);
    }

    public function update(Request $request)
    {
        $alQuran = Surah::where('_id', $request->id)->first();


        $alQuran->surah = $request->surah;
        $alQuran->description = $request->description;
        $alQuran->type = $request->type;
        $alQuran->added_by = $this->user->id;

        $alQuran->save();

        return redirect()->to('/al-Quran')->with('msg', 'Ayat Updated Successfully!');;
    }
}
