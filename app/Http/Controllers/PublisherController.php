<?php

namespace App\Http\Controllers;

use App\Http\Requests\PublisherRequest;
use App\Models\Book;
use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PublisherController extends Controller
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

        return view('publisher.index');
    }
    public function allPublisher(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $search = $request->search['value'];
        $totalBrands = Publisher::count();
        $brands = Publisher::when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%");
            });
        })->orderBy('created_at', 'desc')->skip((int) $start)->take((int) $length)->get();
        $brandsCount = Publisher::when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%");
            });
        })->skip((int) $start)->take((int) $length)->count();
        $brands = $brands->map(function ($p) {
            $sum = 0;
            $book = Book::where('publisher_id', $p->_id)->get();

            $book->each(function ($b) use ($p, $sum) {
                $sum += $b->sum('type');
            });
            $p->readPages  = $sum;
            return $p;
        });

        $data = array(
            'draw' => $draw,
            'recordsTotal' => $totalBrands,
            'recordsFiltered' => $brandsCount,
            'data' => $brands,
        );
        return json_encode($data);
    }
    public function add()
    {
        return view('publisher.add');
    }
    public function store(PublisherRequest $request)
    {
        $publisher = new Publisher();
        $publisher->name = $request->name;
        $publisher->description = $request->description;
        $publisher->added_by = $this->user->id;
        $publisher->save();

        return redirect()->to('/publisher')->with('msg', 'Publisher Saved Successfully!');
    }

    public function edit($id)
    {
        $publisher = Publisher::where('_id', $id)->first();
        return view('publisher.edit', [
            'publisher' => $publisher
        ]);
    }

    public function update(PublisherRequest $request)
    {
        $publisher = Publisher::where('_id', $request->id)->first();
        $publisher->name = $request->name;
        $publisher->description = $request->description;
        $publisher->added_by = $this->user->id;
        $publisher->save();

        return redirect()->to('/publisher')->with('msg', 'Publisher Updated Successfully!');;
    }
    public function publisherBookReadingDetail(Request $request, $id)
    {
        $bookRead = Book::where('publisher_id', $id)->whereHas('bookTraking', function ($q) use ($id, $request) {
            $q->when($request->e_date, function ($q) use ($request) {
                $q->whereBetween('createdAt', [new Carbon($request->s_date),  new Carbon($request->e_date)]);
            });
        })->with('bookTraking')->paginate(10);

        return view('publisher.publisher_book_details', [
            'book_read' => $bookRead,
            'user_id' => $id,
            's_date' => $request->s_date,
            'e_date' => $request->e_date
        ]);
    }
}
