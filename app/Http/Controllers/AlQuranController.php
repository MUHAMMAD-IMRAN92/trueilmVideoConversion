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
use App\Jobs\SurahCombination as SurahCombinationJob;
use App\Models\RecitationCombination;
use App\Models\SurahCombinations;
use Meilisearch\Client;
use Illuminate\Support\Facades\Gate;

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

        if(intval($request->combination_type) == 1){
            cheakPermission('surah-translations-combination-add');
        }
        elseif(intval($request->combination_type) == 2){
            cheakPermission('surah-translations-combination-add');
        }
        elseif(intval($request->combination_type) == 3){
            cheakPermission('hadith-translations-combination-add');
        }
        else{
            cheakPermission('hadith-Tafseer-combination-add');
        }
        // return $request->all();
        $author = Author::where('_id', $request->author)->first();
        if (!$author) {
            $author = new Author();
            $author->name = $request->author;
            $author->added_by = $this->user->id;
            $author->save();
            $author = $author;
        }
        $language = Languages::where('_id', $request->lang)->first();
        if (!$language) {
            $language = new Languages();
            $language->title = $request->lang;
            $language->added_by = $this->user->id;
            $language->direction = $request->direction ?? 'ltr';
            $language->save();

            $language = $language;
        }
        $authLang =  AuthorLanguage::where('author_id', $author->_id)->where('lang_id', $language->_id)->where('type', (int) $request->combination_type)->first();
        if ($authLang) {
            return redirect()->back()->with('dmsg', 'Author Language Already Exits!');
        } else {
            $authorLanguage = AuthorLanguage::create([
                'author_id' => $author->_id,
                'lang_id' =>  $language->_id,
                'type' => (int) $request->combination_type,
                'status' => 1
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
        if(intval($request->type) == 1){
            cheakPermission('add-surah-translations');
        }else{
            cheakPermission('add-surah-Tafseer');
        }
        $alQuranTranslationSurah = AlQuranTranslation::where('_id', $request->transId)->first();
        SurahCombinationJob::dispatch($alQuranTranslationSurah->surah_id);
        $alQuranTranslation = AlQuranTranslation::where('_id', $request->transId)->delete();
        return sendSuccess('Deleted!', []);
    }


    public function updateTranslation(Request $request)
    {

        if(intval($request->type) == 1){
            cheakPermission('add-surah-translations');
        }else{
            cheakPermission('add-surah-Tafseer');
        }
        ini_set("memory_limit", "-1");
        $client = new  Client('http://localhost:7700', '3bc7ba18215601c4de218ef53f0f90e830a7f144');
        // return $request->all();
        $alQuranTranslation = AlQuranTranslation::where('ayat_id', $request->ayatId)->where('author_lang', $request->author_lang)->where('type', (int)$request->type)->first();
        if ($alQuranTranslation) {
            $alQuranTranslation->translation = $request->translation;
            $alQuranTranslation->ayat_id = $request->ayatId;
            $alQuranTranslation->surah_id = $alQuranTranslation->surah_id;
            $alQuranTranslation->author_lang = $request->author_lang;
            $alQuranTranslation->type = (int)$request->type;
            $alQuranTranslation->added_by = $this->user->id;
            $alQuranTranslation->save();
            $alQurantranslationsclient =  $client->index('alQurantranslations')->updateDocuments(array($alQuranTranslation), '_id');
        } else {

            $alQuran = AlQuran::where('_id', $request->ayatId)->first();
            $alQuranTranslation = new AlQuranTranslation();
            $alQuranTranslation->translation = $request->translation;
            $alQuranTranslation->ayat_id = $request->ayatId;
            $alQuranTranslation->surah_id = $alQuran->surah_id;
            $alQuranTranslation->author_lang = $request->author_lang;
            $alQuranTranslation->type = (int)$request->type;
            $alQuranTranslation->added_by = $this->user->id;
            $alQuranTranslation->save();
            $alQurantranslationsclient =  $client->index('alQurantranslations')->addDocuments(array($alQuranTranslation), '_id');
        }
        SurahCombinationJob::dispatch($alQuranTranslation->surah_id, (int)$request->type);



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

    public function getFiles(Request $request)
    {
        return Book::where('type', $request->type)->get();
    }
    
    public  function newAllSurah(Request $request, $type)
    {
        
        if(intval($type) == 1){
            cheakPermission('surah-translations-view');
        }else{
            cheakPermission('surah-Tafseer-view');
        }



        $surahs =   SurahCombinations::when($request->surah, function ($q) use ($request) {
            $q->where('surah_id', $request->surah);
        })->paginate(10);

        $surahDropDown =   Surah::orderBy('sequence' , 'ASC')->get(['_id', 'surah', 'sequence']);
        if ((int)$type == 3) {
            $combinationCount =  RecitationCombination::count();
        } else {

            $combinationCount =  AuthorLanguage::where('type', (int)$type)->count();
        }

        return view('Al_Quran.newAlQuran', [
            'surahs' => $surahs,
            'combinationCount' => $combinationCount,
            'surahDropDown' => $surahDropDown,
            'content_type' => $type
        ]);
    }
    public function surah(Request $request, $type,  $id)
    {
        if(intval($type) == 1){
            cheakPermission('surah-translations-view');
        }else{
            cheakPermission('surah-Tafseer-view');
        }


        $surah = Surah::where('_id', $id)->first();
        $languages = Languages::all();
        $author = Author::all();

        $combination = AuthorLanguage::where('type', (int)$type)
            ->when($request->lang, function ($query) use ($request) {
                $query->where('lang_id', $request->lang);
            })
            ->when($request->author, function ($query) use ($request) {
                $query->where('author_id', $request->author);
            })
            ->with([
                'translations' => function ($query) use ($surah, $type) {
                    $query->where('type', (int)$type)
                        ->when($surah, function ($q) use ($surah) {
                            $q->whereHas('ayats', function ($e) use ($surah) {
                                $e->where('surah_id', $surah->_id);
                            })->with('ayats');
                        });
                }
            ])
            ->paginate(5);


        return view('Al_Quran.new_surah_page', [
            'surah' => $surah,
            'combinations' => $combination,
            'languages' => $languages,
            'author' => $author,
            'type' => $type
        ]);
    }
    public function surahAyats(Request $request, $type, $surah_id, $combination_id)
    {
        if(intval($type) == 1){
            cheakPermission('surah-translations-view');
        }else{
            cheakPermission('surah-Tafseer-view');
        }

        
        $surah = Surah::where('_id', $surah_id)
            ->with([
                'ayats',
                'introduction' => function ($q) use ($combination_id) {
                    $q->where('type', 0)->where('author_lang', $combination_id);
                }
            ])
            ->first();

        $ayats = AlQuran::with([
            'khatoot' => function ($q) use ($request) {
                $q->when($request->khatoot, function ($k) use ($request) {
                    $k->where('type', (int)$request->khatoot);
                });
            },
            'translations' => function ($q) use ($combination_id, $type) {
                $q->where('type', (int) $type)->where('author_lang', $combination_id);
            },
            'revelation' => function ($q) use ($combination_id, $type) {
                $q->where('type', 4)->where('author_lang', $combination_id);
            },
            'notes' => function ($q) use ($combination_id, $type) {
                $q->where('type', 3)->where('author_lang', $combination_id);
            }
        ])
            ->when($request->ayat_id, function ($q) use ($request) {
                $q->where('_id', $request->ayat_id);
            })
            ->where('surah_id', $surah_id)->orderBy('verse_number' , 'ASC')
            ->paginate(10);

        $languages = Languages::all();
        $author = Author::all();

        $currentCombination = AuthorLanguage::where('type', (int)$type)
            ->where('_id', $combination_id)
            ->with([
                'translations' => function ($q) use ($surah, $type) {
                    $q->where('type', (int) $type)->whereHas('ayats', function ($e) use ($surah) {
                        $e->where('surah_id', $surah->_id);
                    })->with('ayats');
                }
            ])
            ->first();


        return view('Al_Quran.new_ayat_page', [
            'surah' => $surah,
            'ayats' => $ayats,
            'languages' => $languages,
            'author' => $author,
            'currentCombination' => $currentCombination,
            'type' => $type
        ]);
    }
    public function disableCombination($id)
    {
        $combination = AuthorLanguage::where('_id', $id)->first();

        if(intval($combination->type) == 1){
            cheakPermission('surah-translations-combination-action');
        }
        elseif(intval($combination->type) == 2){
            cheakPermission('surah-translations-combination-action');
        }
        elseif(intval($combination->type) == 3){
            cheakPermission('hadith-translations-combination-action');
        }
        else{
            cheakPermission('hadith-Tafseer-combination-action');
        }
        if ($combination->status == 1) {
            $combination->status = 0;
            $combination->save();
        } else {
            $combination->status = 1;
            $combination->save();
        }

        return redirect()->back()->with('msg', 'Combination Updated !');
    }
    public function surahRecitation()
    {
        $recitations = Author::where('name', 'like', '%' . request()->input('query') . '%')->get();
    }
}
