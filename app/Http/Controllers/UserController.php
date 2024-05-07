<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Imports\InstituteUserImport;
use App\Imports\UsersImport;
use App\Models\Book;
use App\Models\BookLastSeen;
use App\Models\BookTranking;
use App\Models\Course;
use App\Models\InstitueUser;
use App\Models\Subscription;
use App\Models\User;
use App\Models\UserSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maklad\Permission\Models\Role;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use \Stripe\Plan;

class UserController extends Controller
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
        return view('user.index');
    }
    public function allUser(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $search = $request->search['value'];
        $totalBrands = User::whereNull('deleted_at')->whereNotNull('type')->count();
        $brands = User::whereNull('deleted_at')->whereNotNull('type')->when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")->orWhere('email', 'like',  "%$search%");
            });
        })->orderBy('created_at', 'desc')->skip((int) $start)->take((int) $length)->get();
        $brandsCount = User::whereNull('deleted_at')->whereNotNull('type')->when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")->orWhere('email', 'like',  "%$search%");;
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
        if (auth()->user()->hasRole('Super Admin')) {
            $roles = Role::all();
        } else {
            $roles = Role::whereIn('name', ['Admin', 'Publisher', 'Institute'])->get();
        }

        return view('user.add', [
            'roles' => $roles
        ]);
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'unique:users,email,except,_id'
        ]);

        $type = 0;
        if ($request->role == 'Admin') {
            $type = 1;
        } elseif ($request->role == 'Publisher') {
            $type = 2;
        } else if ($request->role == 'Institute') {
            $type = 3;
        } else {
            $type = 4;
        }
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = Hash::make($request->password);
        $user->added_by = $this->user->id;
        $user->type = $type;
        if ($type == 3 &&  $request->institute_type == 1) {
            $user->seats = $request->seats;
            $user->expiry_date  =  Carbon::parse($request->expiry_date)->setTimezone('UTC')->format('Y-m-d\TH:i:s.uP');
            $user->institute_type = $request->institute_type;
        }
        $user->save();
        if ($user && $type == 3 && $request->institute_type == 2) {
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
            // $monthlyProduct =  $stripe->products->create(['name' => $request->monthly_plan_title]);
            // if ($monthlyProduct) {
            //     $price =  $stripe->plans->create([
            //         "amount" =>  $request->monthly_amount * 100,
            //         "interval" => 'month',
            //         "currency" => "usd",
            //         "product" => @$monthlyProduct->id
            //     ]);

            //     $subscription  = new Subscription();
            //     $subscription->price_id  = $price->id;
            //     $subscription->product_id  = $monthlyProduct->id;
            //     $subscription->price  = $request->monthly_amount;
            //     $subscription->product_title  = $request->monthly_plan_title;
            //     $subscription->institue_id  = $user->_id;
            //     $subscription->plan_type  = 4;
            //     $subscription->type = 1;
            //     $subscription->status  = 1;
            //     $subscription->save();
            // }
            $yearlyProduct =  $stripe->products->create(['name' => $request->yearly_plan_title]);
            if ($yearlyProduct) {
                $price =  $stripe->plans->create([
                    "amount" =>  $request->price * 100,
                    "interval" => 'year',
                    "currency" => "usd",
                    "product" => @$yearlyProduct->id
                ]);

                $subscription  = new Subscription();
                $subscription->price_id  = $price->id;
                $subscription->product_id  = $yearlyProduct->id;
                $subscription->price  = $request->price;
                $subscription->product_title  = $request->yearly_plan_title;
                $subscription->institue_id  = $user->_id;
                $subscription->plan_type  = 4;
                $subscription->status  = 1;
                $subscription->type = 2;

                $subscription->save();
            }
        } elseif ($type == 3  && $request->institute_type == 1) {
            $subscription  = new Subscription();
            $subscription->price  = 0;
            $subscription->product_title  = $user->name . ' Freemium';
            $subscription->institue_id  = $user->_id;
            $subscription->plan_type  = 4;
            $subscription->status  = 1;
            $subscription->type = 0;
            $subscription->expiry_date  =  Carbon::parse($request->expiry_date)->setTimezone('UTC')->format('Y-m-d\TH:i:s.uP');
            $subscription->save();
        }
        $user->assignRole($request->input('role'));

        return redirect()->to('/user-management')->with('msg', 'User Saved Successfully!');;
    }

    public function edit($id)
    {
        $user = User::where('_id', $id)->first();
        $roles = Role::all();
        // $plan = [];
        // if ($user->type == 3 && $user->institute_tpye == 2) {
        //     $plan = [];

        // }
        $instituteSubscription = Subscription::where('institue_id',  $id)->where('type', 2)->first();

        return view('user.edit', [
            'user' => $user,
            'roles' => $roles,
            'instituteSubscription' => $instituteSubscription
        ]);
    }

    public function update(Request $request)
    {
        $type = 0;
        if ($request->role == 'Admin') {
            $type = 1;
        } elseif ($request->role == 'Publisher') {
            $type = 2;
        } else if ($request->role == 'Institute') {
            $type = 3;
        } else {
            $type = 4;
        }
        $user = User::where('_id', $request->id)->first();
        if ($user) {

            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->added_by = $this->user->id;
            $user->type = $type;

            if ($type == 3) {
                $user->seats = $request->seats;
                $user->expiry_date  =  Carbon::parse($request->expiry_date)->setTimezone('UTC')->format('Y-m-d\TH:i:s.uP');
                $user->institute_type = $request->institute_type;
            }
            $user->save();
            if ($type == 3 && $request->institute_type == 2) {
                $instituteSubscription = Subscription::where('institue_id',  $request->id)->where('type', 2)->first();

                if ($instituteSubscription->price != $request->price) {
                    $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
                    $newPrice =   $stripe->prices->create([
                        'product' => $instituteSubscription->product_id,
                        'unit_amount' => $request->price * 100, // New price amount in cents ($15)
                        'currency' => 'usd', // Currency code (e.g., USD)
                        'recurring' => [
                            'interval' => 'year', // Specify the billing interval (e.g., month)
                        ],
                    ]);

                    $stripe->prices->update(
                        $instituteSubscription->price_id,
                        ['active' => false]
                    );
                    $instituteSubscription->price = $request->price;
                    $instituteSubscription->price_id = $$newPrice->id;
                    $instituteSubscription->save();
                }
            }
            return redirect()->to('/user-management')->with('msg', 'User Updated Successfully!');;
        } else {
            return redirect()->to('/user-management')->with('dmsg', 'User Not Found !');;
        }
    }

    public function delete($id)
    {
        $user = User::where('_id', $id)->first();
        $user->delete();

        $books = Book::where('added_by', $id)->update([
            'status', 0
        ]);
        $courses = Course::where('added_by', $id)->update([
            'status', 0
        ]);
        return redirect()->to('/user-management')->with('msg', 'User Deleted Successfully!');
    }

    public function appUsers()
    {
        $brands = User::whereNull('deleted_at')->whereNull('type')->get();
        return view('user.app_users');
    }
    public function allAppUser(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $search = $request->search['value'];
        $totalBrands = User::whereNull('deleted_at')->count();
        $brands = User::whereNull('deleted_at')->when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")->orWhere('email', 'like',  "%$search%");
            });
        })->orderBy('created_at', 'desc')->skip((int) $start)->take((int) $length)->get();
        $brandsCount = User::whereNull('deleted_at')->when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")->orWhere('email', 'like',  "%$search%");;
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
    public function userBookReadingDetail(Request $request, $id)
    {

        $bookRead = Book::whereHas('bookTraking', function ($q) use ($id, $request) {
            $q->where('user_id', $id)->when($request->e_date, function ($q) use ($request) {
                $q->whereBetween('createdAt', [new Carbon($request->s_date),  new Carbon($request->e_date)]);
            });
        })->with(['bookTraking' => function ($q1) {
            $q1->first();
        }])->paginate(10);
        $courseRead = Course::whereHas('bookTraking', function ($q) use ($id, $request) {
            $q->where('user_id', $id)->when($request->e_date, function ($q) use ($request) {
                $q->whereBetween('createdAt', [new Carbon($request->s_date),  new Carbon($request->e_date)]);
            });
        })->with(['bookTraking' => function ($q1) {
            $q1->first();
        }])->paginate(10);
        return view('user.user_book_details', [
            'book_read' => $bookRead,
            'courseRead' => $courseRead,
            'user_id' => $id,
            's_date' => $request->s_date,
            'e_date' => $request->e_date
        ]);
    }
    public function instituteUsers()
    {
        return view('institute.users');
    }
    public function allInstituteUsers(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $search = $request->search['value'];
        $totalBrands = InstitueUser::where('institute_id', $this->user->_id)->whereNull('deleted_at')->count();
        $brands = InstitueUser::where('institute_id', $this->user->_id)->whereNull('deleted_at')->when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")->orWhere('email', 'like',  "%$search%");
            });
        })->skip((int) $start)->take((int) $length)->get();
        $brandsCount = InstitueUser::where('institute_id', $this->user->_id)->whereNull('deleted_at')->when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")->orWhere('email', 'like',  "%$search%");;
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
    public function addInstituteUsers()
    {
        return view('institute.add');
    }
    public function storeInstituteUsers(UserRequest $request)
    {

        // $user = new User();
        $user = new InstitueUser();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->institute_id =  $this->user->id;
        $user->user_id =  null;
        $user->save();
        $api_key = env('MAIL_PASSWORD');
        $api_url = "https://api.sendgrid.com/v3/mail/send";

        // Set the email details and template variables
        $to_email =  $user->email;
        $from_email = env('MAIL_FROM_ADDRESS');
        $template_id = "d-2fa42cbbaef44184977f05de22616359";
        $template_vars = [
            'parentName' => auth()->user()->name,
        ];

        // Set the payload as a JSON string
        $payload = json_encode([
            "personalizations" => [
                [
                    "to" => [
                        [
                            "email" => $to_email
                        ]
                    ],
                    "dynamic_template_data" => $template_vars
                ],
            ],
            "from" => [
                "email" => $from_email
            ],
            "template_id" => $template_id
        ]);

        // Set the cURL options and send the POST request
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer $api_key",
            "Content-Type: application/json"
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        return redirect()->to('/institute/users')->with('msg', 'User Saved Successfully!');
    }
    public function deleteInstituteUsers($id)
    {
        $user = InstitueUser::where('_id', $id)->first();
        $user->forceDelete();
        return redirect()->to('/institute/users')->with('msg', 'User Deleted Successfully!');
    }
    public function downloadSample()
    {
        $filepath = public_path('/files/sample.xlsx');
        return Response::download($filepath);
    }
    public function importUser(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|file|mimes:csv,xlsx',
        ]);

        $file = $request->file;
        Excel::import(new UsersImport, $file);

        return redirect('/institute/users')->with('msg', 'User Imported Successfully!');
    }
    public function importUserForInstitueTable(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|file|mimes:csv,xlsx',
        ]);

        $file = $request->file;
        Excel::import(new InstituteUserImport, $file);

        return redirect('/institute/users')->with('msg', 'User Imported Successfully!');
    }
    public function affiliate()
    {
        $users =   User::whereHas('refferer')->with('refferer', 'subscription')->paginate(10);

        return view('affliate_users.index', [
            'users' => $users
        ]);
    }
    public function reffered($id)
    {
        $users =   User::where('reffer_id', $id)->with('subscription')->paginate(10);

        return view('affliate_users.reffered', [
            'users' => $users
        ]);
    }
    public function family()
    {
        $users =   User::whereHas('family')->with('family')->paginate(10);

        return view('family_users.index', [
            'users' => $users
        ]);
    }
    public function members($id)
    {
        $users =   User::where('parentId', $id)->paginate(10);

        return view('family_users.reffered', [
            'users' => $users
        ]);
    }
    public function cancelSubscription()
    {
        $brands = User::whereNull('deleted_at')->whereNull('type')->get();
        $table = 'cancel-subsciption';
        return view('user.app_users', [
            'table' => $table
        ]);
    }
    public function allCancelSubscription(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $search = $request->search['value'];
        $totalBrands = User::whereHas('cancelSubscription')->whereNull('deleted_at')->whereNull('type')->count();
        $brands = User::whereHas('cancelSubscription')->whereNull('deleted_at')->whereNull('type')->when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")->orWhere('email', 'like',  "%$search%");
            });
        })->skip((int) $start)->take((int) $length)->get();
        $brandsCount = User::whereHas('cancelSubscription')->whereNull('deleted_at')->whereNull('type')->when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")->orWhere('email', 'like',  "%$search%");;
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

    public function resetPassword(Request $request)
    {
        $user = User::where('_id', $request->user_id)->first();
        // dd($user);
        if ($user) {
            $user->update([
                'password' => Hash::make($request->newPassword),
            ]);
            return redirect()->back()->with(['msg' => 'Password reset successfully']);
        } else {
            return response()->json(['message' => 'Something went wrong!']);
        }
    }
    public function profile($id)
    {
        $user = User::where('_id', $id)->with('subscription.plan')->first();
        $subscription = Subscription::where('product_title', 'TrueILM Plan')->first();

        $checkLifeTime = UserSubscription::where('user_id', $user->_id)->where('plan_id',  @$subscription->_id)->pluck('plan_type')->toArray();
        return view('user.user_profile', [
            'user' => $user,
            'checkLifeTime' => $checkLifeTime
        ]);
    }
    public   function giveSubscription(Request $request)
    {
        $user = User::where('_id', $request->id)->first();
        $subscription = Subscription::where('product_title', 'TrueILM Plan')->first();
        if ($request->subscription) {

            UserSubscription::where('user_id', $user->_id)->whereIn('plan_type', [0, 1])->delete();
            UserSubscription::where('user_id', $user->_id)->whereIn('plan_type', [2, 3])->update(['stripeCancelled' => 1]);

            foreach ($request->subscription as $subs) {
                $planName = 'Big Family';
                if (@$subs == 1) {
                    $planName = 'Individual';
                } elseif (@$subs == 2) {
                    $planName = 'Family';
                }
                $checkLifeTime = UserSubscription::where('user_id', $user->_id)->where('plan_type', $subs)->where('plan_id',  @$subscription->_id)->first();
                if ($checkLifeTime) {
                    continue;
                } else {
                    $userSubscription = new UserSubscription();
                    $userSubscription->user_id =  $user->_id;
                    $userSubscription->email =  $user->email;
                    $userSubscription->plan_name =  $planName;
                    $userSubscription->status =  'paid';
                    $userSubscription->plan_id =  @$subscription->_id;
                    $userSubscription->expiry =  'Life Time';
                    $userSubscription->plan_type =  $subs;
                    $userSubscription->start_date =  Carbon::now();
                    $userSubscription->type =  3;
                    $userSubscription->save();
                }
            }
            $checkLifeTime = UserSubscription::where('user_id', $user->_id)->whereNotIn('plan_type',  $request->subscription)->where('plan_id', @$subscription->_id)->delete();
        } else {
            $checkLifeTime = UserSubscription::where('user_id', $user->_id)->where('plan_id',  @$subscription->_id)->delete();
        }

        return redirect()->back()->with(['msg' => 'Access updated Successfully!']);
    }
    public static function checkSubscriptionExpiry()
    {
        \DB::table('test')->insert([
            'key' => 'value'
        ]);

        $now = Carbon::now();

        $thirtyDaysAgo = $now->copy()->subDays(30);

        $usersToEmail = UserSubscription::where('istrial', 1)
            ->where('start_date', '<=', $thirtyDaysAgo)
            ->get();
        $api_key = env('MAIL_PASSWORD');
        $api_url = "https://api.sendgrid.com/v3/mail/send";
        foreach ($usersToEmail as $user) {
            $user->istrial = 0;
            $user->save();
            $to_email =  $user->email;
            $from_email = env('MAIL_FROM_ADDRESS');
            $template_id = "d-8e1abcf085124ec9a9e5c356601f8f60";
            // $template_vars = [
            //     'email' => 'imran.skylinxtech@gmail.com'
            // ];

            // Set the payload as a JSON string
            $payload = json_encode([
                "personalizations" => [
                    [
                        "to" => [
                            [
                                "email" => $to_email
                            ]
                        ],
                        // "dynamic_template_data" => $template_vars
                    ]
                ],
                "from" => [
                    "email" => $from_email
                ],
                "template_id" => $template_id
            ]);

            // Set the cURL options and send the POST request
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $api_url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                "Authorization: Bearer $api_key",
                "Content-Type: application/json"
            ]);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);
        }

        return '0';
    }
}
