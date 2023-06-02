<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
        if ($user->customer == null) {
            $customer = $stripe->customers->create([
                'name' => $user->name,
                'email' => $user->email,

                // 'payment_method' => $request->input('id'),
            ]);
            $user->customer =  $customer->id;
            $user->save();
        } else {
            $customer = $user->customer;

            $stripe->customers->createSource(
                $customer,
                ['source' => $request->paymentMethod]
            );
        }
        return response()->json(['status' => '200', 'message' => 'customer saved!', 'data' => $user]);
    }


    public function subscribe(Request $request)
    {
        try {
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
                ]);
                return response()->json(['status' => '200', 'message' => 'Plan Subscribed!', 'data' => []]);
            } else {
                return response()->json(['status' => '401', 'message' => 'Something went wrong!', 'data' => []]);
            }
        } catch (Exception $e) {
            return response()->json(['status' => '401', 'message' => 'Something went wrong!', 'data' => $e]);
        }
    }
}
