<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Models\Book;
use App\Models\BookContent;
use App\Models\Category;
use App\Models\ContentTag;
use App\Models\Suitable;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use App\Models\Glossory;
use App\Models\ContentGlossary;
use App\Models\Publisher;
use Carbon\Carbon;

class BookController extends Controller
{
    public $user;
    public $type;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            $this->type =  Session::get('bookType');
            return $next($request);
        });
    }
    public function index($type)
    {
        Session::put('bookType', $type);
        return view('eBook.index', [
            'type' => $type,
            'hidden_table' => 0
        ]);
    }
    public function allBooks(Request $request)
    {
        $user_id = auth()->user()->id;
        if (auth()->user()->hasRole('Super Admin')) {
            $user_id = '';
        } else {
            $user_id = auth()->user()->id;
        }
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $search = $request->search['value'];
        $totalBrands = Book::approved()->when($user_id, function ($query) use ($user_id) {
            $query->where('added_by', $user_id)->orwhere('approved_by', $user_id);;
        })->count();
        $brands = Book::approved()->where('type', Session::get('bookType'))->when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%");
            });
        })->when($user_id, function ($query) use ($user_id) {
            $query->where('added_by', $user_id)->orwhere('approved_by', $user_id);
        })->skip((int) $start)->take((int) $length)->get();
        $brandsCount = Book::approved()->where('type', Session::get('bookType'))->when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%");
            });
        })->when($user_id, function ($query) use ($user_id) {
            $query->where('added_by', $user_id)->orwhere('approved_by', $user_id);
        })->skip((int) $start)->take((int) $length)->count();
        $brands->map(function ($b) {
            $b->numberOfUser = $b->totalUserReadThisBook();
            return $b;
        });

        $data = array(
            'draw' => $draw,
            'recordsTotal' => $totalBrands,
            'recordsFiltered' => $brandsCount,
            'data' => $brands,
        );
        return json_encode($data);
    }
    public function add($type)
    {
        $tags = Tag::all();
        $categories = Category::active()->where('type', $type)->get();
        $suitbles = Suitable::all();
        $glossary = Glossory::all();
        $publisher = Publisher::all();
        return view('eBook.add', [
            'type' => $type,
            'categories' => $categories,
            'tags' => $tags,
            'suitbles' => $suitbles,
            'glossary' => $glossary,
            'publisher' => $publisher
        ]);
    }
    public function store(Request $request)
    {
        // return $request->all();
        if ($request->type == 1) {
            $validated = $request->validate([
                'title' => 'required',
                'file.*' => 'required|file|mimes:epub',
            ]);
        } elseif ($request->type == 2 || $request->type == 7) {
            $validated = $request->validate([
                'title' => 'required',
                'file.*' => 'required|file|mimes:mp3',
            ]);
        } elseif ($request->type == 3) {
            $validated = $request->validate([
                'title' => 'required',
                'file.*' => 'required|file|mimes:epub,pdf',
            ]);
        }
        $book = new Book();
        $book->title = $request->title;
        $book->description = $request->description;
        $base_path = 'https://trueilm.s3.eu-north-1.amazonaws.com/';

        if ($request->has('cover')) {
            $file = $request->file('cover');
            $file_name = time() . '.' . $file->getClientOriginalExtension();
            $path =   $request->file('cover')->storeAs('files_covers', $file_name, 's3');
            Storage::disk('s3')->setVisibility($path, 'public');
            $book->image = $base_path . $path;
        }
        $book->added_by = $this->user->id;
        $book->category_id = $request->category;
        $book->type = $request->type;
        $book->status = 1;
        $book->approved = 0;
        $book->author = $request->author;
        $book->book_pages = $request->pages;
        $book->serial_no = $request->sr_no;
        $book->content_suitble = $request->suitble;
        $book->publisher_id = $request->publisher_id;
        $book->p_type = $request->pRadio;
        if ($request->pRadio == 0) {
            $book->price = 0;
        } else {
            $book->price = $request->price;
        }
        $book->save();
        foreach ($request->file as $key => $file) {
            $bookContent = new BookContent();
            $file_name = time() . '.' . $file->getClientOriginalExtension();
            $path =   $file->storeAs('files', $file_name, 's3');
            Storage::disk('s3')->setVisibility($path, 'public');
            $bookContent->file = $base_path . $path;
            $bookContent->book_id = $book->id;
            $bookContent->book_name = $file->getClientOriginalName();
            $bookContent->sequence = $key;
            $book->type = $request->type;
            $bookContent->save();
        }
        if ($request->tags) {
            foreach ($request->tags as $key => $tag) {

                $tag = Tag::firstOrCreate(['title' => $tag]);

                $contentTag = ContentTag::firstOrCreate(['tag_id' => $tag->id, 'content_id' => $book->id, 'content_type' => $request->type]);
            }
        }
        if ($request->glossary) {
            foreach ($request->glossary as $key => $g) {

                // $tag = Tag::firstOrCreate(['title' => $tag]);

                $contentTag = ContentGlossary::firstOrCreate(['glossary_id' => $g, 'content_id' => $book->id, 'content_type' => $request->type]);
            }
        }
        if ($request->type == 2 || $request->type == 7) {
            return redirect()->to('book/' . $request->type . '/list/' . $book->_id)->with('msg', 'Content Saved Successfully!');
        } else {
            return redirect()->to('books/' . $request->type)->with('msg', 'Content Saved Successfully!');
        }
    }

    public function edit($type, $id)
    {
        $categories = Category::active()->where('type', $type)->get();
        $book = Book::where('_id', $id)->first();
        $contentTag = ContentTag::where('content_id', $id)->get();
        $tags = Tag::all();
        $suitbles = Suitable::all();
        $glossary = Glossory::all();
        $publisher = Publisher::all();
        $contentGlossary = ContentGlossary::where('content_id', $id)->get();

        return view('eBook.edit', [
            'book' => $book,
            'type' => $type,
            'categories' => $categories,
            'tags' => $tags,
            'contentTags' =>  $contentTag,
            'suitbles' => $suitbles,
            'glossary' => $glossary,
            'contentGlossary' => $contentGlossary,
            'publisher' => $publisher
        ]);
    }

    public function update(Request $request)
    {
        if ($request->type == 1) {
            $validated = $request->validate([
                'title' => 'required',
                'file.*' => 'required|file|mimes:epub',
            ]);
        } elseif ($request->type == 2 || $request->type == 7) {
            $validated = $request->validate([
                'title' => 'required',
                'file.*' => 'required|file|mimes:mp3',
            ]);
        } elseif ($request->type == 3) {
            $validated = $request->validate([
                'title' => 'required',
                'file.*' => 'required|file|mimes:epub,pdf',
            ]);
        }

        $book = Book::where('_id', $request->id)->first();
        $book->title = $request->title;
        $book->description = $request->description;
        $base_path = 'https://trueilm.s3.eu-north-1.amazonaws.com/';

        if ($request->has('cover')) {
            $file = $request->file('cover');
            $file_name = time() . '.' . $file->getClientOriginalExtension();
            $path =   $request->file('cover')->storeAs('files_covers', $file_name, 's3');
            Storage::disk('s3')->setVisibility($path, 'public');
            $book->image = $base_path . $path;
        }

        $book->added_by = $this->user->id;
        $book->category_id = $request->category;
        $book->type = $request->type;
        $book->status =  $book->status;
        $book->approved =  $book->approved;
        $book->author = $request->author;
        $book->book_pages = $request->pages;
        $book->serial_no = $request->sr_no;
        $book->content_suitble = $request->suitble;
        $book->publisher_id = $request->publisher_id;
        $book->p_type = $request->pRadio;
        if ($request->pRadio == 0) {
            $book->price = 0;
        } else {
            $book->price = $request->price;
        }
        $book->save();
        if ($request->file) {
            foreach ($request->file as $key => $file) {
                $count = BookContent::where('book_id', $book->_id)->count();
                if ($key == 0) {
                    $seq = $count + 1;
                } else {
                    $seq = $count + $key;
                }
                $bookContent = new BookContent();
                $file_name = time() . '.' . $file->getClientOriginalExtension();
                $path =   $file->storeAs('files', $file_name, 's3');
                Storage::disk('s3')->setVisibility($path, 'public');
                $bookContent->file = $base_path . $path;
                $bookContent->book_id = $book->id;
                $bookContent->book_name = $file->getClientOriginalName();
                $bookContent->sequence = (int)$seq;
                $bookContent->save();
            }
        }
        if ($request->tags) {

            ContentTag::where('content_id', $book->id)->delete();
            foreach ($request->tags as $key => $tag) {
                $tag = Tag::firstOrCreate(['title' => $tag]);

                $contentTag = ContentTag::firstOrCreate(['tag_id' => $tag->id, 'content_id' => $book->id, 'content_type' => $request->type]);
            }
        }
        if ($request->glossary) {
            ContentGlossary::where('content_id', $book->id)->delete();

            foreach ($request->glossary as $key => $g) {

                // $tag = Tag::firstOrCreate(['title' => $tag]);

                $contentGlossary = ContentGlossary::create(['glossary_id' => $g, 'content_id' => $book->id, 'content_type' => $request->type]);
            }
        }

        if ($request->type == 2 || $request->type == 7) {
            return redirect()->to('book/' . $request->type . '/list/' . $book->_id)->with('msg', 'Content Saved Successfully!');
        } else {
            return redirect()->to('books/' . $request->type)->with('msg', 'Content Saved Successfully!');
        }
    }
    public function updateStatus($id)
    {
        $book = Book::where('_id', $id)->first();
        $status = $book->status == 1 ? 0 : 1;

        $book->update([
            'status' => $status
        ]);

        return redirect()->back();
    }
    public function pendingForApprove()
    {
        return view('eBook.pending_index', [
            'type' => Session::get('type')
        ]);
    }
    public function allPendingForApprovalBooks(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $search = $request->search['value'];
        $totalBrands = Book::pendingApprove()->count();
        $brands = Book::pendingApprove()->when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%");
            });
        })->skip((int) $start)->take((int) $length)->get();
        $brandsCount = Book::pendingApprove()->when($search, function ($q) use ($search) {
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
    public function approveBook($id)
    {
        $book = Book::where('_id', $id)->first();
        $approved = 1;
        if ($book->approved = 0 || $book->approved = 2) {
            $book->update([
                'approved' => $approved,
                'approved_by' => $this->user->id,
            ]);
        }

        return redirect()->back()->with('msg', 'Content Approved Successfully!');
    }

    public function rejectBook(Request $request, $id)
    {
        $book = Book::where('_id', $id)->first();
        $approved = 2;
        if ($book->approved = 0) {
            $book->update([
                'approved' => $approved,
                'approved_by' => $this->user->id,
                'reason' => $request->reason
            ]);
        }


        return redirect()->back()->with('msg', 'Content Reject Successfully!');
    }

    public function list($type, $id)
    {
        $content = BookContent::where('book_id', $id)->orderBy('sequence', 'asc')->get();
        return view('eBook.book_list', [
            'book_id' => $id,
            'content' => $content
        ]);
    }
    public function updateSequence(Request $request)
    {
        if ($request->chapters) {
            foreach ($request->chapters as $key => $chapter) {
                $bookContent = BookContent::where('_id', $chapter)->update([
                    'sequence' => (int)$request->sequence[$key]
                ]);
            }
        }
        return redirect()->back()->with('msg', 'Sequence Updated Successfully!');;
    }

    public function rejected()
    {
        return view('eBook.rejected', [
            'type' => Session::get('type')
        ]);
    }
    public function allRejectedBooks(Request $request)
    {
        $user_id = auth()->user()->id;
        if (auth()->user()->hasRole('Super Admin')) {
            $user_id = '';
        } else {
            $user_id = auth()->user()->id;
        }
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $search = $request->search['value'];
        $totalBrands = Book::rejected()->when($user_id, function ($query) use ($user_id) {
            $query->where('added_by', $user_id)->orWhere('approved_by', $user_id);;
        })->count();
        $brands = Book::rejected()->when($user_id, function ($query) use ($user_id) {
            $query->where('added_by', $user_id)->orWhere('approved_by', $user_id);;
        })->when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%");
            });
        })->skip((int) $start)->take((int) $length)->get();
        $brandsCount = Book::rejected()->when($user_id, function ($query) use ($user_id) {
            $query->where('added_by', $user_id)->orWhere('approved_by', $user_id);;
        })->when($search, function ($q) use ($search) {
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
    public function viewBook($book_id)
    {
        return view('eBook.view_book', [
            'book_id' => $book_id,
            'user_id' => $this->user->id
        ]);
    }
    public function bookDuringPeriod(Request $request)
    {
        // return $request->all();
        $user_id = auth()->user()->id;
        if (auth()->user()->hasRole('Super Admin')) {
            $user_id = '';
        } else {
            $user_id = auth()->user()->id;
        }
        $books = Book::where('type', $request->type)->when($user_id, function ($query) use ($user_id) {
            $query->where('added_by', $user_id)->orWhere('approved_by', $user_id);;
        })->when($request->e_date, function ($q) use ($request) {
            $q->whereBetween('created_at', [new Carbon($request->s_date),  new Carbon($request->e_date)]);
        })->paginate(10);
        $books->map(function ($b) {
            $b->numberOfUser = $b->totalUserReadThisBook();
            return $b;
        });
        return view('eBook.index', [
            'type' => $request->type,
            'hidden_table' => 1,
            'books' => $books,
            's_date' => $request->s_date,
            'e_date' => $request->e_date
        ]);
    }
}
