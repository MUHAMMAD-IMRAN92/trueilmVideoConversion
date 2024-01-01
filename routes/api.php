<?php

use App\Http\Controllers\Api\UserController;
use App\Models\AlQuranTranslation;
use App\Models\Book;
use App\Models\BookContent;
use App\Models\Course;
use App\Models\CourseLesson;
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


Route::get('search/index',  [App\Http\Controllers\HomeController::class, 'indexTranslation']);

Route::get('/delete/index', function () {
    ini_set("memory_limit", "-1");
    $client = new  Client('http://localhost:7700', '3bc7ba18215601c4de218ef53f0f90e830a7f144');
    $client->deleteIndex('ebook');


    $client->createIndex('ebook', ['primaryKey' => '_id']);

    $book = Book::get()->toArray();
    $client->index('ebook')->addDocuments($book);
    // return $client->index('ebooks')->getDocument($book->_id, ['id', 'title']);

    // $book7= Book::where('ebooks', "7")->get()->toArray();

    // $booksclient =  $client->index('podcast')->addDocuments($book7, '_id');
    return 'ok';
});

Route::get('qr/generate',  [App\Http\Controllers\HomeController::class, 'generateQr']);
Route::get('notification',  [App\Http\Controllers\HomeController::class, 'notification']);


Route::get('AlQuranTafseer',  [App\Http\Controllers\HomeController::class, 'AlQuranTafseer']);
Route::get('audioapi',  [App\Http\Controllers\HomeController::class, 'audios']);


Route::get('translations_api_rendering/{translation_id}/{combination_id}', [App\Http\Controllers\HomeController::class, 'AlQuranTranslations']);
Route::get('QuranEncTranslation/{key}/{combination_id}',  [App\Http\Controllers\HomeController::class, 'QuranEncTranslation']);
