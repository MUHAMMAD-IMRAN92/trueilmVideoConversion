<?php

namespace App\Http\Controllers;

use App\Models\Glossory;
use App\Models\GlossoryAttribute;
use App\Models\Notification;
use App\Models\Popup;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $notification->sent_by = $this->user->_id;
        $notification->save();
        \OneSignal::sendNotificationToAll(
            $request->notification,
            null,
            null,
            null,
            null,
            null,
            $request->heading,
            null
        );
        // $userId = ['ccec9dfe-2cc2-48ab-920e-9c6be75ff315'];
        // \OneSignal::sendNotificationToUser(
        //     $request->notification,
        //     $userId,
        //     null,
        //     null,
        //     null,
        //     null,
        //     $request->heading,
        //     "Custom subtitle"
        // );
        return redirect()->to('/notification')->with('msg', 'Notification Saved Successfully!');
    }
    public function popupIndex()
    {
        return view('popup.index');
    }
    public function allPopup(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $search = $request->search['value'];
        $totalBrands = Popup::count();
        $brands = Popup::when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%");
            });
        })->orderBy('created_at', 'desc')->skip((int) $start)->take((int) $length)->get();
        $brandsCount = Popup::when($search, function ($q) use ($search) {
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
    public function addPopup()
    {
        return view('popup.add');
    }
    public function storePopup(Request $request)
    {
        $base_path = 'https://trueilm.s3.eu-north-1.amazonaws.com/';

        $popup = new Popup();
        $popup->title = $request->title;
        $popup->text = $request->text;
        $popup->type = $request->type;
        $popup->device = $request->device;
        $popup->link = $request->link;
        $popup->start =  $request->start;
        $popup->interval =  $request->interval;
        $popup->button_text =  $request->button_text;
        $popup->plan =  $request->plan;
        $popup->added_by = $this->user->_id;
        if ($popup->type == 1) {
            $count =   Popup::where('device', $request->device)->where('type', $popup->type)->count();
            $popup->key = 'E' . $count + 1;
        } else {
            $count =   Popup::where('device', $request->device)->where('type', $popup->type)->count();
            $popup->key = 'S' . $count + 1;
        }
        if ($request->image) {
            $file = $request->file('image');
            $file_name = time() . '.' . $file->getClientOriginalExtension();
            $path =   $request->file('image')->storeAs('popup_images', $file_name, 's3');
            Storage::disk('s3')->setVisibility($path, 'public');
            $popup->image = $base_path . $path;
        }
        $popup->save();

        return redirect()->to('/popups')->with('msg', 'Popup Saved Successfully!');
    }
    public function editPopup($id)
    {
        $popup = Popup::where('_id', $id)->first();
        return view('popup.edit', [
            'popup' => $popup
        ]);
    }
    public function updatePopup(Request $request)
    {
        $popup = Popup::where('_id', $request->id)->first();
        if ($popup) {
            $base_path = 'https://trueilm.s3.eu-north-1.amazonaws.com/';

            $popup->title = $request->title;
            $popup->text = $request->text;
            $popup->type = $request->type;
            $popup->device = $request->device;
            $popup->link = $request->link;
            $popup->start =  $request->start;
            $popup->interval =  $request->interval;
            $popup->added_by = $this->user->_id;
            $popup->plan =  $request->plan;

            if ($request->image) {
                $file = $request->file('image');
                $file_name = time() . '.' . $file->getClientOriginalExtension();
                $path =   $request->file('image')->storeAs('popup_images', $file_name, 's3');
                Storage::disk('s3')->setVisibility($path, 'public');
                $popup->image = $base_path . $path;
            }
            $popup->save();
        }

        return redirect()->to('/popups')->with('msg', 'Popup Updated Successfully!');
    }
    public function popupStatusUpdate($id)
    {
        $popup = Popup::where('_id', $id)->first();
        if ($popup) {
            $status = $popup->status == 1 ? 0 : 1;

            $popup->update([
                'status' => $status
            ]);
        }

        return redirect()->back()->with('msg', 'Grant Reverted Successfully!');
    }
}
