<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\ResetPassword;
use App\Mail\UserVarification;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
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

        $user = User::where('email', $request->email)->first();
        if ($user) {
            $userEmail = $user->email;
            // Mail::to($userEmail)->send(new UserVarification($user));
            $api_key = env('MAIL_PASSWORD');
            $api_url = "https://api.sendgrid.com/v3/mail/send";

            // Set the email details and template variables
            $to_email =  $user->email;
            $from_email = env('MAIL_FROM_ADDRESS');
            $template_id = "d-b6a996c0c8f04d71bcf05f77d983f2e6";
            $template_vars = [
                'id' => $user->_id,
                'email' => $userEmail
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
                    ],
                    "dynamic_template_data" => $template_vars
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
                    'id' => $user->_id
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
            } catch (\Exception $e) {
                return $e->getMessage();
            }
        } else {
            return sendError('User Not Found!', []);
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
                            "email": "' . $request->email . '"
                        }
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
}
