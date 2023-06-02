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
        try {
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
                \Stripe\Customer::createSource(
                    $customer,
                    [
                        'source' => $request->id,
                    ]
                );
            }

            return response()->json(['status' => '200', 'message' => 'customers saved!', 'data' => $user]);
        } catch (Exception $e) {
            return response()->json(['status' => '401', 'message' => 'error', 'data' => $e]);
        }
    }
}
