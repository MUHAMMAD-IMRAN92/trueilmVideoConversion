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
use App\Models\User;
use App\Models\UserSubscription;
use Carbon\Carbon;
use Meilisearch\Client;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;


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
    // return $email;
    $apiKey = getenv('MAIL_PASSWORD');
    $user = User::where('email', $email)->first();
    $sg = new \SendGrid($apiKey);
    $list = '';
    if ($type == 3) {
        $list = 'ba9e0598-ac9f-49a3-a383-be02ecb8f2b3';
    } elseif ($type == 2) {
        // dd($email);
        $list = 'a612123e-74e9-404e-a863-ea1a8163b58f';
    } else {
        $list = 'af6f628a-e024-4ce0-95a6-c72e2ef16df3';
    }
    $request_body = json_decode('{

                "contacts": [
                    {
                        "email": "' . $user->email . '",
                        "user_name" : "' . @$user->user_name . '",
                        "phone_number" : "' . @$user->phone . '"
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
function deleteOtherSubscriptions($userSubscription)
{
    $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
    UserSubscription::where('email', $userSubscription->email)->where('plan_name', 'Freemium')->update([
        'testString' =>  'updated by type Free'
    ]);
    UserSubscription::where('email', $userSubscription->email)->where('plan_name', 'Freemium')->delete();
    // UserSubscription::where('email', $userSubscription->email)->where('status', 'paid')->where('istrail', 1)->update([
    //     'testString' =>  'updated by type1'
    // ]);
    // UserSubscription::where('email', $userSubscription->email)->where('status', 'paid')->where('istrail', 1)->delete();
    UserSubscription::where('email', $userSubscription->email)->where('status', 'paid')->where('type', 3)->update([
        'testString' =>  'updated by type3'
    ]);
    UserSubscription::where('email', $userSubscription->email)->where('status', 'paid')->where('type', 3)->delete();

    $oldSubscription = UserSubscription::where('email', $userSubscription->email)->where('_id', '!=', $userSubscription->_id)->where('stripeCancelled', '!=', 1)->where('status', 'paid')->first();

    if ($oldSubscription) {

        if ($oldSubscription->plan_type > $userSubscription->plan_type) {
            $stripe->subscriptions->cancel($oldSubscription->subscription_id, []);

            $updatedSubs =  $stripe->subscriptions->update(
                $userSubscription->subscription_id,
                ['trial_end' => strtotime($oldSubscription->expiry_date)]
            );


            $oldSubscription->stripeCancelled = 1;
            $oldSubscription->save();

            $userSubscription->start_date = Carbon::parse(@$oldSubscription->expiry_date)->setTimezone('UTC')->format('Y-m-d\TH:i:s.uP');
            $userSubscription->expiry_date = Carbon::parse(@$updatedSubs->current_period_end)->setTimezone('UTC')->format('Y-m-d\TH:i:s.uP');
            // $userSubscription->testString = 'expiry check';

            $userSubscription->save();
        } else {
            $stripe->subscriptions->cancel($oldSubscription->subscription_id, []);
            $oldSubscription->status = 'cancelled';
            $oldSubscription->save();
            UserSubscription::where('subscription_id',  $oldSubscription->subscription_id)->where('email', $oldSubscription->email)->update([
                'testString' =>  'updated by else'
            ]);
            UserSubscription::where('subscription_id',  $oldSubscription->subscription_id)->where('email', $oldSubscription->email)->delete();
        }
    }
    return  1;
}
function deleteOtherSubscriptionscopy($currentSubscription)
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
            $stripe->subscriptions->cancel($userSubscriptions->subscription_id, []);
            UserSubscription::where('subscription_id',  $userSubscriptions->subscription_id)->where('email', $currentSubscription->email)->delete();
            $userSubscriptions->status = 'cancelled';
            $userSubscriptions->save();
        }
    }
    return  1;
}


