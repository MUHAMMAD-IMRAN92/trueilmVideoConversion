<?php

namespace App\Http\Controllers;

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
        $brands = ReviewBook::when($search, function ($q) use ($search) {
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

        return redirect()->to('/review')->with('msg', 'Review Saved!');
    }
}
