<?php

namespace App\Http\Controllers;

use App\Models\Comments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
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
        return view('comment.index');
    }
    public function allComments(Request $request)
    {

        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $search = $request->search['value'];
        $totalBrands = Comments::with('book')->where('approved', 0)->count();

        $brands = Comments::with('book')->where('approved', 0)->when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('comment', 'like', "%$search%");
            });
        })->orderBy('created_at', 'desc')->skip((int) $start)->take((int) $length)->get();
        $brandsCount = Comments::with('book')->where('approved', 0)->when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('comment', 'like', "%$search%");
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
    public function approved($id)
    {
        $reviewBook =   Comments::where('_id', $id)->first();
        $reviewBook->approved = 1;
        $reviewBook->approved_by = $this->user->_id;
        $reviewBook->save();
        return redirect()->back()->with('msg', 'Sucessfully Done!');
    }
    public function reject($id)
    {
        $reviewBook =   Comments::where('_id', $id)->first();
        $reviewBook->approved = 2;
        $reviewBook->approved_by = $this->user->_id;
        $reviewBook->save();
        return redirect()->back()->with('msg', 'Sucessfully Done!');
    }
}
