<?php

namespace App\Http\Controllers;

use App\Http\Requests\AyatRequest;
use App\Models\AlQuran;
use App\Models\AlQuranTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlQuranController extends Controller
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
        return view('Al_Quran.index');
    }
    public function allAyat(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $search = $request->search['value'];
        $totalBrands = AlQuran::count();
        $brands = AlQuran::when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('surah', 'like', "%$search%");
            });
        })->skip((int) $start)->take((int) $length)->get();
        $brandsCount = AlQuran::when($search, function ($q) use ($search) {
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
        return view('Al_Quran.add_surah');
    }
    public function store(AyatRequest $request)
    {
        $alQuran = new AlQuran();
        $alQuran->surah = $request->surah;
        $alQuran->ayat = $request->ayat;
        $alQuran->para_no = $request->para;
        $alQuran->ruku = $request->ruku;
        $alQuran->added_by = 1;
        $alQuran->save();
        if ($request->translations) {
            foreach ($request->langs as $key => $lang) {
                $alQuranTranslation = new AlQuranTranslation();
                $alQuranTranslation->lang = $lang;
                $alQuranTranslation->translation = $request->translations[$key];
                $alQuranTranslation->ayat_id = $alQuran->id;
                $alQuranTranslation->added_by = 1;
                $alQuranTranslation->save();
            }
        }

        return redirect()->to('/al-Quran');
    }

    public function edit($id)
    {
        return 'In Progress!';
    }
}
