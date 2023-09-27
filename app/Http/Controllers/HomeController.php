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
use App\Models\HadeesTranslation;
use Meilisearch\Client;
use Meilisearch\Contracts\SearchQuery;

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

        AlQuran::truncate();
        AlQuranTranslation::truncate();

        for ($i = 1; $i < 115; $i++) {

            $surah  =  Surah::where('sequence', $i)->first();

            $url = Http::get("https://api.quran.com/api/v4/verses/by_chapter/$i?per_page=500");
            $response = json_decode($url->body());

            foreach ($response->verses as $key => $verse) {

                $url = Http::get("https://api.quran.com/api/v4/quran/verses/uthmani?verse_key=$verse->verse_key");
                $ayat = json_decode($url->body());

                $juz = Juz::where('juz', "LIKE", '%' . $verse->juz_number . '%')->first();

                $alQuran = new AlQuran();
                $alQuran->surah_id = $surah->id;
                $alQuran->ayat = $ayat->verses[0]->text_uthmani;
                $alQuran->verse_number = $verse->verse_number;
                $alQuran->sequence = $verse->verse_number;
                $alQuran->juz_no = $verse->juz_number;
                $alQuran->para_no = $juz->_id;
                $alQuran->added_by = $this->user->id;
                $alQuran->manzil = $verse->manzil_number;
                $alQuran->ruku = $verse->ruku_number;
                $alQuran->sequence = $verse->verse_number;
                $alQuran->sajda = $verse->sajdah_number;
                $alQuran->verse_key = $verse->verse_key;
                $alQuran->waqf = 0;
                $alQuran->save();
            }
        }
        return 'done';
    }
    public function AlQuranTranslations()
    {
        ini_set('max_execution_time', '0');

        // AlQuranTranslation::truncate();
        $alQuran = AlQuran::get();
        foreach ($alQuran as $key => $verse) {
            $url = Http::get("https://api.quran.com/api/v4/quran/translations/234?verse_key=$verse->verse_key");
            $response = json_decode($url->body());

            $alQuranTranslation = new AlQuranTranslation();

            $alQuranTranslation->translation = strip_tags($response->translations[0]->text);
            $alQuranTranslation->ayat_id = $verse->_id;
            $alQuranTranslation->surah_id = $verse->surah_id;
            $alQuranTranslation->author_lang = '650afac28704f705eb010142';
            $alQuranTranslation->type = 1;
            $alQuranTranslation->added_by = $this->user->id;
            $alQuranTranslation->save();

            SurahCombinationJob::dispatch($alQuranTranslation->surah_id);
        }
        return 'save!';
    }
    function search(Request $request)
    {
        ini_set("memory_limit", "-1");
        $client = new  Client('http://localhost:7700', '3bc7ba18215601c4de218ef53f0f90e830a7f144');

        if ($request->type == 1) {
            $res = $client->multiSearch([
                (new SearchQuery())
                    ->setIndexUid('ebooks')
                    ->setQuery($request->search)
                    ->setLimit(20),
            ]);
        } else if ($request->type == 2) {
            $res = $client->multiSearch([

                (new SearchQuery())
                    ->setIndexUid('audio')
                    ->setQuery($request->search)
                    ->setLimit(20),
            ]);
        } else if ($request->type == 3) {
            $res = $client->multiSearch([

                (new SearchQuery())
                    ->setIndexUid('papers')
                    ->setQuery($request->search),

            ]);
        } else if ($request->type == 4) {
            $res = $client->multiSearch([

                (new SearchQuery())
                    ->setIndexUid('alQurantranslations')
                    ->setQuery($request->search),

            ]);
        } else if ($request->type == 5) {
            $res = $client->multiSearch([

                (new SearchQuery())
                    ->setIndexUid('alHadeestranslations')
                    ->setQuery($request->search),
            ]);
        } else if ($request->type == 6) {
            $res = $client->multiSearch([

                (new SearchQuery())
                    ->setIndexUid('course')
                    ->setQuery($request->search),
            ]);
        } else if ($request->type == 7) {
            $res = $client->multiSearch([

                (new SearchQuery())
                    ->setIndexUid('podcast')
                    ->setQuery($request->search),
            ]);
        } else if ($request->type == 8) {
            $res = $client->multiSearch([

                (new SearchQuery())
                    ->setIndexUid('bookForSale')
                    ->setQuery($request->search),
            ]);
        } else if ($request->type == 9) {
            $res = $client->multiSearch([

                (new SearchQuery())
                    ->setIndexUid('glossary')
                    ->setQuery($request->search),
            ]);
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
        // $book = Book::get()->toArray();
        // $alQuranTranslation = AlQuranTranslation::get()->toArray();
        // $HadeesTranslation = HadeesTranslation::get()->toArray();
        // $booksclient =  $client->index('books')->addDocuments($book, '_id');
        // dd($booksclient);
        // $alQurantranslationsclient =  $client->index('alQurantranslations')->addDocuments($alQuranTranslation, '_id');
        // return  $alHadeestranslationsclient =  $client->index('alHadeestranslations')->addDocuments($HadeesTranslation, '_id');
        // // $book = json_decode($book);

        // // $movies_json = Storage::disk('public')->get('countries.json');
        // // $movies = json_decode($book);
        // $client->createIndex('book', ['primaryKey' => '_id']);

        // return $client->getTask(5);
        // $res = $client->multiSearch([
        //     (new SearchQuery())
        //         ->setIndexUid('books')
        //         ->setQuery($request->search)
        //         ->setLimit(20),
        //     (new SearchQuery())
        //         ->setIndexUid('alQurantranslations')
        //         ->setQuery($request->search)
        //         ->setLimit(5),
        //     (new SearchQuery())
        //         ->setIndexUid('alHadeestranslations')
        //         ->setQuery($request->search)
        // ]);
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
        ini_set("memory_limit", "-1");
        $client = new  Client('http://localhost:7700', '3bc7ba18215601c4de218ef53f0f90e830a7f144');

        if ($request->type == 1) {
            $res = $client->multiSearch([
                (new SearchQuery())
                    ->setIndexUid('ebooks')
                    ->setQuery($request->search)
                    ->setLimit(20),
            ]);
        } else if ($request->type == 2) {
            $res = $client->multiSearch([

                (new SearchQuery())
                    ->setIndexUid('audio')
                    ->setQuery($request->search)
                    ->setLimit(20),
            ]);
        } else if ($request->type == 3) {
            $res = $client->multiSearch([

                (new SearchQuery())
                    ->setIndexUid('papers')
                    ->setQuery($request->search),

            ]);
        } else if ($request->type == 4) {
            $res = $client->multiSearch([

                (new SearchQuery())
                    ->setIndexUid('alQurantranslations')
                    ->setQuery($request->search),

            ]);
        } else if ($request->type == 5) {
            $res = $client->multiSearch([

                (new SearchQuery())
                    ->setIndexUid('alHadeestranslations')
                    ->setQuery($request->search),
            ]);
        } else if ($request->type == 6) {
            $res = $client->multiSearch([

                (new SearchQuery())
                    ->setIndexUid('course')
                    ->setQuery($request->search),
            ]);
        } else if ($request->type == 7) {
            $res = $client->multiSearch([

                (new SearchQuery())
                    ->setIndexUid('podcast')
                    ->setQuery($request->search),
            ]);
        } else if ($request->type == 8) {
            $res = $client->multiSearch([

                (new SearchQuery())
                    ->setIndexUid('bookForSale')
                    ->setQuery($request->search),
            ]);
        } else if ($request->type == 9) {
            $res = $client->multiSearch([

                (new SearchQuery())
                    ->setIndexUid('glossary')
                    ->setQuery($request->search),
            ]);
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
        // $book = Book::get()->toArray();
        // $alQuranTranslation = AlQuranTranslation::get()->toArray();
        // $HadeesTranslation = HadeesTranslation::get()->toArray();
        // $booksclient =  $client->index('books')->addDocuments($book, '_id');
        // dd($booksclient);
        // $alQurantranslationsclient =  $client->index('alQurantranslations')->addDocuments($alQuranTranslation, '_id');
        // return  $alHadeestranslationsclient =  $client->index('alHadeestranslations')->addDocuments($HadeesTranslation, '_id');
        // // $book = json_decode($book);

        // // $movies_json = Storage::disk('public')->get('countries.json');
        // // $movies = json_decode($book);
        // $client->createIndex('book', ['primaryKey' => '_id']);

        // return $client->getTask(5);
        // $res = $client->multiSearch([
        //     (new SearchQuery())
        //         ->setIndexUid('books')
        //         ->setQuery($request->search)
        //         ->setLimit(20),
        //     (new SearchQuery())
        //         ->setIndexUid('alQurantranslations')
        //         ->setQuery($request->search)
        //         ->setLimit(5),
        //     (new SearchQuery())
        //         ->setIndexUid('alHadeestranslations')
        //         ->setQuery($request->search)
        // ]);
    }
}


//./meilisearch --master-key="3bc7ba18215601c4de218ef53f0f90e830a7f144"
