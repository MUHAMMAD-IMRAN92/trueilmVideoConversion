<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
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
    public function ajaxUsersData()
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $usersData = \DB::collection('users')
            ->whereBetween('createdAt', [$startOfMonth, $endOfMonth])
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
        $daysInMonth = $startOfMonth->daysInMonth;
        $days = [];
        $registrations = [];

        for ($i = 1; $i <= $daysInMonth; $i++) {
            $days[] = $i;
            $registrations[] = 0;
        }

        foreach ($usersData as $data) {
            $day = $data->_id['day'];
            $registrations[$day - 1] = $data['count'];
        }

        return response()->json([
            'days' => $days,
            'registrations' => $registrations
        ]);
    }
}
