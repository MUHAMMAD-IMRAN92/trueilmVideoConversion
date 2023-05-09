<?php

namespace App\Http\Controllers;

use App\Http\Requests\AyatRequest;
use App\Models\AlQuran;
use App\Models\AlQuranTranslation;
use App\Models\Surah;
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

    public function add($surahId)
    {
        $surah = Surah::where('_id', $surahId)->with('ayats')->first();
        return view('Al_Quran.add_ayat', [
            'surah' => $surah
        ]);
    }
    public function store(Request $request)
    {
        $alQuran = new AlQuran();
        $alQuran->surah_id = $request->surah_id;
        $alQuran->ayat = $request->ayat;
        $alQuran->para_no = $request->para;
        $alQuran->added_by = $this->user->id;
        $alQuran->save();
        if ($request->translations) {
            foreach ($request->langs as $key => $lang) {
                $alQuranTranslation = new AlQuranTranslation();
                $alQuranTranslation->lang = $lang;
                $alQuranTranslation->translation = $request->translations[$key];
                $alQuranTranslation->ayat_id = $alQuran->id;
                $alQuranTranslation->added_by = $this->user->id;
                $alQuranTranslation->save();
            }
        }

        return redirect()->to('al-Quran')->with('msg', 'Ayat Saved Successfully!');
    }

    public function edit($surahId, $ayatId)
    {
        $surah = Surah::where('_id', $surahId)->with('ayats')->first();
        $ayat = AlQuran::where('_id', $ayatId)->with('translations')->first();
        return view('Al_Quran.edit_ayat', [
            'surah' => $surah,
            'ayat' => $ayat
        ]);
    }

    public function update(Request $request)
    {

        $alQuran = AlQuran::where('_id', $request->ayat_id)->first();

        $alQuran->surah_id = $request->surah_id;
        $alQuran->ayat = $request->ayat;
        $alQuran->para_no = $request->para;
        $alQuran->added_by = $this->user->id;
        $alQuran->save();

        $alQuranTranslation = AlQuranTranslation::where('ayat_id', $request->ayat_id)->delete();
        if ($request->translations) {
            foreach ($request->langs as $key => $lang) {
                $alQuranTranslation = new AlQuranTranslation();
                $alQuranTranslation->lang = $lang;
                $alQuranTranslation->translation = $request->translations[$key];
                $alQuranTranslation->ayat_id = $alQuran->id;
                $alQuranTranslation->added_by = $this->user->id;
                $alQuranTranslation->save();
            }
        }
        return redirect()->back()->with('msg', 'Ayat Updated Successfully!');;
    }
}
