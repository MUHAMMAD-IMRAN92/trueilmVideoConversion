<?php

namespace App\Http\Controllers;

use App\Http\Requests\HadeesRequest;
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
        return view('hadees_book.index');
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
    public function addBook()
    {
        return view('hadees_book.add');
    }
    public function storeBook(Request $request)
    {
        $book = new HadeesBooks();

        $book->title = $request->title;
        $book->description = $request->description;
        $book->save();

        return redirect()->to('/hadith/books')->with('msg', 'Hadith Book Saved Successfully!');
    }
    public function add($id)
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
            'chapter' => $chapter
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
        return redirect()->to("hadith/edit/$request->book_id/$hadees->id")->with('msg', 'Hadith Saved Successfully!');
    }

    public function editBook($bookId)
    {
        $hadeesBook = HadeesBooks::where('_id', $bookId)->first();
        $hadees = Hadees::where('_id', $hadeesBook->id)->first();

        return view('hadees_book.edit', [
            'hadeesBook' => $hadeesBook,
            'hadees' => $hadees
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
        $hadeesTranslation = HadeesTranslation::where('_id', $request->transId)->delete();
        return sendSuccess('Deleted!', []);
    }
    public function updateTranslation(Request $request)
    {
        // return $request->all();
        $hadees = Hadees::where('_id', $request->hadith_id)->first();
        $alQuranTranslation = HadeesTranslation::where('_id', $request->transId)->first();
        if ($alQuranTranslation) {
            $alQuranTranslation->translation = $request->translation;
            $alQuranTranslation->hadees_id = $request->hadith_id;
            $alQuranTranslation->author_lang = $request->author_lang;
            $alQuranTranslation->type = $request->type;
            $alQuranTranslation->added_by = $this->user->id;
            $alQuranTranslation->chapter_id = $hadees->chapter_id;
            $alQuranTranslation->save();
        } else {
            $alQuranTranslation = new HadeesTranslation();
            $alQuranTranslation->translation = $request->translation;
            $alQuranTranslation->hadees_id = $request->hadith_id;
            $alQuranTranslation->author_lang = $request->author_lang;
            $alQuranTranslation->type = $request->type;
            $alQuranTranslation->added_by = $this->user->id;
            $alQuranTranslation->chapter_id = $hadees->chapter_id;
            $alQuranTranslation->save();
        }


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
}
