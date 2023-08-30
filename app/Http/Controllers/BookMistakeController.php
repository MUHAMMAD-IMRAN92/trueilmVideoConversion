<?php

namespace App\Http\Controllers;

use App\Models\BookMistake;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookMistakeController extends Controller
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
        return view('book_mistake.index');
    }
    public function allMistakes(Request $request)
    {

        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $search = $request->search['value'];
        $totalBrands = BookMistake::with('book')->where('status', 0)->count();

        $brands = BookMistake::with('book')->where('status', 0)->when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%");
            });
        })->orderBy('created_at', 'desc')->skip((int) $start)->take((int) $length)->get();
        $brandsCount = BookMistake::with('book')->where('status', 0)->when($search, function ($q) use ($search) {
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
    public function understood($id)
    {
        $reviewBook =   BookMistake::where('_id', $id)->first();
        $reviewBook->status = 1;
        $reviewBook->save();
        return redirect()->back()->with('msg', 'Sucessfully Done!');
    }
}
