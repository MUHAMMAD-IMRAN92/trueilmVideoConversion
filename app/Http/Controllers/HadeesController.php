<?php

namespace App\Http\Controllers;

use App\Http\Requests\HadeesRequest;
use App\Jobs\HadeeesBookCombination;
use App\Models\Hadees;
use App\Models\HadeesBooks;
use App\Models\HadeesReference;
use App\Models\HadeesTranslation;
use App\Models\Languages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Tag;
use App\Models\ContentTag;
use App\Models\ContentGlossary;
use App\Models\Glossory;
use App\Models\HadithChapter;
use App\Models\Author;
use App\Models\AuthorLanguage;
use App\Models\Reference;
use App\Models\Book;
use App\Models\HadeesBookCombination;
use Meilisearch\Client;

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
    public function index(Request $request, $type)
    {

        $hadeesBookCombination = HadeesBookCombination::when($request->book_id, function ($q) use ($request) {
            $q->where('book_id', $request->book_id);
        })->paginate(10);

        $hadithDropDown =   HadeesBooks::get(['_id', 'title']);

        $combinationCount =  AuthorLanguage::where('type', (int)$type)->count();

        return view('hadees_book.index', [
            'hadeesBookCombination' => $hadeesBookCombination,
            'combinationCount' => $combinationCount,
            'hadithDropDown' => $hadithDropDown,
            'content_type' => $type
        ]);
    }
    public function allBook(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $search = $request->search['value'];
        $totalBrands = HadeesBooks::count();
        $brands = HadeesBooks::when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%");
            });
        })->skip((int) $start)->take((int) $length)->get();
        $brandsCount = HadeesBooks::when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%");
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
    public function addBook($type)
    {
        return view('hadees_book.add', [
            'type' => $type
        ]);
    }
    public function storeBook(Request $request)
    {

        $book = new HadeesBooks();

        $book->title = $request->title;
        $book->description = $request->description;
        $book->save();
        HadeeesBookCombination::dispatch($book->_id, 0);

        return redirect()->to('hadith/books/' . $request->type)->with('msg', 'Hadith Book Saved Successfully!');
    }
    public function add($type,  $id, $combination_id)
    {
        $hadeesBook = HadeesBooks::where('_id', $id)->first();
        $hadees = Hadees::where('_id', $hadeesBook->id)->get();
        $glossary = Glossory::all();
        $chapter = HadithChapter::where('book_id', $id)->get();
        $tags = Tag::all();
        return view('hadees.add', [
            'hadeesBook' => $hadeesBook,
            'hadees' => $hadees,
            'tags' => $tags,
            'glossary' => $glossary,
            'chapter' => $chapter,
            'type' => $type,
            'combination_id' => $combination_id
        ]);
    }
    public function store(HadeesRequest $request)
    {
        $hadees = new Hadees();
        $hadees->hadees = $request->hadith;
        $hadees->type = $request->type;
        $hadees->book_id = $request->book_id;
        $hadees->added_by = $this->user->id;
        $hadees->chapter_id = $request->chapter_id;
        $hadees->hadith_number =  $request->hadith_number;

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
        if ($request->tags) {
            foreach ($request->tags as $key => $tag) {
                $tag = Tag::firstOrCreate(['title' => $tag]);

                $contentTag = ContentTag::firstOrCreate(['tag_id' => $tag->id, 'content_id' => $hadees->id, 'content_type' =>  "5"]);
            }
        }
        if ($request->glossary) {
            foreach ($request->glossary as $key => $g) {
                // $tag = Tag::firstOrCreate(['title' => $tag]);

                $contentGlossary = ContentGlossary::firstOrCreate(['glossary_id' => $g, 'content_id' => $hadees->id, 'content_type' => "5"]);
            }
        }
        return redirect()->to("hadith/books/combination/$request->content_type/$request->book_id/$request->combination_id")->with('msg', 'Hadith Saved Successfully!');
    }

    public function editBook($bookId)
    {
        $hadeesBook = HadeesBooks::where('_id', $bookId)->first();
        $hadees = Hadees::where('_id', $hadeesBook->id)->first();
        $author = Author::all();
        $languages = Languages::all();
        return view('hadees_book.edit', [
            'hadeesBook' => $hadeesBook,
            'hadees' => $hadees,
            'author' => $author,
            'languages' => $languages,
        ]);
    }
    public function edit($bookId, $hadeesId)
    {
        $hadeesBook = HadeesBooks::where('_id', $bookId)->with('hadees')->first();
        $hadees = Hadees::where('_id', $hadeesId)->with('translations', 'references')->first();
        $languages = Languages::all();
        $tags = Tag::all();
        $contentTag = ContentTag::where('content_id', $hadeesId)->get();
        $glossary = Glossory::all();
        $chapter = HadithChapter::where('book_id', $bookId)->get();
        $contentGlossary = ContentGlossary::where('content_id', $hadeesId)->get();
        $author = Author::all();
        $languages = Languages::all();

        $authorLanguages =  AuthorLanguage::with('author', 'language')->get();
        return view('hadees.edit', [
            'hadeesBook' => $hadeesBook,
            'hadees' => $hadees,
            'languages' => $languages,
            'tags' => $tags,
            'contentTags' =>  $contentTag,
            'glossary' => $glossary,
            'contentGlossary' =>  $contentGlossary,
            'chapter' => $chapter,
            'author' => $author,
            'authorLanguages' => $authorLanguages
        ]);
    }

    public function update(HadeesRequest $request)
    {
        $hadees = Hadees::where('_id', $request->hadees_id)->first();
        $hadees->hadees = $request->hadith;
        $hadees->type = $request->type;
        $hadees->added_by = $this->user->id;
        $hadees->chapter_id = $request->chapter_id;
        $hadees->hadith_number =  $request->hadith_number;

        $hadees->save();

        HadeesTranslation::where('hadees_id', $request->id)->delete();


        if ($request->translations) {
            foreach ($request->author_langs as $key => $lang) {
                $alQuranTranslation = new HadeesTranslation();
                $alQuranTranslation->lang = $lang;
                $alQuranTranslation->translation = $request->translations[$key];
                $alQuranTranslation->ayat_id = $hadees->id;
                $alQuranTranslation->added_by = $this->user->id;
                $alQuranTranslation->save();
            }
        }
        if ($request->reference_type) {
            foreach ($request->reference_type as $key => $refType) {

                $reference = new Reference();
                $reference->type = 2;
                $reference->referal_id = $hadees->id;
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
            ContentTag::where('content_id', $hadees->id)->delete();
            foreach ($request->tags as $key => $tag) {
                $tag = Tag::firstOrCreate(['title' => $tag]);

                $contentTag = ContentTag::firstOrCreate(['tag_id' => $tag->id, 'content_id' => $hadees->id, 'content_type' =>  "5"]);
            }
        }
        if ($request->glossary) {
            ContentGlossary::where('content_id', $hadees->id)->delete();

            foreach ($request->glossary as $key => $g) {
                // $tag = Tag::firstOrCreate(['title' => $tag]);

                $contentGlossary = ContentGlossary::firstOrCreate(['glossary_id' => $g, 'content_id' => $hadees->id, 'content_type' => "5"]);
            }
        }
        return redirect()->to("hadith/edit/$hadees->book_id/$hadees->id")->with('msg', 'Hadith Updated Successfully!');
    }

    public function deleteTranslation(Request $request)
    {
        // return $request->all();
        $hadeesTranslation = HadeesTranslation::where('_id', $request->transId)->first();
        HadeeesBookCombination::dispatch($hadeesTranslation->book_id);
        $hadeesTranslation = HadeesTranslation::where('_id', $request->transId)->delete();

        return sendSuccess('Deleted!', []);
    }
    public function updateTranslation(Request $request)
    {
        ini_set("memory_limit", "-1");
        $client = new  Client('http://localhost:7700', '3bc7ba18215601c4de218ef53f0f90e830a7f144');
        $hadees = Hadees::where('_id', $request->hadith_id)->first();
        $alQuranTranslation = HadeesTranslation::where('hadees_id', $request->hadith_id)->where('author_lang', $request->author_lang)->where('type', (int) $request->type)->first();
        if ($alQuranTranslation) {
            $alQuranTranslation->translation = $request->translation;
            $alQuranTranslation->hadees_id = $request->hadith_id;
            $alQuranTranslation->author_lang = $request->author_lang;
            $alQuranTranslation->type = (int)$request->type;
            $alQuranTranslation->added_by = $this->user->id;
            $alQuranTranslation->book_id = $hadees->book_id;
            $alQuranTranslation->chapter_id = $hadees->chapter_id;
            $alQuranTranslation->save();
            $alQurantranslationsclient =  $client->index('alHadeestranslations')->updateDocuments(array($alQuranTranslation), '_id');
        } else {
            $alQuranTranslation = new HadeesTranslation();
            $alQuranTranslation->translation = $request->translation;
            $alQuranTranslation->hadees_id = $request->hadith_id;
            $alQuranTranslation->author_lang = $request->author_lang;
            $alQuranTranslation->type = (int)$request->type;
            $alQuranTranslation->added_by = $this->user->id;
            $alQuranTranslation->book_id = $hadees->book_id;
            $alQuranTranslation->chapter_id = $hadees->chapter_id;
            $alQuranTranslation->save();
            $alQurantranslationsclient =  $client->index('alHadeestranslations')->addDocuments(array($alQuranTranslation), '_id');
        }
        HadeeesBookCombination::dispatch($alQuranTranslation->book_id, (int)$request->type);


        return $alQuranTranslation;
    }
    public function saveTranslation(Request $request)
    {
        $hadeesTranslation = new HadeesTranslation();
        $hadeesTranslation->lang = $request->lang;
        $hadeesTranslation->translation = $request->translation;
        $hadeesTranslation->hadees_id = $request->hadithId;
        $hadeesTranslation->added_by = $this->user->id;
        $hadeesTranslation->save();


        $data = [];
        $languages = Languages::all();
        $data['hadees'] = $hadeesTranslation;
        $data['lang'] = $languages;

        return $data;
    }
    public function addChapter(Request $request)
    {
        $hadithChapter = new HadithChapter();
        $hadithChapter->book_id = $request->hadith_book;
        $hadithChapter->title = $request->title;
        $hadithChapter->save();

        return $hadithChapter;
    }

    public function hadithCombination(Request $request, $type, $id)
    {
        if ($type == 3) {
            $tranlation_type = 5;
        } else {
            $tranlation_type = 6;
        }
        // return $request->all();
        $languages = Languages::all();
        $author = Author::all();
        $combinationCount =  AuthorLanguage::where('type', (int)$type)->count();
        $book = HadeesBooks::where('_id', $id)->first();
        $combination =  AuthorLanguage::when($request->lang, function ($l) use ($request) {
            $l->where('lang_id', $request->lang);
        })->when($request->author, function ($a) use ($request) {
            $a->where('author_id', $request->author);
        })->where('type', (int)$type)->with(['HadithTranslations' => function ($q) use ($book, $tranlation_type) {
            $q->where('type', (int)$tranlation_type)->where('book_id', $book->_id);
        }])->paginate(10);
        return view('hadees_book.combination', [
            'book' => $book,
            'combinations' => $combination,
            'languages' => $languages,
            'author' => $author,
            'type' => $type
        ]);
    }
    // 651d74c5904d3d1f6703f01d
    public function Hadiths(Request $request, $type, $book_id, $combination_id)
    {
        if ($type == 3) {
            $tranlation_type = 5;
        } else {
            $tranlation_type = 6;
        }
        $book =   HadeesBooks::where('_id', $book_id)->with('hadees')->with(['introduction' => function ($q) use ($combination_id, $type) {
            $q->where('type', 0)->where('author_lang', $combination_id);
        }])->first();
        $hadiths = Hadees::when($book_id, function ($q) use ($request, $book_id) {
            $q->where('book_id', $book_id);
        })->where('book_id', $book_id)->with(['translations' => function ($q) use ($combination_id, $tranlation_type) {
            $q->where('type', (int)$tranlation_type)->where('author_lang', $combination_id);
        }])->with(['revelation' => function ($q) use ($combination_id, $type) {
            $q->where('type', 4)->where('author_lang', $combination_id);
        }])->with(['notes' => function ($q) use ($combination_id, $type) {
            $q->where('type', 3)->where('author_lang', $combination_id);
        }])->paginate(10);
        $languages = Languages::all();
        $author = Author::all();
        $currentCombination =  AuthorLanguage::where('type', (int)$type)->where('_id', $combination_id)->with(['HadithTranslations' => function ($q) use ($book_id, $type) {
            $q->where('type', 1);
        }])->first();
        return view('hadees_book.new_Hadees', [
            'book' => $book,
            'hadiths' => $hadiths,
            'languages' => $languages,
            'author' => $author,
            'currentCombination' => $currentCombination,
            'type' => $type
        ]);
    }
}
