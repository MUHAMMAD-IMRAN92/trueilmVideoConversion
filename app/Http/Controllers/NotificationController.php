<?php

namespace App\Http\Controllers;

use App\Models\Glossory;
use App\Models\GlossoryAttribute;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class NotificationController extends Controller
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
        return view('notifications.index');
    }
    public function allNotifications(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $search = $request->search['value'];
        $totalBrands = Notification::count();
        $brands = Notification::when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('heading', 'like', "%$search%");
            });
        })->orderBy('created_at', 'desc')->skip((int) $start)->take((int) $length)->get();
        $brandsCount = Notification::when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('heading', 'like', "%$search%");
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
    public function add()
    {
        return view('notifications.add');
    }
    public function store(Request $request)
    {
        $notification = new Notification();
        $notification->heading = $request->heading;
        $notification->notification = $request->notification;
        $notification->is_read = 0;
        $notification->send_to = 0;
        $notification->type = 0;
        $notification->save();
        $data = [
            'headings' => ['en' => $request->heading],
        ];
        \OneSignal::sendNotificationToAll(
            $request->notification,
            $url = null,
            $data,
            $buttons = null,
            $schedule = null,
        );
        return redirect()->to('/notification')->with('msg', 'Notification Saved Successfully!');
    }
}
