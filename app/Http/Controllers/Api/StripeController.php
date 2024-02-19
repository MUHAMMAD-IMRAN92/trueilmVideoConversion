<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CustomerCard;
use App\Models\Subscription;
use App\Models\User;
use App\Models\UserSubscription;
use Carbon\Carbon;
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

    public function sessionUrl(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user) {
            $customer =   $user->customer;
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
            $subscription = UserSubscription::where('customer', $customer)->where('status', 'paid')->get();
            if (count($subscription) > 0) {

                $session = $stripe->billingPortal->sessions->create([
                    'customer' => $customer,
                    'return_url' =>   $request->return_url,
                ]);
                return  sendSuccess('Billing Portal Url .', $session->url);
            } else {
                // $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
                Stripe::setApiKey(env('STRIPE_SECRET'));

                $session = \Stripe\Checkout\Session::create([
                    'payment_method_types' => ['card'],
                    'line_items' => [[
                        'price' => $request->price,
                        'quantity' => 1, // Set the quantity to 1 for a standard subscription
                    ]],
                    'mode' => 'subscription',
                    'customer' => $customer,
                    'allow_promotion_codes' => true,
                    'success_url' =>  $request->success_url,
                    'cancel_url' =>  $request->cancel_url,

                ]);
                $plan = Subscription::where('price_id', $request->price)->where('status', 1)->first();
                $userSubscription = new UserSubscription();
                $userSubscription->user_id = $user->_id;
                $userSubscription->email = $user->email;
                $userSubscription->customer = $user->customer;
                $userSubscription->price_id =  $request->price;
                $userSubscription->expiray_date = Carbon::parse($session->expires_at)->setTimezone('UTC')->format('Y-m-d\TH:i:s.uP');
                $userSubscription->status = $session->payment_status;
                $userSubscription->plan_name = @$plan->product_title;
                $userSubscription->plan_type = @$plan->type;
                $userSubscription->plan_id = @$plan->_id;
                $userSubscription->checkout_id = $session->id;
                $userSubscription->save();


                return  sendSuccess('Checkout Session Url .', $session->url);
            }
        } else {
            return sendError('Something went wrong !', []);
        }
    }

    public function webhook()
    {

        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));


        // $endpoint_secret = 'whsec_CzOJbOFa7h8jaLUBlTbCQThnCHVQJgwm';
        $endpoint_secret = 'whsec_YOfNdwXJc2MVjkns5UihqTmplZFtcDmo';

        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload,
                $sig_header,
                $endpoint_secret
            );
        } catch (\UnexpectedValueException $e) {
            // Invalid payload

            http_response_code(400);
        exit();
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature

            http_response_code(400);
            exit();
        }

        // Handle the event
        switch ($event->type) {
            case 'checkout.session.completed':
                $session = $event->data->object;

                $userSubscription  = UserSubscription::where('checkout_id', $session->id)->first();
                $userSubscription->status = $session->payment_status;
                $userSubscription->subscription_id = $session->subscription;
                $userSubscription->save();
            case 'customer.subscription.updated':
                $subscription = $event->data->object;

                $userSubscription  = UserSubscription::where('subscription_id',  $subscription->id)->first();
                if ($userSubscription) {
                    if ($subscription->cancel_at_period_end == true) {
                        $userSubscription->status = 'cancelled';
                        $userSubscription->canceled_at = Carbon::parse($subscription->canceled_at)->setTimezone('UTC')->format('Y-m-d\TH:i:s.uP');
                        $userSubscription->save();
                    } else {
                        $userSubscription->status = 'paid';
                        $userSubscription->canceled_at = '';
                        $userSubscription->save();
                    }
                }
            default:
                echo 'Received unknown event type ' . $event->type;
        }
    }
}
