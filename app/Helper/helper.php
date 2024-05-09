<?php

use App\Models\Activities;
use App\Models\GlossoryAttribute;
use GrahamCampbell\ResultType\Success;
use Illuminate\Support\Facades\Response;
use App\Models\Book;
use App\Models\BookContent;
use App\Models\BookForSale;
use App\Models\Category;
use App\Models\CourseLesson;
use App\Models\Grant;
use App\Models\UserSubscription;
use Carbon\Carbon;
use Meilisearch\Client;
use Illuminate\Support\Facades\Storage;

function sendSuccess($msg, $data = null)
{
    return Response::json(['status' => 200, 'message' => $msg, 'data' => $data]);
}

function sendError($msg, $data = null)
{
    return Response::json(['status' => 400, 'message' => $msg, 'data' => $data]);
}

function glossaryAttribute($glossoryId, $type)
{
    $glossory = GlossoryAttribute::where('glossory_id', $glossoryId)->where('type', $type)->first();
    if ($glossory) {
        return $glossory->attribute;
    } else {
        return '';
    }
}
function activity($key, $id, $model)
{
    $arr = [1 => 'Approved Content', 2 => 'Rejected Content', 3 => 'Disabled Content', 4 => 'Enabled Content', 5 => ' Approved A Grant', 6 => ' Rejected A Grant'];
    if ($model == 1) {
        $content = Book::where('_id', $id)->first();
    } else {
        $content = Grant::where('_id', $id)->first();
    }
    $acvtivity  = new Activities();
    $acvtivity->key  =  $arr[$key];
    $acvtivity->type  = $key;
    $acvtivity->content_id  = $id;

    if ($key == 3 || $key == 4) {
        $link = 'book/update-status/';
    }
    if ($key == 1 || $key == 2) {
        $link = 'content/revert/';
    }
    if ($key == 5) {
        $link = 'content/revert/';
    }
    if ($key == 6) {
        $link = 'content/revert/';
    }
    $acvtivity->revert_link  = $link;
    $acvtivity->user_id = auth()->user()->_id;

    $acvtivity->title = $content->title;
    $acvtivity->status =  0;

    $acvtivity->save();
    return 1;
}
function countiesCities($countries, $book_id)
{
    ini_set('memory_limit', '-1');

    $book = BookForSale::where('_id', $book_id)->first();
    $arr = [];
    if ($countries) {
        foreach ($countries as $country) {
            $content = Storage::disk('public')->get('cities.json');
            $collect =  collect(json_decode($content));
            $filtered =   $collect->filter(function ($value, $key) use ($country) {
                return $value->country_name ==  $country;
            });
            $names = $filtered->values()->pluck('name')->toArray();
            $arr =  array_merge($arr, $names);
        }
    }
    $data['cities'] = $arr;
    // if ($book && $book->cities) {
    //     $data['oldCities'] = explode(',', $book->cities);
    // } else {
    $data['oldCities'] = [];
    // }
    return $data;
}

function getCategorydropdown($parent_id = 0, $level = 0, $product_cat = 0, $type = 0)
{
    $html = "";
    $seperator = "";
    for ($loop = 0; $loop < $level; $loop++) {
        $seperator .= "-";
    }
    $level_categories = Category::where('parent_id', (string)$parent_id)->get();
    foreach ($level_categories as $key => $category) {
        $count =  Category::where('parent_id', $category->_id)->count();
        if ($count > 0) {
            $html .= '<optgroup  label="' . $seperator . $category->title . '">';
            $level++;
            $html .= getCategorydropdown($category->_id, $level, $product_cat, 0);
            $html .= '</optgroup>';
        } else {
            $selected = "";
            if ($product_cat ==  $category->_id) {
                $selected = "selected";
            }
            $html .= '<option ' . $selected . ' value="' . $category->id . '">' . $category->title . '</option>';
        }
    }
    return $html;
}

