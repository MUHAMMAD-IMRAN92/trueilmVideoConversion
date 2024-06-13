<?php

use App\Http\Controllers\Api\UserController;
use App\Models\AlQuran;
use App\Models\AlQuranTranslation;
use App\Models\AuthorLanguage;
use App\Models\Book;
use App\Models\BookContent;
use App\Models\Course;
use App\Models\CourseLesson;
use App\Models\HadeesTranslation;
use App\Models\Surah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Meilisearch\Client;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//sending emails
Route::post('send-varification-email',  [App\Http\Controllers\Api\UserController::class, 'sendVerifyEmail']);
Route::post('reset-password-email',  [App\Http\Controllers\Api\UserController::class, 'resetPassword']);

//email notify me
Route::post('/notify_me', [App\Http\Controllers\HomeController::class, 'notifyMe']);

//stripe
Route::post('stripe/add-card-customer', [App\Http\Controllers\Api\StripeController::class, 'createCusCard']);
Route::post('stripe/subscribe-plan', [App\Http\Controllers\Api\StripeController::class, 'subscribe']);

Route::post('stripe/session_url', [App\Http\Controllers\Api\StripeController::class, 'sessionUrl']);
Route::post('stripe/webhook', [App\Http\Controllers\Api\StripeController::class, 'webhook']);

Route::post('search',  [App\Http\Controllers\HomeController::class, 'search']);
Route::post('searchTest',  [App\Http\Controllers\HomeController::class, 'searchTest']);

//quiz
Route::post('quiz',  [App\Http\Controllers\Api\QuizController::class, 'quiz']);
Route::post('check_answer',  [App\Http\Controllers\Api\QuizController::class, 'checkAnswer']);
Route::post('attempt_result',  [App\Http\Controllers\Api\QuizController::class, 'attemptResult']);
Route::post('check_expiry',  [App\Http\Controllers\Api\QuizController::class, 'checkExpiry']);

//sendgrid save user to contact list
Route::post('save-to-sendgrid-list',  [App\Http\Controllers\Api\UserController::class, 'saveToSendGrid']);


Route::post('send_email_to_childs',  [App\Http\Controllers\Api\UserController::class, 'emailToChilds']);


