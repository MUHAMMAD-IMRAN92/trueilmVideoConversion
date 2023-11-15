<?php

namespace App\Http\Controllers;

use App\Models\SubcriptionEmail;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EmailExport;
use App\Imports\AlQUranTranslationImport;
use App\Imports\HadeesImport;
use App\Imports\HadeesTranslationImport;
use App\Mail\NewsletterVarification;
use App\Mail\NewsletterAdmin;
use App\Models\AlQuran;
use App\Models\AlQuranTranslation;
use App\Models\Juz;
use App\Models\Surah;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Jobs\SurahCombination as SurahCombinationJob;
use App\Models\Book;
use App\Models\BookForSale;
use App\Models\Course;
use App\Models\Glossory;
use App\Models\Hadees;
use App\Models\HadeesTranslation;
use App\Models\Khatoot;
use Berkayk\OneSignal\OneSignalFacade;
use GuzzleHttp\Client as GuzzleHttpClient;
use Illuminate\Support\Facades\Validator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Meilisearch\Client;
use Meilisearch\Contracts\SearchQuery;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use OneSignal;

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
    public function translationFileStore(Request $request)
    {
        return $request->all();

        if ($request->content_type == 1) {
            //here will translation of AlQuran
            if ($request->file_type == 1) {
                Excel::import(new AlQUranTranslationImport(1), $request->file);
            } elseif ($request->file_type == 2) {
                Excel::import(new AlQUranTranslationImport(2), $request->file);
            }
        } else {
            //here will translation of Al-Hadith
            if ($request->file_type == 3) {
                Excel::import(new HadeesImport($request->book_id), $request->file);
            } elseif ($request->file_type == 4) {
                Excel::import(new HadeesTranslationImport, $request->file);
            }
        }
    }
    public function renderApi()
    {
        ini_set('max_execution_time', '0');
        $khatoots = ['uthmani', 'indopak', 'uthmani_tajweed'];
        Khatoot::truncate();
        foreach ($khatoots as $key => $khatoot) {
            $alQuran = AlQuran::get();
            foreach ($alQuran as $key => $verse) {

                $url = Http::get("https://api.quran.com/api/v4/quran/verses/$khatoot?verse_key=$verse->verse_key");
                $ayat = json_decode($url->body());
                $alQuran = new Khatoot();
                $alQuran->surah_id = $verse->surah_id;
                if ($khatoot == 'uthmani') {
                    $alQuran->ayat = $ayat->verses[0]->text_uthmani;
                    $alQuran->type = 1;
                } elseif ($khatoot == 'indopak') {
                    $alQuran->ayat = $ayat->verses[0]->text_indopak;
                    $alQuran->type = 2;
                } else {
                    $alQuran->ayat = $ayat->verses[0]->text_uthmani_tajweed;
                    $alQuran->type = 3;
                }
                $alQuran->alQuran_id = $verse->_id;
                $alQuran->verse_key = $verse->verse_key;
                $alQuran->save();
            }
        }

        return 'done';
    }
    // text_indopak
    // text_uthmani_tajweed
    public function AlQuranTranslations($translation_id, $combination_id)
    {
        ini_set('max_execution_time', '0');

        AlQuranTranslation::where('author_lang', $combination_id)->delete();

        $alQuran = AlQuran::get();
        foreach ($alQuran as $key => $verse) {
            $url = Http::get("https://api.quran.com/api/v4/quran/translations/$translation_id?verse_key=$verse->verse_key");
            $response = json_decode($url->body());

            $alQuranTranslation = new AlQuranTranslation();

            $alQuranTranslation->translation = strip_tags($response->translations[0]->text);
            $alQuranTranslation->ayat_id = $verse->_id;
            $alQuranTranslation->surah_id = $verse->surah_id;
            $alQuranTranslation->author_lang = $combination_id;
            $alQuranTranslation->type = 1;
            $alQuranTranslation->added_by = '6447918217e6501d607f4943';
            $alQuranTranslation->save();

            SurahCombinationJob::dispatch($alQuranTranslation->surah_id, 1);
        }
        return 'save!';
    }
    function search(Request $request)
    {
        ini_set("memory_limit", "-1");


        $client = new  Client('http://localhost:7700', '3bc7ba18215601c4de218ef53f0f90e830a7f144');
        $arrIndex = [1 => 'ebooks', 2 => 'audio', 3 => 'papers', 4 => 'alQurantranslations', 5 => 'alHadeestranslations', 6 =>  'course', 7 => 'podcast', 8 => 'bookForSale', 9 => 'glossary'];
        $queries = [];
        if ($request->type != "") {
            // $arr = explode(',', $request->type);
            foreach ($request->type as $ar) {
                $queries[] = (new SearchQuery())
                    ->setIndexUid($arrIndex[$ar])
                    ->setQuery($request->search)
                    ->setLimit(20);
            }
            $res = $client->multiSearch($queries);

            foreach ($res['results'] as $r) {
                if ($r['indexUid'] == 'alHadeestranslations') {
                    foreach ($r['hits'] as $h) {
                        $Hadith = Hadees::where('_id',  $h['hadees_id'])->first();
                        array_push($h, ['imran' => 'imran']);
                        // $h['Hadith'] = 'test';
                    }
                }
            }
        } else {
            $res = $client->multiSearch([
                (new SearchQuery())
                    ->setIndexUid('ebooks')
                    ->setQuery($request->search)
                    ->setLimit(20),
                (new SearchQuery())
                    ->setIndexUid('audio')
                    ->setQuery($request->search)
                    ->setLimit(20),
                (new SearchQuery())
                    ->setIndexUid('papers')
                    ->setQuery($request->search)
                    ->setLimit(20),
                (new SearchQuery())
                    ->setIndexUid('podcast')
                    ->setQuery($request->search)
                    ->setLimit(20),
                (new SearchQuery())
                    ->setIndexUid('alQurantranslations')
                    ->setQuery($request->search)
                    ->setLimit(20),
                (new SearchQuery())
                    ->setIndexUid('alHadeestranslations')
                    ->setQuery($request->search)
                    ->setLimit(20),
                (new SearchQuery())
                    ->setIndexUid('course')
                    ->setQuery($request->search)
                    ->setLimit(20),
                (new SearchQuery())
                    ->setIndexUid('bookForSale')
                    ->setQuery($request->search)
                    ->setLimit(20),
                (new SearchQuery())
                    ->setIndexUid('glossary')
                    ->setQuery($request->search)
                    ->setLimit(20),
            ]);
        }
        return response()->json($res);
    }
    function indexTranslation(Request $request)
    {
        ini_set("memory_limit", "-1");
        $client = new  Client('http://localhost:7700', '3bc7ba18215601c4de218ef53f0f90e830a7f144');
        $data = AlQuranTranslation::get()->toArray();
        foreach ($data as $d) {
            $alQurantranslationsclient =  $client->index('alQurantranslations')->addDocuments($d, '_id');
        }
        return $client->getTask(13);

        return response()->json($alQurantranslationsclient);
    }


    function searchTest(Request $request)
    {
        // return ;
        ini_set("memory_limit", "-1");
        $validator = Validator::make($request->all(), [
            'type' => 'array',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $client = new  Client('http://localhost:7700', '3bc7ba18215601c4de218ef53f0f90e830a7f144');
        $arrIndex = [1 => 'ebooks', 2 => 'audio', 3 => 'papers', 4 => 'alQurantranslations', 5 => 'alHadeestranslations', 6 =>  'course', 7 => 'podcast', 8 => 'bookForSale', 9 => 'glossary'];
        $queries = [];
        if ($request->type != "" || count($request->type) != 0) {
            // $arr = explode(',', $request->type);
            foreach ($request->type as $ar) {
                $queries[] = (new SearchQuery())
                    ->setIndexUid($arrIndex[$ar])
                    ->setQuery($request->search)
                    ->setLimit(20);
            }
            $res = $client->multiSearch($queries);
        } else {
            $res = $client->multiSearch([
                (new SearchQuery())
                    ->setIndexUid('ebooks')
                    ->setQuery($request->search)
                    ->setLimit(20),
                (new SearchQuery())
                    ->setIndexUid('audio')
                    ->setQuery($request->search)
                    ->setLimit(20),
                (new SearchQuery())
                    ->setIndexUid('papers')
                    ->setQuery($request->search)
                    ->setLimit(20),
                (new SearchQuery())
                    ->setIndexUid('podcast')
                    ->setQuery($request->search)
                    ->setLimit(20),
                (new SearchQuery())
                    ->setIndexUid('alQurantranslations')
                    ->setQuery($request->search)
                    ->setLimit(20),
                (new SearchQuery())
                    ->setIndexUid('alHadeestranslations')
                    ->setQuery($request->search),
                (new SearchQuery())
                    ->setIndexUid('course')
                    ->setQuery($request->search),
                (new SearchQuery())
                    ->setIndexUid('bookForSale')
                    ->setQuery($request->search),
                (new SearchQuery())
                    ->setIndexUid('glossary')
                    ->setQuery($request->search),
            ]);
        }
        return response()->json($res);
    }
    public function generateQr(Request $request)
    {
        // return redirect()->to('/');
        $svgContent = QrCode::size(300)->color(27, 35, 83)->margin(1)->generate($request->value);
        $base64SVG = base64_encode($svgContent);

        return response()->json(
            $base64SVG,
        );
    }
    public function notification()
    {
        \OneSignal::sendNotificationToUser("Test Message", "b0263e5f-3da2-43eb-bce5-2effdc500dd5", $url = null, $data = null);

        return 'sent!';
    }
    public function audios()
    {
        ini_set('max_execution_time', 0);
        $alQuran  = AlQuran::get();
        foreach ($alQuran as $key => $verse) {

            $url = Http::get("https://api.quran.com/api/v4/recitations/3/by_ayah/$verse->verse_key");
            $ayat = json_decode($url->body());;

            $url = 'https://verses.quran.com/' . $ayat->audio_files[0]->url;
            $client = new GuzzleHttpClient();
            $response = $client->get($url);

            $modifiedFileName = 'audios/1/6554a22481f11c8450d5cedc/' . str_replace(':', '_', $verse->verse_key) . '.mp3';

            Storage::disk('s3')->put($modifiedFileName, $response->getBody());
        }

        return 'done';
        // return Storage::disk('s3')->get('653686c4468e05bace11873d/1_1.mp3');
    }

    public function AlQuranTafseer()
    {
        ini_set('max_execution_time', '0');

        AlQuranTranslation::where('author_lang', '65546dd181f11c8450d5cec8')->delete();
        AlQuranTranslation::where('author_lang', '65546f0381f11c8450d5cecd')->delete();
        AlQuranTranslation::where('author_lang', '655470dd81f11c8450d5cece')->delete();
        // return '1';
        $alQuran = AlQuran::get();
        foreach ($alQuran as $key => $verse) {
            $url = Http::get("https://api.quran.com/api/v4/quran/tafsirs/160?verse_key=$verse->verse_key");
            $response = json_decode($url->body());

            foreach ($response->tafsirs as $tafser) {
                // return $tafser->resource_id;
                if ($tafser->resource_id == 14) {
                    $alQuranTranslation = new AlQuranTranslation();

                    $alQuranTranslation->translation = strip_tags($tafser->text);
                    $alQuranTranslation->author_lang = '65546dd181f11c8450d5cec8';
                    $alQuranTranslation->ayat_id = $verse->_id;
                    $alQuranTranslation->surah_id = $verse->surah_id;
                    $alQuranTranslation->type = 2;
                    $alQuranTranslation->added_by = '6447918217e6501d607f4943';
                    $alQuranTranslation->save();

                    SurahCombinationJob::dispatch($alQuranTranslation->surah_id, 2);
                }
                if ($tafser->resource_id == 93) {
                    $alQuranTranslation = new AlQuranTranslation();

                    $alQuranTranslation->translation = strip_tags($tafser->text);
                    $alQuranTranslation->author_lang = '65546f0381f11c8450d5cecd';
                    $alQuranTranslation->ayat_id = $verse->_id;
                    $alQuranTranslation->surah_id = $verse->surah_id;
                    $alQuranTranslation->type = 2;
                    $alQuranTranslation->added_by = '6447918217e6501d607f4943';
                    $alQuranTranslation->save();

                    SurahCombinationJob::dispatch($alQuranTranslation->surah_id, 2);
                }
                if ($tafser->resource_id == 16) {
                    $alQuranTranslation = new AlQuranTranslation();

                    $alQuranTranslation->translation = strip_tags($tafser->text);
                    $alQuranTranslation->author_lang = '655470dd81f11c8450d5cece';
                    $alQuranTranslation->ayat_id = $verse->_id;
                    $alQuranTranslation->surah_id = $verse->surah_id;
                    $alQuranTranslation->type = 2;
                    $alQuranTranslation->added_by = '6447918217e6501d607f4943';
                    $alQuranTranslation->save();

                    SurahCombinationJob::dispatch($alQuranTranslation->surah_id, 2);
                }
            }
        }
        return 'save!';
    }

    public function QuranEncTranslation($key, $combination_id)
    {
        AlQuranTranslation::where('author_lang', $combination_id)->delete();
        for ($i = 1; $i < 115; $i++) {

            $surah = Surah::where('sequence', $i)->first();
            if ($surah) {
                $surah = $surah;
            }

            $url = Http::get("https://quranenc.com/api/v1/translation/sura/$key/$i");
            $response = json_decode($url->body());
            foreach ($response->result as  $res) {

                $ayaNo = $res->sura . ':' . $res->aya;
                $alQuran = AlQuran::where('verse_key',  $ayaNo)->first();

                $alQuranTranslation = new AlQuranTranslation();
                // $alQuranTranslation->lang = $lang;`

                // [1] preg_replace('/\[[^\]]*\]/', '', $res->translation)
                // 1. \Str::after($res->translation, '.');
                $alQuranTranslation->translation = \Str::after($res->translation, '.');
                $alQuranTranslation->ayat_id = $alQuran->id;
                $alQuranTranslation->added_by = '6447918217e6501d607f4943';
                $alQuranTranslation->surah_id = $alQuran->surah_id;
                $alQuranTranslation->author_lang = $combination_id;
                $alQuranTranslation->type = 1;

                $alQuranTranslation->save();
                SurahCombinationJob::dispatch($alQuranTranslation->surah_id, 1);
            }
        }


        return 'done';
    }
}

//lang
// 6548d27080681501aab8029d

//auth

// 6548d41380681501aab802a0

// 23dd802e-bc08-418a-b0c6-0763bb8f784b
//./meilisearch --master-key="3bc7ba18215601c4de218ef53f0f90e830a7f144"
