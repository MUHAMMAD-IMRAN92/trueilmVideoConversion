<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CustomerCard;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Stripe\Stripe;

class StripeController extends Controller
{
    public function createCusCard(Request $request)
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        Stripe::setApiKey(env('STRIPE_SECRET'));
        // Create a new customer with a source (i.e. a Stripe token)
        $user = User::where('_id', $request->user_id)->first();
        if ($user) {
            if ($user->customer == null) {
                $customer = $stripe->customers->create([
                    'name' => $user->name,
                    'email' => $user->email,

                ]);
                $user->customer =  $customer->id;
                $user->save();
            } else {
                $customer = $user->customer;
            }
        } else {
            return response()->json(['status' => '400', 'message' => 'User Not Found!', 'data' => $request->user_id]);
        }
        return response()->json(['status' => '200', 'message' => 'customer saved!', 'data' => $user]);
    }


    public function subscribe(Request $request)
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        Stripe::setApiKey(env('STRIPE_SECRET'));
        $user = User::where('email', $request->email)->first();
        if ($user->customer) {
            $subscription = $stripe->subscriptions->create([
                'customer' => $user->customer,
                'items' => [
                    [
                        'price' => env($request->plan),
                    ],
                ],
                'expand' => ['latest_invoice.payment_intent'],
            ]);

            $user->plan = env($request->plan);
            $user->start_date = date('Y-m-d H:i:s', $subscription->current_period_start);
            $user->expiery_date = date('Y-m-d H:i:s', $subscription->current_period_end);
            $user->save();
            return response()->json(['status' => '200', 'message' => 'Plan Subscribed!', 'data' => ['subscription' => $subscription]]);
        } else {
            return response()->json(['status' => '401', 'message' => 'Something went wrong!', 'data' => []]);
        }
    }
}
