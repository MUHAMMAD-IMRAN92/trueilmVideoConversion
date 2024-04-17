<?php

namespace App\Imports;

use App\Models\InstitueUser;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;

class InstituteUserImport implements ToModel, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function model(array $row)
    {
        if (!InstitueUser::where('email', $row['email'])->first()) {
            $user = new InstitueUser();
            $user->name = $row['name'];
            $user->email = $row['email'];
            $user->institute_id =  auth()->user()->_id;
            $user->user_id =  null;
            $user->save();

            $api_key = env('MAIL_PASSWORD');
            $api_url = "https://api.sendgrid.com/v3/mail/send";

            // Set the email details and template variables
            $to_email =  $user->email;
            $from_email = env('MAIL_FROM_ADDRESS');
            $template_id = "d-2fa42cbbaef44184977f05de22616359";
            $template_vars = [
                'parentName' => auth()->user()->name,
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
        }
    }
}
