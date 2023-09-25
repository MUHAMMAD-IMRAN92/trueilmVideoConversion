<?php

use App\Http\Controllers\Api\UserController;
use App\Models\AlQuranTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Meilisearch\Client;

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
Route::post('stripe/subscribe-plan', [App\Http\Controllers\Api\StripeController::class, 'subscribe']);


Route::post('search',  [App\Http\Controllers\HomeController::class, 'search']);
Route::get('search/index',  [App\Http\Controllers\HomeController::class, 'indexTranslation']);
Route::get('searching', function () {
    ini_set("memory_limit", "-1");
    $client = new  Client('http://localhost:7700', '3bc7ba18215601c4de218ef53f0f90e830a7f144');
  return  $data = AlQuranTranslation::take(100)->get()->toArray();
    foreach ($data as $d) {
        $alQurantranslationsclient =  $client->index('alQurantranslations')->addDocuments($data, '_id');

        echo ($alQurantranslationsclient['taskUid'] . '</br>');
        echo ($client->getTask($alQurantranslationsclient['taskUid']) . '</br>');
    }
    return response()->json($alQurantranslationsclient);
});
