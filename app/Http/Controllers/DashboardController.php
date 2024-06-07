<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookTranking;
use App\Models\BookTrankingDetails;
use App\Models\User;
use App\Models\UserSubscription;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maklad\Permission\Models\Role;

class DashboardController extends Controller
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
        return view('dashboard');
    }
    public function ajaxUsersData(Request $request)
    {
        if ($request->has('e_date')) {
            $startOfMonth = Carbon::parse($request->s_date);
            $endOfMonth = Carbon::parse($request->e_date);
            $daysInRange = $startOfMonth->diffInDays($endOfMonth) + 1;
        } else {
            $startOfMonth = Carbon::now()->startOfMonth();
            $endOfMonth = Carbon::now()->endOfMonth();
        }

        $usersData = \DB::collection('users')
            ->raw(function ($collection) use ($startOfMonth, $endOfMonth) {
                return $collection->aggregate([
                    [
                        '$match' => [
                            'createdAt' => [
                                '$gte' => new \MongoDB\BSON\UTCDateTime($startOfMonth->timestamp * 1000),
                                '$lte' => new \MongoDB\BSON\UTCDateTime($endOfMonth->timestamp * 1000),
                            ]
                        ]
                    ],
                    [
                        '$match' => [
                            'createdAt' => [
                                '$lte' => new \MongoDB\BSON\UTCDateTime(Carbon::now()->endOfDay()->timestamp * 1000)
                            ]
                        ]
                    ],
                    [
                        '$group' => [
                            '_id' => [
                                'year' => ['$year' => '$createdAt'],
                                'month' => ['$month' => '$createdAt'],
                                'day' => ['$dayOfMonth' => '$createdAt']
                            ],
                            'count' => ['$sum' => 1]
                        ]
                    ],
                    [
                        '$sort' => ['_id.year' => 1, '_id.month' => 1, '_id.day' => 1]
                    ]
                ]);
            });

        // Prepare the data for the graph
        $daysInMonth = $startOfMonth->diffInDays($endOfMonth) + 1;
        $days = [];
        $registrations = [];

        // Populate arrays only for dates within the specified range
        for ($i = 0; $i < $daysInMonth; $i++) {
            $date = $startOfMonth->copy()->addDays($i);
            // Only include dates less than or equal to today's date
            if ($date->lte(Carbon::now()->endOfDay())) {
                $days[] = $date->format('Y-m-d');
                $registrations[] = 0;
            }
        }

        // Populate registrations for the existing user data
        foreach ($usersData as $data) {
            $day = $data->_id['day'];
            $month = $data->_id['month'];
            $year = $data->_id['year'];
            $date = Carbon::create($year, $month, $day)->format('Y-m-d');

            // Find the index of the date and update registrations
            $index = array_search($date, $days);
            if ($index !== false) {
                $registrations[$index] = $data['count'];
            }
        }

        return response()->json([
            'days' => $days,
            'registrations' => $registrations
        ]);
    }
    public function topReadBooks(Request $request)
    {
        if ($request->has('e_date')) {
            $startOfMonth = Carbon::parse($request->s_date);
            $endOfMonth = Carbon::parse($request->e_date);
        } else {
            $startOfMonth = Carbon::now()->startOfMonth();
            $endOfMonth = Carbon::now()->endOfMonth();
        }

        $ebookCount =  BookTrankingDetails::whereHas('tracking', function ($q) {
            $q->where('type', '1');
        })->where('createdAt', '>=', $startOfMonth)->where('createdAt', '<=', $endOfMonth)->count();
        $audioBount =  BookTrankingDetails::whereHas('tracking', function ($q) {
            $q->where('type', '2');
        })->where('createdAt', '>=', $startOfMonth)->where('createdAt', '<=', $endOfMonth)->count();
        $podcastCount =  BookTrankingDetails::whereHas('tracking', function ($q) {
            $q->where('type', '7');
        })->where('createdAt', '>=', $startOfMonth)->where('createdAt', '<=', $endOfMonth)->count();
        $courseCount =  BookTrankingDetails::whereHas('tracking', function ($q) {
            $q->where('type', '6');
        })->where('createdAt', '>=', $startOfMonth)->where('createdAt', '<=', $endOfMonth)->count();
        $values = [$ebookCount, $audioBount, $podcastCount, $courseCount];
        $content = ['eBook', 'Audio Book', 'Podcast', 'Courses'];

        // $values = [1073, 193, 63, 144];

        // Step 1: Calculate the total sum of the array
        $totalSum = array_sum($values);

        // Initialize an empty array to store the percentages
        $percentages = [];

        // Step 2: Calculate the percentage of each value
        foreach ($values as $value) {
            $percentage = ($value / $totalSum) * 100;
            $percentages[] = $percentage;
        }

        $data['content'] =  $content;
        $data['percentage'] =    $percentages;
        return $data;
    }
    public function subscriptionData(Request $request)
    {
        // return Carbon::now();
        $arr = [];

        if ($request->has('e_date')) {
            $startOfMonth = Carbon::parse($request->s_date);
            $endOfMonth = Carbon::parse($request->e_date);
        } else {
            $startOfMonth = Carbon::now()->startOfMonth();
            $endOfMonth = Carbon::now()->endOfMonth();
        }
        $trailSubscription = UserSubscription::where('created_at', '>=', $startOfMonth)
            ->where('created_at', '<=', $endOfMonth)->where('istrail', '=', 1)->where('status', 'paid')->where('plan_name', '!=', 'Freemium')
            ->count();
        $newSubscription = UserSubscription::where('created_at', '>=', $startOfMonth)
            ->where('created_at', '<=', $endOfMonth)->where('istrail', '!=', 1)->where('status', 'paid')->where('plan_name', '!=', 'Freemium')
            ->count();
        $currentMonth = Carbon::now()->month;


        if ($request->has('e_date')) {
            $startOfMonth = Carbon::parse($request->s_date)->format('Y-m-d\TH:i:s.u\Z');
            $endOfMonth = Carbon::parse($request->e_date)->format('Y-m-d\TH:i:s.u\Z');
        } else {
            $startOfMonth = Carbon::now()->startOfMonth()->format('Y-m-d\TH:i:s.u\Z');
            $endOfMonth = Carbon::now()->endOfMonth()->format('Y-m-d\TH:i:s.u\Z');
        }

        $expirySubscription = UserSubscription::whereBetween('expiry_date', [$startOfMonth, $endOfMonth])->where('istrail', '!=', 1)->where('status', 'paid')->where('plan_name', '!=', 'Freemium')->count();



        $arr['trails'] = $trailSubscription;
        $arr['new_subscription'] = $newSubscription;
        $arr['expire_subscription'] = $expirySubscription;
        return $arr;
    }
    public function getTopReadBooksByType(Request $request, $type)
    {
        $data = [];
        $trackings = BookTranking::where('type', $type)->whereHas('book', function ($q) use ($request) {
            $q->when($request->category, function ($query) use ($request) {
                $query->where('category_id', $request->category);
            })->when($request->price, function ($query) use ($request) {
                $query->where('p_type', $request->price);
            })->when($request->aproval, function ($query) use ($request) {
                $query->where('aproved', (int)$request->aproval);
            })->when($request->uncategorized, function ($query) use ($request) {
                if ($request->uncategorized == "true") {
                    $query->whereDoesntHave('category');
                }
            })->when($request->author, function ($query) use ($request) {
                $query->where('author_id', $request->author);
            });
        })->with('book')
            ->get()
            ->groupBy('book_id')
            ->map(function ($group, $bookId) {
                return [
                    'count' => $group->count(),
                    'book' => @$group->first()->book->title
                ];
            })
            ->sortByDesc('count')
            ->take(10);
        $book = [];
        $count = [];
        foreach ($trackings as $track) {
            $book[] = $track['book'];
            $count[] = $track['count'];
        }
        $data['book'] = $book;
        $data['count'] = $count;
        return $data;
    }
}
