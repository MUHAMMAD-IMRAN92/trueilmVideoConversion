<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Jobs\SendNotifications;
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
use Meilisearch\Client;
use App\Models\Author;
use App\Models\Reference;

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
        $totalBrands = Book::where('approved', '!=', 2)->where('type', $request->type)->when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%");
            });
        })->when($user_id, function ($query) use ($user_id) {
            $query->where('added_by', $user_id);
        })->count();
        $brands = Book::where('approved', '!=', 2)->where('type', $request->type)->when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%");
            });
        })->when($user_id, function ($query) use ($user_id) {
            $query->where('added_by', $user_id);
        })->with('author', 'user', 'approver', 'category')->orderBy('created_at', 'desc')->skip((int) $start)->take((int) $length)->get();
        $brandsCount = Book::where('approved', '!=', 2)->where('type', $request->type)->when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%");
            });
        })->when($user_id, function ($query) use ($user_id) {
            $query->where('added_by', $user_id);
        })->skip((int) $start)->take((int) $length)->count();
        // $brands->map(function ($b) {
        //     $b->numberOfUser = $b->totalUserReadThisBook();
        //     return $b;
        // });

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
        $categories = Category::active()->get();
        $suitbles = Suitable::all();
        $glossary = Glossory::all();
        $publisher = Publisher::all();
        $author = Author::where('type', '1')->get();
        return view('eBook.add', [
            'type' => $type,
            'categories' => $categories,
            'tags' => $tags,
            'suitbles' => $suitbles,
            'glossary' => $glossary,
            'publisher' => $publisher,
            'author' => $author
        ]);
    }
    public function store(Request $request)
    {

        ini_set('max_execution_time', '0');
        ini_set("memory_limit", "-1");

        $book = new Book();
        $book->title = $request->title;
        $book->description = $request->description;
        $book->inside = $request->inside;
        $base_path = 'https://trueilm.s3.eu-north-1.amazonaws.com/';

        if ($request->has('cover')) {
            $file = $request->file('cover');
            $file_name = time() . '.' . $file->getClientOriginalExtension();
            $path =   $request->file('cover')->storeAs('files_covers', $file_name, 's3');
            Storage::disk('s3')->setVisibility($path, 'public');
            $book->image = $base_path . $path;
        }
        $book->added_by = $this->user->id;
        $book->category_id = $request->category_id;
        $book->type = $request->type;
        $book->status = 1;
        $book->approved = 0;
        $book->book_pages = $request->pages;
        $book->serial_no = $request->sr_no;
        $book->content_suitble = $request->suitble;
        $book->publisher_id = $request->publisher_id;
        $book->author_id = $request->author_id;
        $book->p_type = $request->pRadio;
        $book->age = $request->age;
        if ($request->pRadio == 0) {
            $book->price = 0;
        } else {
            $book->price = $request->price;
            if ($request->has('sample_file')) {
                $file_name = time() . '.' . $request->sample_file->getClientOriginalExtension();
                $path =   $request->sample_file->storeAs('files', $file_name, 's3');
                Storage::disk('s3')->setVisibility($path, 'public');
                $book->sample_file = $base_path . $path;
            }
        }
        $book->save();

        if ($request->file) {
            foreach ($request->file as $key => $file) {

                $bookContent = new BookContent();
                $file_name = time() . '.' . $file->getClientOriginalExtension();
                $path =   $file->storeAs('files', $file_name, 's3');
                Storage::disk('s3')->setVisibility($path, 'public');
                $bookContent->file = $base_path . $path;
                $bookContent->book_id = $book->id;
                $bookContent->book_name = $file->getClientOriginalName();
                if ($book->type == 2) {
                    $getID3 = new \JamesHeinrich\GetID3\GetID3;
                    $file = $getID3->analyze(@$request->podcast_file);
                    $duration = date('H:i:s', $file['playtime_seconds']);
                    list($hours, $minutes, $seconds) = explode(':', $duration);

                    // Calculate total duration in minutes
                    $total_minutes = $hours * 60 + $minutes;

                    // Construct the duration in the format MM:SS
                    $duration_minutes_seconds = sprintf("%02d:%02d", $total_minutes, $seconds);
                    $bookContent->file_duration = @$duration_minutes_seconds;
                }

                // $bookContent->file_duration = @$durations[$key]['minutes'] . ':' .  @$durations[$key]['seconds'];
                $bookContent->sequence = (int)$key;
                $book->type = $request->type;
                $bookContent->save();
            }
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

                $contentTag = ContentGlossary::firstOrCreate(['glossary_id' =>  $g, 'content_id' => $book->id, 'content_type' => $request->type]);
            }
        }



        if ($request->reference_file) {
            $reference = new Reference();
            $reference->type = $book->type;
            $reference->referal_id = $book->id;
            $reference->reference_type = $request->reference_type;
            if ($request->reference_file) {
                $book = Book::where('_id', $request->reference_file)->first();
                $reference->reference = $book->_id;
                $reference->reference_title = $book->title;
            }
            $reference->added_by = $this->user->id;
            $reference->save();
        }


        if ($request->type == 2) {
            return redirect()->to('book/' . $request->type . '/list/' . $book->_id)->with('msg', 'Content Saved Successfully!');
        } elseif ($request->type == 7) {
            return redirect()->to('podcast/edit/' . $book->_id);
        } else {
            return redirect()->to('books/' . $request->type)->with('msg', 'Content Saved Successfully!');
        }
    }

    public function edit(Request $request, $type, $id)
    {
        // if ($type == 7) {
        //     return redirect()->to('podcast/edit/' . $id);
        // }
        $categories = Category::active()->get();
        $book = Book::where('_id', $id)->with('content', 'author')->first();
        $contentTag = ContentTag::where('content_id', $id)->get();
        $tags = Tag::all();
        $suitbles = Suitable::all();
        $glossary = Glossory::all();
        $publisher = Publisher::all();
        $contentGlossary = ContentGlossary::where('content_id', $id)->get();
        $author = Author::where('type', '1')->get();
        $view = 'eBook.edit';
        if ($type == 7) {
            $view = 'eBook.podcast_edit';
        }
        return view($view, [
            'book' => $book,
            'type' => $type,
            'categories' => $categories,
            'tags' => $tags,
            'contentTags' =>  $contentTag,
            'suitbles' => $suitbles,
            'glossary' => $glossary,
            'contentGlossary' => $contentGlossary,
            'publisher' => $publisher,
            'author' => $author,
            'pending_for_approval' => $request->pending_for_approval,
            'approved' => $request->approved,
            'rejected_by_you' => $request->rejected_by_you
        ]);
    }

    public function update(Request $request)
    {

        ini_set('max_execution_time', '0');
        ini_set("memory_limit", "-1");
        // $client = new  Client('http://localhost:7700', '3bc7ba18215601c4de218ef53f0f90e830a7f144');

        $book = Book::where('_id', $request->id)->first();
        $book->title = $request->title;
        $book->description = $request->description;
        $book->inside = $request->inside;
        $base_path = 'https://trueilm.s3.eu-north-1.amazonaws.com/';

        if ($request->cover) {
            $file = $request->file('cover');
            $file_name = time() . '.' . $file->getClientOriginalExtension();
            $path =   $request->file('cover')->storeAs('files_covers', $file_name, 's3');
            Storage::disk('s3')->setVisibility($path, 'public');
            $book->image = $base_path . $path;
        }

        // $book->added_by = $this->user->id;
        $book->category_id = $request->category_id;
        $book->type = $request->type;
        $book->status =  $book->status;
        $book->approved =  $book->approved;
        $book->author_id = $request->author_id;
        $book->book_pages = $request->pages;
        $book->serial_no = $request->sr_no;
        $book->content_suitble = $request->suitble;
        $book->publisher_id = $request->publisher_id;
        $book->p_type = $request->pRadio;
        $book->age = $request->age;

        if ($request->pRadio == 0) {
            $book->price = 0;
        } else {
            $book->price = $request->price;
            if ($request->has('sample_file')) {
                $file_name = time() . '.' . $request->sample_file->getClientOriginalExtension();
                $path =   $request->sample_file->storeAs('files', $file_name, 's3');
                Storage::disk('s3')->setVisibility($path, 'public');
                $book->sample_file = $base_path . $path;
            }
        }
        $book->save();
        // if ($request->type == "1") {
        //     $bookIndex = $client->index('ebooks')->addDocuments(array($book), '_id');
        // } else  if ($request->type == "2") {
        //     $bookIndex = $client->index('audio')->addDocuments(array($book), '_id');
        // } else  if ($request->type == "3") {
        //     $bookIndex = $client->index('papers')->addDocuments(array($book), '_id');
        // } else  if ($request->type == "4") {
        //     $bookIndex = $client->index('podcast')->addDocuments(array($book), '_id');
        // }
        if ($request->file) {
            foreach ($request->file as $key => $file) {
                $duration = $request->duration;

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
                if ($book->type == 2) {
                    $getID3 = new \JamesHeinrich\GetID3\GetID3;
                    $file = $getID3->analyze(@$request->podcast_file);
                    $duration = date('H:i:s', $file['playtime_seconds']);
                    list($hours, $minutes, $seconds) = explode(':', $duration);

                    // Calculate total duration in minutes
                    $total_minutes = $hours * 60 + $minutes;

                    // Construct the duration in the format MM:SS
                    $duration_minutes_seconds = sprintf("%02d:%02d", $total_minutes, $seconds);
                    $bookContent->file_duration = @$duration_minutes_seconds;
                }
                // $bookContent->file_duration =    @$durations[$key]['minutes'] . ':' .  @$durations[$key]['seconds'];
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
        if ($request->type == 7 && $request->host) {
            foreach ($request->host as $key => $host) {
                $bookContent = new BookContent();

                $file_name = time() . '.' . $request->podcast_file[$key]->getClientOriginalExtension();
                $path =   $request->podcast_file[$key]->storeAs('files', $file_name, 's3');
                Storage::disk('s3')->setVisibility($path, 'public');
                $bookContent->file = $base_path . $path;
                $bookContent->title = $request->episode_title[$key];
                $bookContent->book_id = $book->id;
                $bookContent->book_name = $request->podcast_file[$key]->getClientOriginalName();
                $bookContent->sequence = (int)$key;
                $bookContent->host = $host;
                $bookContent->guest = @$request->guest[$key];
                $bookContent->file_duration = @$request->duration[$key];
                if ($request->podcast_file[$key]->getClientOriginalExtension() == 'mp3') {
                    $bookContent->type = 1;
                } else {
                    $bookContent->type = 2;
                }
                $bookContent->save();
            }
        }

        if ($request->reference_file) {
            $reference = new Reference();
            $reference->type = $book->type;
            $reference->referal_id = $book->id;
            $reference->reference_type = $request->reference_type;
            if ($request->reference_file) {
                $book = Book::where('_id', $request->reference_file)->first();
                $reference->reference = $book->_id;
                $reference->reference_title = $book->title;
            }
            $reference->added_by = $this->user->id;
            $reference->save();
        }

        if ($request->pending_for_approval == "true") {
            return redirect()->to('/book/pending-for-approval/' .  $book->type)->with('msg', 'Content Saved Successfully!');
        }
        if ($request->rejected_by_you == "true") {
            return redirect()->to('/book/rejected_by_you')->with('msg', 'Content Saved Successfully!');
        }
        if ($request->approved == "true") {
            return redirect()->to('/book/approved')->with('msg', 'Content Saved Successfully!');
        }
        if ($request->type == 7) {
            return redirect()->back();
        }
        if ($request->type == 2) {
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
    public function pendingForApprove($type)
    {
        return view('eBook.pending_index', [
            'type' => $type
        ]);
    }
    public function allPendingForApprovalBooks(Request $request)
    {
        $type = $request->type;
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $search = $request->search['value'];
        $totalBrands = Book::where('type', $type)->pendingApprove()->count();
        $brands = Book::where('type', $type)->pendingApprove()->with('author', 'user', 'approver', 'category')->when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%");
            });
        })->orderBy('created_at', 'desc')->skip((int) $start)->take((int) $length)->get();
        $brandsCount = Book::where('type', $type)->pendingApprove()->when($search, function ($q) use ($search) {
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
                'published_at' => Carbon::now('UTC')->format('Y-m-d\TH:i:s.uP')
            ]);

            // SendNotifications::dispatch($book->added_by, 'A new book has been uploaded to TrueILM.', 0);
            // SendNotifications::dispatch($book->added_by, 'Your Book Has Been Published Approved.', 1);
        }
        activity(1, $id, 1);
        indexing((int)$book->type, $book);

        return redirect()->back()->with('msg', 'Content Approved Successfully!');
    }

    public function rejectBook(Request $request, $id)
    {
        $book = Book::where('_id', $id)->first();
        $approved = 2;
        if ($book->approved == 0 || $book->approved == 1) {
            $book->update([
                'approved' => $approved,
                'approved_by' => $this->user->id,
                'reason' => $request->reason
            ]);

            // SendNotifications::dispatch($book->added_by, 'Your Book Has Rejected.', 1);
        }

        activity(2, $id, 1);
        return redirect()->back()->with('msg', 'Content Reject Successfully!');
    }

    public function list(Request $request, $type, $id)
    {
        $content = BookContent::where('book_id', $id)->orderBy('sequence', 'asc')->get();
        return view('eBook.book_list', [
            'book_id' => $id,
            'content' => $content,
            'pending_for_approval' => $request->pending_for_approval
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
        if ($request->pending_for_approval == "true") {
            return redirect()->to('/book/pending-for-approval')->with('msg', 'Content Saved Successfully!');
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

            $query->where('added_by', $user_id);
        })->count();
        $brands = Book::rejected()->with('author', 'user', 'approver', 'category')->when($user_id, function ($query) use ($user_id) {
            $query->where('added_by', $user_id);
        })->when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%");
            });
        })->orderBy('created_at', 'desc')->skip((int) $start)->take((int) $length)->get();
        $brandsCount = Book::rejected()->when($user_id, function ($query) use ($user_id) {
            $query->where('added_by', $user_id);
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
            $query->where('added_by', $user_id);
        })->when($request->e_date, function ($query) use ($request) {
            $query->whereBetween('created_at', [new Carbon($request->s_date),  new Carbon($request->e_date)]);
        })->when('approved', (int) $request->approved)->when($request->uncategorized, function ($query) {
            $query->where('category_id', null);
        })->with('author', 'category')->orderBy('created_at', 'desc')->get();
        $books->map(function ($b) {
            $b->numberOfUser = $b->totalUserReadThisBook();
            return $b;
        });
        // return $request->approved;
        return view('eBook.index', [
            'type' => $request->type,
            'approved' => $request->approved,
            'uncategorized' => $request->uncategorized,
            'hidden_table' => 1,
            'books' => $books,
            's_date' => $request->s_date,
            'e_date' => $request->e_date
        ]);
    }
    public function approved()
    {
        return view('eBook.approved', [
            'type' => Session::get('type')
        ]);
    }
    public function allApprovedBooks(Request $request)
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
        })->count();
        $brands = Book::approved()->when($user_id, function ($query) use ($user_id) {
        })->when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%");
            });
        })->with('author', 'user', 'approver', 'category')->orderBy('created_at', 'desc')->skip((int) $start)->take((int) $length)->get();
        $brandsCount = Book::approved()->when($user_id, function ($query) use ($user_id) {
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


    public function adminRejected()
    {

        return view('eBook.admin_rejected', [
            'type' => Session::get('type')
        ]);
    }
    public function allAdminRejectedBooks(Request $request)
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
        })->count();
        $brands = Book::rejected()->with('author', 'user', 'approver')->when($user_id, function ($query) use ($user_id) {
        })->when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%");
            });
        })->with('author', 'user', 'approver', 'category')->orderBy('created_at', 'desc')->skip((int) $start)->take((int) $length)->get();
        $brandsCount = Book::rejected()->when($user_id, function ($query) use ($user_id) {
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

    public function podcastEdit($id)
    {
        $book = Book::where('_id', $id)->with('content')->first();
        $categories = Category::active()->get();
        $contentTag = ContentTag::where('content_id', $id)->get();
        $tags = Tag::all();
        $suitbles = Suitable::all();
        $glossary = Glossory::all();
        $publisher = Publisher::all();
        $contentGlossary = ContentGlossary::where('content_id', $id)->get();
        $author = Author::where('type', '1')->get();
        return view('eBook.podcast_edit', [
            'book' => $book,
            'type' => $book->type,
            'categories' => $categories,
            'tags' => $tags,
            'contentTags' =>  $contentTag,
            'suitbles' => $suitbles,
            'glossary' => $glossary,
            'contentGlossary' => $contentGlossary,
            'publisher' => $publisher,
            'author' => $author
        ]);
    }
    public function podcastEpisode(Request $request)
    {
        $book = Book::where('_id', $request->podcast_id)->first();

        $base_path = 'https://trueilm.s3.eu-north-1.amazonaws.com/';
        if ($request->episode_id) {
            $bookContent = BookContent::where('_id', $request->episode_id)->first();
        } else {

            $bookContent = new BookContent();
        }
        if ($request->podcast_file) {
            $file_name = time() . '.' . $request->podcast_file->getClientOriginalExtension();
            $path =   $request->podcast_file->storeAs('files', $file_name, 's3');
            Storage::disk('s3')->setVisibility($path, 'public');
            $bookContent->file = $base_path . $path;
            if ($request->podcast_file->getClientOriginalExtension() == 'mp3') {
                $bookContent->type = 1;
            } else {
                $bookContent->type = 2;
            }
            $bookContent->book_name = $request->podcast_file->getClientOriginalName();
            $getID3 = new \JamesHeinrich\GetID3\GetID3;
            $file = $getID3->analyze(@$request->podcast_file);
            $duration = date('H:i:s', $file['playtime_seconds']);
            list($hours, $minutes, $seconds) = explode(':', $duration);

            // Calculate total duration in minutes
            $total_minutes = $hours * 60 + $minutes;

            // Construct the duration in the format MM:SS
            $duration_minutes_seconds = sprintf("%02d:%02d", $total_minutes, $seconds);
            $bookContent->file_duration = @$duration_minutes_seconds;
        }


        $bookContent->book_id = $book->_id;
        $bookContent->title = $request->episode_title;
        $bookContent->host = $request->host;
        $bookContent->description = $request->episode_description;
        $bookContent->guest = $request->guest;
        $bookContent->sequence = (int)@$request->sequence ?? 0;
        $bookContent->hls_conversion = 0;

        $bookContent->save();
        if ($book->approved == 1) {
            indexing(7, $book);
        }
        return redirect()->back()->with('msg', 'Episode Saved !');
    }
    public function  podcastBulkEpisode(Request $request)
    {
        // return $request->all();
        $book = Book::where('_id', $request->podcast_id)->first();

        $base_path = 'https://trueilm.s3.eu-north-1.amazonaws.com/';

        if ($request->podcast_file) {
            foreach ($request->podcast_file as $file) {

                $bookContent = new BookContent();
                $file_name = time() . '.' . $file->getClientOriginalExtension();
                $path =   $file->storeAs('files', $file_name, 's3');
                Storage::disk('s3')->setVisibility($path, 'public');
                $bookContent->file = $base_path . $path;
                if ($file->getClientOriginalExtension() == 'mp3') {
                    $bookContent->type = 1;
                } else {
                    $bookContent->type = 2;
                }
                $bookContent->book_name = $file->getClientOriginalName();

                $bookContent->book_id = $book->_id;
                $bookContent->title = \Str::beforelast($bookContent->book_name, '.');
                $getID3 = new \JamesHeinrich\GetID3\GetID3;
                $file = $getID3->analyze(@$file);
                $duration = date('H:i:s', $file['playtime_seconds']);
                list($hours, $minutes, $seconds) = explode(':', $duration);

                // Calculate total duration in minutes
                $total_minutes = $hours * 60 + $minutes;

                // Construct the duration in the format MM:SS
                $duration_minutes_seconds = sprintf("%02d:%02d", $total_minutes, $seconds);
                $bookContent->file_duration = @$duration_minutes_seconds;
                $bookContent->hls_conversion = 0;

                $bookContent->save();
            }
        }

        if ($book->approved == 1) {
            indexing(7, $book);
        }
        return redirect()->back()->with('msg', 'Episode Saved !');
    }
    public function deleteAudioChapter($id)
    {
        $bookContent = BookContent::where('_id', $id)->delete();

        return redirect()->back()->with('msg', 'Chapter Deleted!');
    }
    public function updateChapterName(Request $request)
    {
        $boookContent = BookContent::where('_id', $request->content_id)->update(['book_name' => $request->name]);

        return 'updated';
    }
    public function addAudioChapter(Request $request)
    {
        if ($request->file) {
            $base_path = 'https://trueilm.s3.eu-north-1.amazonaws.com/';
            foreach ($request->file as $key => $file) {
                $count = BookContent::where('book_id', $request->book_id)->count();
                $seq = $count + $key;

                $bookContent = new BookContent();
                $file_name = time() . '.' . $file->getClientOriginalExtension();
                $path =   $file->storeAs('files', $file_name, 's3');
                Storage::disk('s3')->setVisibility($path, 'public');
                $bookContent->file = $base_path . $path;
                $bookContent->book_id = $request->book_id;
                $bookContent->book_name = $file->getClientOriginalName();
                $getID3 = new \JamesHeinrich\GetID3\GetID3;
                $file = $getID3->analyze(@$file);
                $duration = date('i:s', $file['playtime_seconds']);
                $bookContent->file_duration = @$duration;
                // $bookContent->file_duration =    @$durations[$key]['minutes'] . ':' .  @$durations[$key]['seconds'];
                $bookContent->sequence = (int)$seq;
                $bookContent->save();
            }
        }

        return redirect()->back()->with('msg', 'Chapter Added!');
    }
}
