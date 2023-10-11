<?php

namespace App\Http\Controllers;

use App\Jobs\SendNotifications;
use App\Models\Support;
use App\Models\SupportDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportController extends Controller
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

        return view('support.index');
    }
    public function allSupport(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $search = $request->search['value'];
        $totalBrands = Support::whereIn('status', [0, 1])->count();
        $brands = Support::whereIn('status', [0, 1])->when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%");
            });
        })->with('user')->skip((int) $start)->take((int) $length)->get();
        $brandsCount = Support::whereIn('status', [0, 1])->when($search, function ($q) use ($search) {
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
    public function details($id)
    {
        $support = Support::where('_id', $id)->first();
        $supportDetail = SupportDetails::where('support_id', $id)->get();
        return view('support.detail', [
            'supportDetails' => $supportDetail,
            'support' => $support
        ]);
    }
    public function reply(Request $request)
    {
        $supportDetail =  new SupportDetails();
        $supportDetail->description = $request->description;
        $supportDetail->support_id = $request->support_id;
        $supportDetail->user_id = $this->user->_id;
        $supportDetail->author = $this->user->name;
        $supportDetail->save();

        $support = Support::where('_id', $request->support_id)->first();
        if ($support) {
            $support->status = 1;
            $support->save();
        }
        SendNotifications::dispatch($support->support, 'Your have a message in support', 0);

        return redirect()->back()->with('msg', 'Response Sent!');
    }
    public function approveSupport($id)
    {
        $support = Support::where('_id', $id)->first();
        if ($support) {
            $support->status = 2;
            $support->save();
        }
        return redirect()->back()->with('msg', 'Support Marked As Read!');
    }
}
