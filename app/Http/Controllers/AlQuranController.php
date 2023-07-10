<?php

namespace App\Http\Controllers;

use App\Http\Requests\AyatRequest;
use App\Models\AlQuran;
use App\Models\AlQuranTranslation;
use App\Models\Author;
use App\Models\Book;
use App\Models\Juz;
use App\Models\Languages;
use App\Models\Reference;
use App\Models\Surah;
use App\Models\Tafseer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Tag;
use App\Models\ContentTag;

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
        $surah = Surah::where('_id', $surahId)->with(['ayats' => function ($q) {
            $q->orderBy('sequence', 'asc');
        }])->first();
        $tags = Tag::all();
        $juzs = Juz::all();
        return view('Al_Quran.add_ayat', [
            'surah' => $surah,
            'juzs' => $juzs,
            'tags' => $tags
        ]);
    }
    public function store(Request $request)
    {

        // return $request->all();
        $alQuran = new AlQuran();
        $alQuran->surah_id = $request->surah_id;
        $alQuran->ayat = $request->ayat;
        $alQuran->para_no = $request->juz;
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
        if ($request->reference_type) {
            foreach ($request->reference_type as $key => $refType) {

                $reference = new Reference();
                $reference->type = 1;
                $reference->referal_id = $alQuran->id;
                $reference->reference_type = $refType;
                if ($request->file) {
                    $book = Book::where('_id', $request->file[$key])->first();
                    $reference->reference = $book->file;
                    $reference->reference_title = $book->title;
                }
                $reference->added_by = $this->user->id;
                $reference->save();
            }
        }
        if ($request->tags) {
            foreach ($request->tags as $key => $tag) {
                $tag = Tag::firstOrCreate(['title' => $tag]);

                $contentTag = ContentTag::firstOrCreate(['tag_id' => $tag->id, 'content_id' => $alQuran->id, 'content_type' => 4]);
            }
        }
        return redirect()->to('/ayat/edit/' . $request->surah_id . '/' . $alQuran->id)->with('msg', 'Ayat Saved Successfully!');
    }

    public function edit($surahId, $ayatId)
    {
        $surah = Surah::where('_id', $surahId)->with(['ayats' => function ($q) {
            $q->orderBy('sequence', 'asc');
        }])->first();
        $ayat = AlQuran::where('_id', $ayatId)->with('translations')->first();
        $juzs = Juz::all();
        $tags = Tag::all();
        $contentTag = ContentTag::where('content_id', $ayatId)->get();
        $languages = Languages::all();
        $author = Author::all();
        return view('Al_Quran.edit_ayat', [
            'surah' => $surah,
            'ayat' => $ayat,
            'juzs' => $juzs,
            'languages' => $languages,
            'tags' => $tags,
            'contentTags' =>  $contentTag,
        ]);
    }

    public function update(Request $request)
    {
        $alQuran = AlQuran::where('_id', $request->ayat_id)->first();

        $alQuran->surah_id = $request->surah_id;
        $alQuran->ayat = $request->ayat;
        $alQuran->para_no = $request->juz;
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
        if ($request->reference_type) {
            foreach ($request->reference_type as $key => $refType) {

                $reference = new Reference();
                $reference->type = 1;
                $reference->referal_id = $alQuran->id;
                $reference->reference_type = $refType;
                if ($request->file) {
                    $book = Book::where('_id', $request->file[$key])->first();
                    $reference->reference = $book->file;
                    $reference->reference_title = $book->title;
                }
                $reference->added_by = $this->user->id;
                $reference->save();
            }
        }
        if ($request->tags) {
            ContentTag::where(['content_id' => $alQuran->id, 'content_type' => 4])->delete();
            foreach ($request->tags as $key => $tag) {
                $tag = Tag::firstOrCreate(['title' => $tag]);

                $contentTag = ContentTag::firstOrCreate(['tag_id' => $tag->id, 'content_id' => $alQuran->id, 'content_type' => 4]);
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
    public function saveTranslation(Request $request)
    {
        $alQuranTranslation = new AlQuranTranslation();
        $alQuranTranslation->lang = $request->lang;
        $alQuranTranslation->translation = $request->translation;
        $alQuranTranslation->ayat_id = $request->ayatId;
        $alQuranTranslation->added_by = $this->user->id;
        $alQuranTranslation->save();


        $data = [];
        $languages = Languages::all();
        $data['ayat'] = $alQuranTranslation;
        $data['lang'] = $languages;

        return $data;
    }

    public function deleteTafseer(Request $request)
    {
        $alQuranTafseer = Tafseer::where('_id', $request->tafseerId)->delete();
        return sendSuccess('Deleted!', []);
    }

    public function updateTafseer(Request $request)
    {
        $alQuranTafseer = Tafseer::where('_id', $request->tafseerId)->first();
        $alQuranTafseer->lang = $request->lang;
        $alQuranTafseer->tafseer = $request->tafseer;
        $alQuranTafseer->ayat_id = $request->ayatId;
        $alQuranTafseer->added_by = $this->user->id;
        $alQuranTafseer->save();

        return $alQuranTafseer;
    }
    public function saveTafseer(Request $request)
    {

        $alQuranTafseer = new Tafseer();
        $alQuranTafseer->lang = $request->lang;
        $alQuranTafseer->tafseer = $request->tafseer;
        $alQuranTafseer->ayat_id = $request->ayatId;
        $alQuranTafseer->added_by = $this->user->id;
        $alQuranTafseer->save();

        $data = [];
        $languages = Languages::all();
        $data['ayat'] = $alQuranTafseer;
        $data['lang'] = $languages;

        return $data;
    }

    function getFiles(Request $request)
    {
        return Book::where('type', $request->type)->get();
    }
}
