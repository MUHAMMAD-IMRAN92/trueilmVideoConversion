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
        $totalBrands = Grant::where('approved', 0)->count();
        $brands = Grant::where('approved', 0)->when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%");
            });
        })->orderBy('created_at', 'desc')->skip((int) $start)->take((int) $length)->get();
        $brandsCount = Grant::where('approved', 0)->skip((int) $start)->take((int) $length)->count();

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
        $grant = Grant::where('_id', $id)->first();
        $approved = 2;
        if ($grant->approved == 0) {
            $grant->update([
                'approved' => $approved,
                'approved_by' => $this->user->id,
                'reason' => $request->reason
            ]);
        }


        return redirect()->back()->with('msg', 'Grant Reject Successfully!');
    }
    public function rejected()
    {
        return view('grant.rejected');
    }

    public function allRejectedGrants(Request $request)
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
        $totalBrands = Grant::rejected()->count();
        $brands = Grant::rejected()->when($user_id, function ($query) use ($user_id) {
            $query->where('approved_by', $user_id);
        })->when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%");
            });
        })->skip((int) $start)->take((int) $length)->get();
        $brandsCount = Grant::rejected()->when($user_id, function ($query) use ($user_id) {
            $query->where('approved_by', $user_id);
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
    public function approved()

    {
        return view('grant.approved');
    }

    public function allApprovedGrants(Request $request)
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
        $totalBrands = Grant::approved()->when($user_id, function ($query) use ($user_id) {
            $query->where('approved_by', $user_id);
        })->count();
        $brands = Grant::approved()->when($user_id, function ($query) use ($user_id) {
            $query->where('approved_by', $user_id);
        })->when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%");
            });
        })->skip((int) $start)->take((int) $length)->get();
        $brandsCount = Grant::approved()->when($user_id, function ($query) use ($user_id) {
            $query->where('approved_by', $user_id);
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

    public function viewBook($id)
    {
        $grant = Grant::where('_id', $id)->first();
        return view('grant.view_book', [
            'file' => $grant->file,
            'user_id' => $this->user->id
        ]);
    }
    public function approveGrant($id)
    {
        $grant = Grant::where('_id', $id)->first();
        $approved = 1;

        if ($grant->approved = 0 || $grant->approved = 2) {
            $grant->update([
                'approved' => $approved,
                'approved_by' => $this->user->id,
            ]);
        }
        return redirect()->back()->with('msg', 'Grant Approved Successfully!');
    }
}
