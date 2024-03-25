<?php

namespace App\Http\Controllers;

use App\Jobs\SendNotifications;
use App\Models\AdditionalReview;
use App\Models\ReviewBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewBookController extends Controller
{
    public $user;
    public $type;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }
    public function index()
    {
        return view('review_book.index');
    }
    public function allReview(Request $request)
    {

        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $search = $request->search['value'];
        $totalBrands = ReviewBook::count();
        $brands = ReviewBook::with('user', 'reviewer')->when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%");
            });
        })->orderBy('created_at', 'desc')->skip((int) $start)->take((int) $length)->get();
        $brandsCount = ReviewBook::when($search, function ($q) use ($search) {
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
    public function create($id)
    {
        $reviewBook =   ReviewBook::where('_id', $id)->first();

        return view('review_book.add', [
            'reviewBook' => $reviewBook
        ]);
    }
    public function store(Request $request)
    {
        $reviewBook =   ReviewBook::where('_id', $request->id)->first();

        $reviewBook->review_description = $request->review_description;
        $reviewBook->rating = $request->rating;
        $reviewBook->reviwed_by = $this->user->id;
        $reviewBook->status = 1;

        $reviewBook->save();
        // SendNotifications::dispatch($reviewBook->user_id, 'Your Book has been reviewed', 1);

        return redirect()->to('/review')->with('msg', 'Review Saved!');
    }
    public function viewBook($id)
    {
        $grant = ReviewBook::where('_id', $id)->first();
        return view('grant.view_book', [
            'file' => $grant->file,
            'user_id' => $this->user->id
        ]);
    }
    public function allAddtionaReview()
    {
        return view('review_book.addition_review');
    }
    public function allBookAddtionaReview(Request $request)
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
        $totalBrands = AdditionalReview::count();
        $brands = AdditionalReview::when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('bookTitle', 'like', "%$search%");
            });
        })->orderBy('created_at', 'desc')->skip((int) $start)->take((int) $length)->get();
        $brandsCount = AdditionalReview::when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('bookTitle', 'like', "%$search%");
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
    public function  additionApprove($id)
    {
        $addition = AdditionalReview::where('_id', $id)->first();

        if ($addition) {
            $addition->status = 1;
            $addition->save();
        }
        return redirect()->back()->with('msg', 'Review Approved !');
    }
    public function  additionReject($id)
    {
        $addition = AdditionalReview::where('_id', $id)->first();

        if ($addition) {
            $addition->status = 2;
            $addition->save();
        }
        return redirect()->back()->with('msg', 'Review Rejected !');
    }
}