function getCountryNameFromCode($code)
{
    $countryCodes =  [
        "Afghanistan" => "+93",
        "Albania" => "+355",
        "Algeria" => "+213",
        "Andorra" => "+376",
        "Angola" => "+244",
        "Antigua and Barbuda" => "+1-268",
        "Argentina" => "+54",
        "Armenia" => "+374",
        "Australia" => "+61",
        "Austria" => "+43",
        "Azerbaijan" => "+994",
        "Bahamas" => "+1-242",
        "Bahrain" => "+973",
        "Bangladesh" => "+880",
        "Barbados" => "+1-246",
        "Belarus" => "+375",
        "Belgium" => "+32",
        "Belize" => "+501",
        "Benin" => "+229",
        "Bhutan" => "+975",
        "Bolivia" => "+591",
        "Bosnia and Herzegovina" => "+387",
        "Botswana" => "+267",
        "Brazil" => "+55",
        "Brunei" => "+673",
        "Bulgaria" => "+359",
        "Burkina Faso" => "+226",
        "Burundi" => "+257",
        "Cabo Verde" => "+238",
        "Cambodia" => "+855",
        "Cameroon" => "+237",
        "Canada" => "+1",
        "Central African Republic" => "+236",
        "Chad" => "+235",
        "Chile" => "+56",
        "China" => "+86",
        "Colombia" => "+57",
        "Comoros" => "+269",
        "Congo" => "+242",
        "Costa Rica" => "+506",
        "Croatia" => "+385",
        "Cuba" => "+53",
        "Cyprus" => "+357",
        "Czech Republic" => "+420",
        "Denmark" => "+45",
        "Djibouti" => "+253",
        "Dominica" => "+1-767",
        "Dominican Republic" => "+1-809, +1-829, +1-849",
        "East Timor" => "+670",
        "Ecuador" => "+593",
        "Egypt" => "+20",
        "El Salvador" => "+503",
        "Equatorial Guinea" => "+240",
        "Eritrea" => "+291",
        "Estonia" => "+372",
        "Eswatini" => "+268",
        "Ethiopia" => "+251",
        "Fiji" => "+679",
        "Finland" => "+358",
        "France" => "+33",
        "Gabon" => "+241",
        "Gambia" => "+220",
        "Georgia" => "+995",
        "Germany" => "+49",
        "Ghana" => "+233",
        "Greece" => "+30",
        "Grenada" => "+1-473",
        "Guatemala" => "+502",
        "Guinea" => "+224",
        "Guinea-Bissau" => "+245",
        "Guyana" => "+592",
        "Haiti" => "+509",
        "Honduras" => "+504",
        "Hungary" => "+36",
        "Iceland" => "+354",
        "India" => "+91",
        "Indonesia" => "+62",
        "Iran" => "+98",
        "Iraq" => "+964",
        "Ireland" => "+353",
        "Israel" => "+972",
        "Italy" => "+39",
        "Jamaica" => "+1-876",
        "Japan" => "+81",
        "Jordan" => "+962",
        "Kazakhstan" => "+7",
        "Kenya" => "+254",
        "Kiribati" => "+686",
        "North Korea" => "+850",
        "South Korea" => "+82",
        "Kosovo" => "+383",
        "Kuwait" => "+965",
        "Kyrgyzstan" => "+996",
        "Laos" => "+856",
        "Latvia" => "+371",
        "Lebanon" => "+961",
        "Lesotho" => "+266",
        "Liberia" => "+231",
        "Libya" => "+218",
        "Liechtenstein" => "+423",
        "Lithuania" => "+370",
        "Luxembourg" => "+352",
        "Madagascar" => "+261",
        "Malawi" => "+265",
        "Malaysia" => "+60",
        "Maldives" => "+960",
        "Mali" => "+223",
        "Malta" => "+356",
        "Marshall Islands" => "+692",
        "Mauritania" => "+222",
        "Mauritius" => "+230",
        "Mexico" => "+52",
        "Micronesia" => "+691",
        "Moldova" => "+373",
        "Monaco" => "+377",
        "Mongolia" => "+976",
        "Montenegro" => "+382",
        "Morocco" => "+212",
        "Mozambique" => "+258",
        "Myanmar" => "+95",
        "Namibia" => "+264",
        "Nauru" => "+674",
        "Nepal" => "+977",
        "Netherlands" => "+31",
        "New Zealand" => "+64",
        "Nicaragua" => "+505",
        "Niger" => "+227",
        "Nigeria" => "+234",
        "North Macedonia" => "+389",
        "Norway" => "+47",
        "Oman" => "+968",
        "Pakistan" => "+92",
        "Palau" => "+680",
        "Palestine" => "+970",
        "Panama" => "+507",
        "Papua New Guinea" => "+675",
        "Paraguay" => "+595",
        "Peru" => "+51",
        "Philippines" => "+63",
        "Poland" => "+48",
        "Portugal" => "+351",
        "Qatar" => "+974",
        "Romania" => "+40",
        "Russia" => "+7",
        "Rwanda" => "+250",
        "Saint Kitts and Nevis" => "+1-869",
        "Saint Lucia" => "+1-758",
        "Saint Vincent and the Grenadines" => "+1-784",
        "Samoa" => "+685",
        "San Marino" => "+378",
        "Sao Tome and Principe" => "+239",
        "Saudi Arabia" => "+966",
        "Senegal" => "+221",
        "Serbia" => "+381",
        "Seychelles" => "+248",
        "Sierra Leone" => "+232",
        "Singapore" => "+65"
    ];

    // Check if the code exists in the array
    if (array_key_exists($code, $countryCodes)) {
        return $countryCodes[$code];
    } else {
        return "Country not found";
    }
}
function cheakPermission($name)
{
   
    if(!Gate::allows('hasPermission', $name)) {
        abort(403, 'Unauthorized action.');
    }
    


}