function indexing($type, $content)
{
    ini_set("memory_limit", "-1");
    $client = new  Client('http://localhost:7700', '3bc7ba18215601c4de218ef53f0f90e830a7f144');
    $arrIndex = [1 => 'ebook', 2 => 'audio', 3 => 'paper', 4 => 'alQurantranslations', 5 => 'alHadeestranslations', 6 =>  'course', 7 => 'podcast', 8 => 'bookForSale', 9 => 'glossary', 10 => "courseLesson", 11 => "podcastEpisode", 12 => "audioChapter"];
    $contentArr = $content->toArray();
    $client->index($arrIndex[$type])->addDocuments($contentArr);

    if ($type == 2) {
        $book_content = BookContent::where('book_id', $content->_id)->get()->toArray();
        $client->index($arrIndex[12])->addDocuments($book_content);
    } else if ($type == 7) {
        $book_content = BookContent::where('book_id', $content->_id)->get()->toArray();
        $client->index($arrIndex[11])->addDocuments($book_content);
    } else if ($type == 6) {
        $course_lesson = CourseLesson::where('course_id', $content->_id)->get()->toArray();
        $client->index($arrIndex[11])->addDocuments($course_lesson);
    }
    return 1;
}
function subscriptionEmail($userEmail, $plan, $template_id)
{
    $api_key = env('MAIL_PASSWORD');
    $api_url = "https://api.sendgrid.com/v3/mail/send";

    // Set the email details and template variables
    $to_email =  $userEmail;
    $from_email = env('MAIL_FROM_ADDRESS');

    $template_vars = [
        'subscription' => $plan
    ];

    // Set the payload as a JSON string
    $payload = json_encode([
        "personalizations" => [
            [
                "to" => [
                    [
                        "email" => $to_email
                    ]
                ], "dynamic_template_data" => $template_vars
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

    return 1;
}
function addContactToSendGridList($email, $type)
{
    $apiKey = getenv('MAIL_PASSWORD');
    $sg = new \SendGrid($apiKey);
    $list = '';
    if ($type == 3) {
        $list = 'ba9e0598-ac9f-49a3-a383-be02ecb8f2b3';
    } elseif ($type == 2) {
        $list = 'a612123e-74e9-404e-a863-ea1a8163b58f';
    } else {
        $list = 'af6f628a-e024-4ce0-95a6-c72e2ef16df3';
    }
    $request_body = json_decode('{
                "contacts": [
                    {
                        "email": "' . $email . '"
                    }
                ],
                "list_ids": [
                    "' . $list . '"
                    ]

            }');
    try {
        //saving in specific list
        $response = $sg->client->marketing()->contacts()->put($request_body);
        if ($response->statusCode() == 202) {

            return sendSuccess('User Saved To Sendgrid List!', []);
        } else {
            return sendError('msg', $response->body());
        }
    } catch (Exception $ex) {
        return sendError('Exception!', $response->body());
    }
}
function countHtmlFiles($directory)
{
    $htmlFileCount = 0;
    // Open the directory
    $dir = opendir($directory);

    // Loop through the directory
    while (($file = readdir($dir)) !== false) {
        // Check if the file is a regular file and ends with .html (case insensitive)
        if (is_file($directory . '/' . $file) && strtolower(pathinfo($file, PATHINFO_EXTENSION)) === 'html') {
            $htmlFileCount++;
        }
    }

    closedir($dir);

    return $htmlFileCount;
}
function deleteOtherSubscriptions($currentSubscription)
{
    $userSubscriptions = UserSubscription::where('email', $currentSubscription->email)->where('status', 'paid')->where('plan_type', '!=', 0)->where('_id', '!=',  $currentSubscription->_id)->whereNull('deleted_at')->first();
    $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
    if ($userSubscriptions) {

        if ($currentSubscription->plan_type < $userSubscriptions->plan_type) {
            if ($userSubscriptions->type != 3) {
                $updatedSubs =  $stripe->subscriptions->update(
                    $currentSubscription->subscription_id,
                    ['trial_end' => strtotime($userSubscriptions->expiry_date)]
                );
                $currentSubscription->start_date = Carbon::parse(@$userSubscriptions->expiry_date)->setTimezone('UTC')->format('Y-m-d\TH:i:s.uP');
                $currentSubscription->expiry_date = Carbon::parse(@$updatedSubs->current_period_end)->setTimezone('UTC')->format('Y-m-d\TH:i:s.uP');
                $currentSubscription->save();
            }
            if ($userSubscriptions->type == 3) {
                $userSubscriptions->delete();
            } else {
                $userSubscriptions->stripeCancelled = 1;
                $userSubscriptions->save();
            }
        } else {
            UserSubscription::where('subscription_id',  $userSubscriptions->subscription_id)->where('email', $currentSubscription->email)->delete();
            $userSubscriptions->status = 'cancelled';
            $userSubscriptions->save();
        }
        $stripe->subscriptions->cancel($userSubscriptions->subscription_id, []);
    }
    return  1;
}
