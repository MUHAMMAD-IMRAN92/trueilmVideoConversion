<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Coupon;
use Stripe\Stripe;

class CouponController extends Controller
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
        return view('coupon.index');
    }
    public function allcoupon(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $search = $request->search['value'];
        $totalBrands = Coupon::count();
        $brands = Coupon::when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%");
            });
        })->orderBy('created_at', 'desc')->skip((int) $start)->take((int) $length)->get();
        $brandsCount = Coupon::when($search, function ($q) use ($search) {
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
    public function add()
    {
        return view('coupon.add');
    }
    public function store(Request $request)
    {
        try {
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
            Stripe::setApiKey(env('STRIPE_SECRET'));
            // create coupon
            $coupon = $stripe->coupons->create([
                'id' =>  str_replace(' ', '', $request->coupon),
                'percent_off' => $request->percentage,
                'duration' => 'once',
                'redeem_by' => strtotime($request->end_date)
            ]);

            $coupon = new Coupon();
            $coupon->title = $request->title;
            $coupon->description = $request->description;
            $coupon->coupon =   str_replace(' ', '', $request->coupon);
            $coupon->percentage = $request->percentage;
            $coupon->end_date = $request->end_date;
            $coupon->status = 1;
            $coupon->added_by = $this->user->id;
            $coupon->save();
            // Connect to your stripe account

            $pCode =  $stripe->promotionCodes->create(['coupon' =>  $coupon->coupon]);
            $coupon->p_code = $pCode->code;
            $coupon->save();
            return redirect()->to('/coupon')->with('msg', 'Coupon Saved Successfully!');
        } catch (\Exception $e) {
            return $e->getMessage();
            return redirect()->to('/coupon')->with('dmsg', 'SomeThing Went Wrong!');
        }
    }

    public function delete($id)
    {
        try {
            $coupon = Coupon::where('_id', $id)->first();
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
            Stripe::setApiKey(env('STRIPE_SECRET'));
            $stripe->coupons->delete($coupon->coupon, []);
            Coupon::where('_id', $id)->delete();
            return redirect()->to('/coupon')->with('msg', 'Coupon Deleted Successfully!');
        } catch (\Exception $e) {

            return redirect()->to('/coupon')->with('dmsg', 'Coupon Not Found!');
        }
    }
}
