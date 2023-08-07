<?php

namespace App\Http\Controllers;

use App\Models\SubcriptionEmail;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EmailExport;
use App\Mail\NewsletterVarification;
use App\Mail\NewsletterAdmin;
use App\Models\AlQuran;
use App\Models\AlQuranTranslation;
use App\Models\Surah;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public $user;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();

            return $next($request);
        });
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function saveEmail(Request $request)
    {
        $email = new SubcriptionEmail();
        $email->email = $request->email;
        $email->save();
        // Mail::to($email->email)->send(new NewsletterVarification($email));
        // Mail::send(new NewsletterAdmin($email));
        try {
            $api_key = env('MAIL_PASSWORD');
            $api_url = "https://api.sendgrid.com/v3/mail/send";

            // Set the email details and template variables
            $to_email =  $email->email;
            $from_email = env('MAIL_FROM_ADDRESS');
            $template_id = "d-597d210c4a514c7982b774607a93738a";
            $template_vars = [];

            // Set the payload as a JSON string
            $payload = json_encode([
                "personalizations" => [
                    [
                        "to" => [
                            [
                                "email" => $to_email
                            ]
                        ],
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


            //Admin Email
            $to_email =  'salam@trueilm.com';
            $from_email = env('MAIL_FROM_ADDRESS');
            $template_id = "d-9c8e85a4e7e144df80d4b725d4e55634";
            $template_vars = [
                'email' => $email->email
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

            // Handle the response

            return redirect()->back()->with('msg', 'You are subscribed successfully!');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function allEmails()
    {
        return view('user.subscriptions');
    }
    public function allSubscriptionEmail(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $search = $request->search['value'];
        $totalBrands = SubcriptionEmail::whereNotNull('email')->count();
        $brands = SubcriptionEmail::whereNotNull('email')->when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('email', 'like', "%$search%");
            });
        })->skip((int) $start)->take((int) $length)->get();
        $brandsCount = SubcriptionEmail::whereNotNull('email')->when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('email', 'like', "%$search%");
            });
        })->skip((int) $start)->take((int) $length)->count();
        $data = array(
            'draw' => $draw,
            'recordsTotal' => $totalBrands,
            'recordsFiltered' => $brandsCount,
            'data' => $brands,
        );
        return json_encode($data);
    }
    public function exportEmail()
    {
        return Excel::download(new EmailExport, 'Emails.xlsx');
    }

    public function sendEmailToPrevoius(Request $request)
    {
        ini_set('max_execution_time', 0);
        $emails =  SubcriptionEmail::all();
        foreach ($emails as $email) {
            Mail::to($email->email)->send(new NewsletterVarification($email));
            Mail::to(env('MAIL_FROM_NAME'))->send(new NewsletterAdmin($email));
        }
        return 'sent successfully!';
    }

    public function renderApi()
    {
        // AlQuran::truncate();
        // AlQuranTranslation::truncate();
        // return 'ok';
        // return 'imrna';
        for ($i = 1; $i < 115; $i++) {
            echo $i;
            $url = Http::get("https://quranenc.com/api/v1/translation/sura/english_saheeh/$i" );
            $alQuran = new Surah();
            $alQuran->surah = $i;
            $alQuran->description = '';
            $alQuran->type = 1;
            $alQuran->sequence = $i;
            $alQuran->save();

            $response = json_decode($url->body());
            foreach ($response->result as $key=> $res) {
                $alQuran = new AlQuran();
                $alQuran->surah_id = $i;
                $alQuran->ayat = $res->arabic_text;
                $alQuran->para_no = 0;
                $alQuran->added_by = $this->user->id;
                $alQuran->manzil = 0;
                $alQuran->ruku =0;
                $alQuran->sequence = $key;
                $alQuran->sajda = 0;
                $alQuran->waqf = 0;
                $alQuran->save();

                $alQuranTranslation = new AlQuranTranslation();
                // $alQuranTranslation->lang = $lang;
                $alQuranTranslation->translation =  $res->translation;
                $alQuranTranslation->ayat_id = $alQuran->id;
                $alQuranTranslation->added_by = $this->user->id;
                $alQuranTranslation->author_lang = '64d092c46dd0f156aa051ec5';
                $alQuranTranslation->type = 1;
                $alQuranTranslation->save();
            }
        }
        return 'done';
    }
}
// english_saheeh
// urdu_junagarhi
// malayalam_kunhi
