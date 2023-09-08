<?php

namespace App\Http\Controllers;

use App\Http\Requests\AyatRequest;
use App\Models\AlQuran;
use App\Models\AlQuranTranslation;
use App\Models\Author;
use App\Models\AuthorLanguage;
use App\Models\Book;
use App\Models\ContentGlossary;
use App\Models\Juz;
use App\Models\Languages;
use App\Models\Reference;
use App\Models\Surah;
use App\Models\Tafseer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Tag;
use App\Models\ContentTag;
use App\Models\Glossory;

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
        $glossary = Glossory::all();
        $juzs = Juz::all();
        return view('Al_Quran.add_ayat', [
            'surah' => $surah,
            'juzs' => $juzs,
            'tags' => $tags,
            'glossary' => $glossary
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
            foreach ($request->author_langs as $key => $lang) {
                $alQuranTranslation = new AlQuranTranslation();
                $alQuranTranslation->lang = $lang;
                $alQuranTranslation->translation = $request->translations[$key];
                $alQuranTranslation->ayat_id = $alQuran->id;
                $alQuranTranslation->surah_id =    $alQuran->surah_id;
                $alQuranTranslation->added_by = $this->user->id;
                $alQuranTranslation->save();
            }
        }
        if ($request->tafseers) {
            foreach ($request->author_langs as $key => $lang) {
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

                $contentTag = ContentTag::firstOrCreate(['tag_id' => $tag->id, 'content_id' => $alQuran->id, 'content_type' => "4"]);
            }
        }
        if ($request->glossary) {
            foreach ($request->glossary as $key => $g) {
                // $tag = Tag::firstOrCreate(['title' => $tag]);

                $contentGlossary = ContentGlossary::firstOrCreate(['glossary_id' => $g, 'content_id' => $alQuran->id, 'content_type' => "4"]);
            }
        }
        return redirect()->to('/ayat/edit/' . $request->surah_id . '/' . $alQuran->id)->with('msg', 'Ayat Saved Successfully!');
    }
    public function authorLanguage(Request $request)
    {
        $authLang =  AuthorLanguage::where('author_id', $request->author)->where('lang_id', $request->lang)->first();
        if ($authLang) {
            return redirect()->back()->with('dmsg', 'Author Language Already Exits!');
        } else {
            $authorLanguage = AuthorLanguage::create([
                'author_id' => $request->author,
                'lang_id' => $request->lang
            ]);
            return redirect()->back()->with('msg', 'Author Language Saved Successfully!');
        }
    }
    public function edit($surahId, $ayatId)
    {
        $surah = Surah::where('_id', $surahId)->with(['ayats' => function ($q) {
            $q->orderBy('sequence', 'asc');
        }])->first();
        $ayat = AlQuran::where('_id', $ayatId)->with('translations', 'tafseers')->first();
        $juzs = Juz::all();
        $tags = Tag::all();
        $contentTag = ContentTag::where('content_id', $ayatId)->get();
        $languages = Languages::all();

        $authorLanguages =  AuthorLanguage::with('author', 'language')->get();
        $author = Author::all();
        $glossary = Glossory::all();

        $contentGlossary = ContentGlossary::where('content_id', $ayatId)->get();
        return view('Al_Quran.edit_ayat', [
            'surah' => $surah,
            'ayat' => $ayat,
            'juzs' => $juzs,
            'languages' => $languages,
            'tags' => $tags,
            'contentTags' =>  $contentTag,
            'author' => $author,
            'authorLanguages' => $authorLanguages,
            'glossary' => $glossary,
            'contentGlossary' =>  $contentGlossary
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
        // $alQuranTranslation = Tafseer::where('ayat_id', $request->ayat_id)->delete();
        if ($request->translations) {
            foreach ($request->author_langs as $key => $lang) {
                $alQuranTranslation = new AlQuranTranslation();
                $alQuranTranslation->lang = $lang;
                $alQuranTranslation->translation = $request->translations[$key];
                $alQuranTranslation->ayat_id = $alQuran->id;
                $alQuranTranslation->added_by = $this->user->id;
                $alQuranTranslation->author_lang = $lang;
                $alQuranTranslation->surah_id =    $alQuran->surah_id;
                $alQuranTranslation->type = 1;
                $alQuranTranslation->save();
            }
        }
        if ($request->tafseers) {
            foreach ($request->author_langs as $key => $lang) {
                $alQuranTranslation = new AlQuranTranslation();
                $alQuranTranslation->lang = $lang;
                $alQuranTranslation->translation = $request->tafseers[$key];
                $alQuranTranslation->ayat_id = $alQuran->id;
                $alQuranTranslation->added_by = $this->user->id;
                $alQuranTranslation->author_lang = $lang;
                $alQuranTranslation->type = 2;
                $alQuranTranslation->save();
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

            ContentTag::where('content_id', $alQuran->id)->delete();
            foreach ($request->tags as $key => $tag) {
                $tag = Tag::firstOrCreate(['title' => $tag]);

                $contentTag = ContentTag::firstOrCreate(['tag_id' => $tag->id, 'content_id' => $alQuran->id, 'content_type' => "4"]);
            }
        }
        if ($request->glossary) {
            ContentGlossary::where('content_id', $alQuran->id)->delete();

            foreach ($request->glossary as $key => $g) {
                // $tag = Tag::firstOrCreate(['title' => $tag]);

                $contentGlossary = ContentGlossary::firstOrCreate(['glossary_id' => $g, 'content_id' => $alQuran->id, 'content_type' => "4"]);
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
        // return $request->all();
        $alQuranTranslation = AlQuranTranslation::where('_id', $request->transId)->first();
        if ($alQuranTranslation) {
            $alQuranTranslation->translation = $request->translation;
            $alQuranTranslation->ayat_id = $request->ayatId;
            $alQuranTranslation->author_lang = $request->author_lang;
            $alQuranTranslation->type = $request->type;
            $alQuranTranslation->added_by = $this->user->id;
            $alQuranTranslation->save();
        } else {
            $alQuranTranslation = new AlQuranTranslation();
            $alQuranTranslation->translation = $request->translation;
            $alQuranTranslation->ayat_id = $request->ayatId;
            $alQuranTranslation->author_lang = $request->author_lang;
            $alQuranTranslation->type = $request->type;
            $alQuranTranslation->added_by = $this->user->id;
            $alQuranTranslation->save();
        }


        return $alQuranTranslation;
    }
    public function saveTranslation(Request $request)
    {
        $alQuranTranslation = new AlQuranTranslation();
        $alQuranTranslation->lang = $request->lang;
        $alQuranTranslation->translation = $request->translation;
        $alQuranTranslation->ayat_id = $request->ayatId;
        $alQuranTranslation->author_lang = $request->author_lang;
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
