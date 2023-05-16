<?php

namespace App\Http\Controllers;

use App\Http\Requests\AyatRequest;
use App\Models\AlQuran;
use App\Models\AlQuranTranslation;
use App\Models\Surah;
use App\Models\Tafseer;
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


        $alQuran = Surah::where('_id', $request->surah_id)->first();


        $alQuran->surah = $request->surah;
        $alQuran->ayat = $request->ayat;
        $alQuran->para_no = $request->para;
        $alQuran->ruku = $request->ruku;
        $alQuran->added_by = $this->user->id;

        $alQuran->save();

        $alQuran = new AlQuran();
        $alQuran->surah_id = $request->surah_id;
        $alQuran->ayat = $request->ayat;
        $alQuran->para_no = $request->para;
        $alQuran->added_by = $this->user->id;
        $alQuran->manzil = $request->manzil;
        $alQuran->ruku = $request->ruku;
        $alQuran->sequence = $request->sequence;
        $alQuran->sajda = $request->sajda;
        $alQuran->waqf = $request->waqf;
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
        if ($request->tafseers) {
            foreach ($request->taf_langs as $key => $lang) {
                $tafseer = new Tafseer();
                $tafseer->lang = $lang;
                $tafseer->tafseer = $request->tafseers[$key];
                $tafseer->ayat_id = $alQuran->id;
                $tafseer->added_by = $this->user->id;
                $tafseer->save();
            }
        }
        return redirect()->to('/ayat/edit/' . $request->surah_id . '/' . $alQuran->id)->with('msg', 'Ayat Saved Successfully!');
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
        $alQuran = Surah::where('_id', $request->surah_id)->first();

        $alQuran->surah = $request->surah;
        $alQuran->ayat = $request->ayat;
        $alQuran->para_no = $request->para;
        $alQuran->ruku = $request->ruku;
        $alQuran->added_by = $this->user->id;

        $alQuran->save();

        $alQuran = AlQuran::where('_id', $request->ayat_id)->first();

        $alQuran->surah_id = $request->surah_id;
        $alQuran->ayat = $request->ayat;
        $alQuran->para_no = $request->para;
        $alQuran->added_by = $this->user->id;
        $alQuran->manzil = $request->manzil;
        $alQuran->ruku = $request->ruku;
        $alQuran->sequence = $request->sequence;
        $alQuran->sajda = $request->sajda;
        $alQuran->waqf = $request->waqf;
        $alQuran->save();

        $alQuranTranslation = AlQuranTranslation::where('ayat_id', $request->ayat_id)->delete();
        $alQuranTranslation = Tafseer::where('ayat_id', $request->ayat_id)->delete();
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
        if ($request->tafseers) {
            foreach ($request->taf_langs as $key => $lang) {
                $tafseer = new Tafseer();
                $tafseer->lang = $lang;
                $tafseer->tafseer = $request->tafseers[$key];
                $tafseer->ayat_id = $alQuran->id;
                $tafseer->added_by = $this->user->id;
                $tafseer->save();
            }
        }
        return redirect()->to('/ayat/edit/' . $request->surah_id . '/' . $alQuran->id)->with('msg', 'Ayat Updated Successfully!');;
    }
    public function deleteTranslation(Request $request)
    {
        $alQuranTranslation = AlQuranTranslation::where('_id', $request->transId)->delete();
        return sendSuccess('Deleted!', []);
    }

    public function updateTranslation(Request $request)
    {
        $alQuranTranslation = AlQuranTranslation::where('_id', $request->transId)->first();
        $alQuranTranslation->lang = $request->lang;
        $alQuranTranslation->translation = $request->translation;
        $alQuranTranslation->ayat_id = $request->ayatId;
        $alQuranTranslation->added_by = $this->user->id;
        $alQuranTranslation->save();

        return $alQuranTranslation;
    }
}
