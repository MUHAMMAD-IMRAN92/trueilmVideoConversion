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

        return view('hadees.add', [
            'hadeesBook' => $hadeesBook,
            'hadees' => $hadees
        ]);
    }
    public function store(HadeesRequest $request)
    {
        $hadees = new Hadees();
        $hadees->hadees = $request->hadith;
        $hadees->type = $request->type;
        $hadees->book_id = $request->book_id;
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

        return view('hadees.edit', [
            'hadeesBook' => $hadeesBook,
            'hadees' => $hadees,
            'languages' => $languages
        ]);
    }

    public function update(HadeesRequest $request)
    {
        $hadees = Hadees::where('_id', $request->hadees_id)->first();
        $hadees->hadees = $request->hadith;
        $hadees->type = $request->type;
        $hadees->added_by = $this->user->id;
        $hadees->save();

        HadeesTranslation::where('hadees_id', $request->id)->delete();


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

        return redirect()->to("hadith/edit/$hadees->book_id/$hadees->id")->with('msg', 'Hadith Updated Successfully!');
    }

    public function deleteTranslation(Request $request)
    {
        $hadeesTranslation = HadeesTranslation::where('_id', $request->transId)->delete();
        return sendSuccess('Deleted!', []);
    }

    public function updateTranslation(Request $request)
    {
        $hadeesTranslation = HadeesTranslation::where('_id', $request->transId)->first();
        $hadeesTranslation->lang = $request->lang;
        $hadeesTranslation->translation = $request->translation;
        $hadeesTranslation->hadees_id = $request->hadithId;
        $hadeesTranslation->added_by = $this->user->id;
        $hadeesTranslation->save();


        return $hadeesTranslation;
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
}
