<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\ResetPassword;
use App\Mail\UserVarification;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function sendVerifyEmail(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required'
        ]);
        if ($validator->fails()) {
            return sendError('Validation Failed!', $validator->errors());
        }
        $device = $request->device;
        $user = User::where('email', $request->email)->first();

        if ($user) {
            $token = \Hash::make(rand(1, 10));
            $user->verification_token = $token;
            $user->is_verified = 0;
            $user->save();
            $userEmail = $user->email;
            // Mail::to($userEmail)->send(new UserVarification($user));
            $api_key = env('MAIL_PASSWORD');
            $api_url = "https://api.sendgrid.com/v3/mail/send";

            // Set the email details and template variables
            $to_email =  $user->email;
            $from_email = env('MAIL_FROM_ADDRESS');
            $template_id = "d-b6a996c0c8f04d71bcf05f77d983f2e6";
            $template_vars = [
                'id' => $token,
                'device' => $device
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
            return sendSuccess('Mail Has Been Sent!', []);
        } else {
            return sendError('User Not Found!', []);
        }
    }
    public function resetPassword(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required'
        ]);
        if ($validator->fails()) {
            return sendError('Validation Failed!', $validator->errors());
        }

        $user = User::where('email', $request->email)->first();

        // if ($user) {
        //     $userEmail = $user->email;
        //     Mail::to($userEmail)->send(new ResetPassword($user));
        //     return sendSuccess('Mail Has Been Sent!', []);
        // } else {
        //     return sendError('User Not Found!', []);
        // }
        if ($user) {
            try {
                $api_key = env('MAIL_PASSWORD');
                $api_url = "https://api.sendgrid.com/v3/mail/send";

                // Set the email details and template variables
                $to_email =  $user->email;
                $from_email = env('MAIL_FROM_ADDRESS');
                $template_id = "d-a894a8dd5b154f6987533cd1e1023864";
                $template_vars = [
                    'id' => $user->_id,
                    'device' => $request->device,
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
                return sendSuccess("We'll email you a link to reset your password.", []);
            } catch (\Exception $e) {
                return $e->getMessage();
            }
        } else {
            return sendError("A user doesn't exist with this email", []);
        }
    }
    public function saveToSendGrid(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required'
        ]);
        if ($validator->fails()) {
            return sendError('Validation Failed!', $validator->errors());
        }
        $apiKey = getenv('MAIL_PASSWORD');
        $sg = new \SendGrid($apiKey);

        $request_body = json_decode('{
                "contacts": [
                    {
                        "email": "' . $request->email . '",
                        "user_name" : "' . @$request->user_name . '",
                        "phone_number" : "' . @$request->phone . '"
                    }
                ],
                "list_ids":[
                    "081c7e27-20c9-4a29-838e-e41b62d7dd8d"
                    ]
            }');
        try {
            //saving in global list

            $response = $sg->client->marketing()->contacts()->put($request_body);

            if ($response->statusCode() == 202) {

                return sendSuccess('User Saved To Sendgrid Contacts!', []);
            } else {
                return sendError('msg', $response->body());
            }
        } catch (Exception $ex) {
            return sendError('Exception!', $response->body());
        }
    }

    public function emailToChilds(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'emails' => 'required',
            'parent_id' => 'required'
        ]);
        if ($validator->fails()) {
            return sendError('Validation Failed!', $validator->errors());
        }
        $apiKey = getenv('MAIL_PASSWORD');
        $sg = new \SendGrid($apiKey);
        $parent = User::where('_id', $request->parent_id)->first();
        // $arr = collect();
        if ($parent) {
            $password = "password";
            foreach ($request->emails as $email) {
                $exitingUser = User::where('email', $email)->first();
                if ($exitingUser) {
                    $exitingUser->parentId = $parent->_id;
                    $exitingUser->save();
                    $password = 'Please login with your old password! ';
                } else {

                    $user = new User();
                    $user->email = $email;
                    $user->password = Hash::make('password');
                    $user->parentId = $parent->_id;
                    $user->is_reset = 0;
                    $user->save();
                }


                //email
                $api_key = env('MAIL_PASSWORD');
                $api_url = "https://api.sendgrid.com/v3/mail/send";

                // Set the email details and template variables
                $to_email =  $email;
                $from_email = env('MAIL_FROM_ADDRESS');
                $template_id = "d-2d58bf14d855411897e43e96cde47eec";
                $template_vars = [
                    "email" => $email,
                    "password" => $password,
                    "parentName" => $parent->name
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
                            "dynamic_template_data" => $template_vars,
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
                // dd($response);

                $request_body = json_decode('{
                    "contacts": [
                        {
                            "email": "' . $email . '"
                        }
                    ],
                    "list_ids":[
                        "081c7e27-20c9-4a29-838e-e41b62d7dd8d"
                        ]
                }');


                $sg = new \SendGrid($apiKey);
                $sg->client->marketing()->contacts()->put($request_body);


                $request_body2 = json_decode('{
                    "contacts": [
                        {
                            "email": "' . $parent->email . '"
                        }
                    ],
                    "list_ids":[
                        "b0cb003e-2d44-40c0-a56a-8a0070f1ce14"
                        ]
                }');


                $sg = new \SendGrid($apiKey);
                $sg->client->marketing()->contacts()->put($request_body2);
            }
            return sendSuccess('Email Has Been Sent To Users!', []);
        } else {
            return sendError('User Not Found !', []);
        }
    }
}
