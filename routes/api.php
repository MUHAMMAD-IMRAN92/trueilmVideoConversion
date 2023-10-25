<?php

use App\Http\Controllers\Api\UserController;
use App\Models\AlQuranTranslation;
use App\Models\Book;
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

//stripe
Route::post('stripe/add-card-customer', [App\Http\Controllers\Api\StripeController::class, 'createCusCard']);
Route::post('stripe/subscribe-plan', [App\Http\notification\Api\StripeController::class, 'subscribe']);


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
    $book = Book::where('type', "1")->first();
    return $client->index('ebooks')->getDocument($book->_id, ['id', 'title']);

    // $book7= Book::where('ebooks', "7")->get()->toArray();

    // $booksclient =  $client->index('podcast')->addDocuments($book7, '_id');
    // return 'ok';
});

Route::get('qr/generate',  [App\Http\Controllers\HomeController::class, 'generateQr']);
Route::get('notification',  [App\Http\Controllers\HomeController::class, 'notification']);


Route::get('recetation_audios',  [App\Http\Controllers\HomeController::class, 'audios']);
