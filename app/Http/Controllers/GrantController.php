<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Grant;

class GrantController extends Controller
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
        return view('grant.index');
    }
    public function allgrants(Request $request)
    {

        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $search = $request->search['value'];
        $totalBrands = Grant::where('status' , 0)->count();
        $brands = Grant::where('status' , 0)->when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%");
            });
        })->skip((int) $start)->take((int) $length)->get();
        $brandsCount = Grant::where('status' , 0)->skip((int) $start)->take((int) $length)->count();

        $data = array(
            'draw' => $draw,
            'recordsTotal' => $totalBrands,
            'recordsFiltered' => $brandsCount,
            'data' => $brands,
        );
        return json_encode($data);
    }
    public function rejectGrant(Request $request, $id)
    {
        $book = Grant::where('_id', $id)->first();
        $approved = 2;

        $book->update([
            'status' => $approved,
            'reason' => $request->reason
        ]);

        return redirect()->back()->with('msg', 'Grant Reject Successfully!');
    }
    public function rejected()
    {
        return view('grant.rejected');
    }

    public function allRejectedGrants(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $search = $request->search['value'];
        $totalBrands = Grant::rejected()->count();
        $brands = Grant::rejected()->when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%");
            });
        })->skip((int) $start)->take((int) $length)->get();
        $brandsCount = Grant::rejected()->when($search, function ($q) use ($search) {
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
    public function approved()
    {
        return view('grant.approved');
    }

    public function allApprovedGrants(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $search = $request->search['value'];
        $totalBrands = Grant::approved()->count();
        $brands = Grant::approved()->when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%");
            });
        })->skip((int) $start)->take((int) $length)->get();
        $brandsCount = Grant::approved()->when($search, function ($q) use ($search) {
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
        return view('grant.view_book', [
            'book_id' => $book_id,
            'user_id' => $this->user->id
        ]);
    }
    public function approveGrant($id)
    {
        $grant = Grant::where('_id', $id)->first();
        $approved = 1;

        $grant->update([
            'status' => $approved
        ]);

        return redirect()->back()->with('msg', 'Grant Approved Successfully!');
    }

}