Route::get('search/index',  [App\Http\Controllers\HomeController::class, 'indexTranslation']);
// 65c9f0991d686f043b027302
Route::get('/quran/index/{id}', function ($id) {
    ini_set("memory_limit", "-1");
    // $arrIndex = [1 => 'ebook', 2 => 'audio', 3 => 'paper', 4 => 'alQurantranslations', 5 => 'alHadeestranslations', 6 =>  'course', 7 => 'podcast', 10 => "courseLesson", 11 => "podcastEpisode", 12 => "audioChapter"];

    $client = new  Client('http://localhost:7700', '3bc7ba18215601c4de218ef53f0f90e830a7f144');
    // $client->createIndex('alHadeestranslations');
    $authorLanguages = AuthorLanguage::whereIn('type', [1, 2])->get();
    foreach ($authorLanguages as $authorLang) {

        $translation = AlQuranTranslation::where('author_lang', $authorLang->_id)->get()->map(function ($tran) {
            // $tran->main_chapter = $tran->mainChapter();
            $tran->author_id = $tran->author();
            $tran->lang_id = $tran->language();

            return $tran;
        });
        $client->index('alQurantranslations')->addDocuments($translation->toArray(), '_id');
    }
    return 'ok';

    // $alQuran = AlQuranTranslation::where('author_lang', $id)->get();
    // $book = Book::where('type', '7')->where('approved', 1)->where('status', 1)->get()->toArray();
    // $client->index('alQurantranslations')->addDocuments($alQuran->toArray());
    // return $client->index('ebook')->getDocument($book->_id, ['id', 'title']);

    // $book1 = Book::where('type', "1")->where('status', 1)->where('approved', 1)->get()->toArray();
    // $booksclient =  $client->index('ebook')->addDocuments($book1, '_id');
    // $book2 = Book::where('type', "2")->where('status', 1)->where('approved', 1)->get()->toArray();
    // $booksclient =  $client->index('audio')->addDocuments($book2, '_id');
    // $book7 = Book::where('type', "7")->where('status', 1)->where('approved', 1)->get()->toArray();

    // $booksclient =  $client->index('podcast')->addDocuments($book7, '_id');
    // $bookc = Course::where('status', 1)->where('approved', 1)->get()->toArray();
    // $booksclient =  $client->index('course')->addDocuments($bookc, '_id');
    return 'ok';
});
Route::get('/course/index', function () {
    ini_set("memory_limit", "-1");
    set_time_limit(0);
    $client = new  Client('http://localhost:7700', '3bc7ba18215601c4de218ef53f0f90e830a7f144');
    $arrIndex = [1 => 'ebook', 2 => 'audio', 3 => 'paper', 4 => 'alQurantranslations', 5 => 'alHadeestranslations', 6 =>  'course', 7 => 'podcast', 10 => "courseLesson", 11 => "podcastEpisode", 12 => "audioChapter"];
    foreach ($arrIndex as $key => $arr) {
        $client->createIndex($arr, ['primaryKey' => '_id']);
        if ($key == 1 || $key == 2 || $key == 3 || $key == 7) {
            $client->deleteIndex($arr);
            $client->createIndex($arr, ['primaryKey' => '_id']);
            $book = Book::where('type', (string) $key)->where('approved', 1)->where('status', 1)->get()->toArray();
            $client->index($arr)->addDocuments($book);
        }
        // if ($key == 6) {
        //     $book = Course::get()->toArray();
        //     $client->index($arr)->addDocuments($book);
        // }
        // if ($key == 7) {
        //     $client->deleteIndex($arr);
        //     $client->createIndex($arr, ['primaryKey' => '_id']);
        //     $book = CourseLesson::get()->toArray();
        //     $client->index($arr)->addDocuments($book);
        // }
        if ($key == 11) {
            $client->deleteIndex($arr);
            $client->createIndex($arr, ['primaryKey' => '_id']);
            $book = Book::where('type', (string) 7)->where('approved', 1)->where('status', 1)->get()->pluck('_id');
            $books = BookContent::whereIn('book_id', $book)->get()->toArray();
            $client->index($arr)->addDocuments($books);
        }
        // if ($key == 12) {
        //     $book = Book::where('type', (string) 2)->get()->pluck('_id');
        //     $books = BookContent::whereIn('book_id', $book)->get()->toArray();
        //     $client->index($arr)->addDocuments($books);
        // }
        // if ($key == 4) {
        //     // $client->deleteIndex($arr);
        //     $client->createIndex($arr, ['primaryKey' => '_id']);

        //     $book = AlQuranTranslation::where('author_lang', '65aa5d64c5da12cc4d009911')->where('type', 1)->get();
        //     $client->index($arr)->addDocuments($book->toArray());
        // }
        // if ($key == 5) {
        //     // $client->deleteIndex($arr);
        //     $client->createIndex($arr, ['primaryKey' => '_id']);
        //     $book = HadeesTranslation::where('book_id', '655f47441c3df94998007a1a')->where('type', 5)->get();

        //     $client->index($arr)->addDocuments($book->toArray());
        // }
    }
    return 'ok';
});
Route::get('qr/generate',  [App\Http\Controllers\HomeController::class, 'generateQr']);
Route::get('notification',  [App\Http\Controllers\HomeController::class, 'notification']);


Route::get('AlQuranTafseer',  [App\Http\Controllers\HomeController::class, 'AlQuranTafseer']);
Route::get('audioapi',  [App\Http\Controllers\HomeController::class, 'audios']);


Route::get('translations_api_rendering', [App\Http\Controllers\HomeController::class, 'AlQuranTranslations']);
Route::get('QuranEncTranslation',  [App\Http\Controllers\HomeController::class, 'QuranEncTranslation']);

// middleware(['checkUserToken'])->
Route::prefix('v2')->group(function () {
    Route::get('/', function () {
        return 'test';
    });

    Route::post('send_email_to_childs',  [App\Http\Controllers\Api\UserController::class, 'emailToChilds']);
    Route::post('reset-password-email',  [App\Http\Controllers\Api\UserController::class, 'resetPassword']);

    Route::post('search',  [App\Http\Controllers\HomeController::class, 'searchV2']);
    Route::get('books_courses/{type}',  [App\Http\Controllers\HomeController::class, 'getBooksCourses']);
});
