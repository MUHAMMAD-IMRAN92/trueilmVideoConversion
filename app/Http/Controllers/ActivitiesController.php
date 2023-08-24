<?php

namespace App\Http\Controllers;

use App\Models\Activities;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivitiesController extends Controller
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

        return view('activity.index');
    }
    public function allActivities(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $search = $request->search['value'];
        $totalBrands = Activities::where('status', 0)->count();
        $brands = Activities::where('status', 0)->skip((int) $start)->take((int) $length)->get();
        $brandsCount = Activities::where('status', 0)->skip((int) $start)->take((int) $length)->count();

        $data = array(
            'draw' => $draw,
            'recordsTotal' => $totalBrands,
            'recordsFiltered' => $brandsCount,
            'data' => $brands,
        );
        return json_encode($data);
    }
    function updateStatusActivity($id, $activity_id)
    {
        $book = Book::where('_id', $id)->first();
        $status = $book->status == 1 ? 0 : 1;

        $book->update([
            'status' => $status
        ]);

        $activity = Activities::where('_id', $activity_id)->first();
        $activity->status = 1;
        $activity->save();
        return redirect()->back();
    }
    public function revert($id, $activity_id)
    {
        $book = Book::where('_id', $id)->first();
        $approved = 0;
        if ($book) {
            $book->update([
                'approved' => $approved,
                'approved_by' => '',
            ]);
        }
        $activity = Activities::where('_id', $activity_id)->first();
        $activity->status = 1;
        $activity->save();
        return redirect()->back()->with('msg', 'Reverted Sucessfully!');
    }
}
