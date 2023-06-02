<?php

use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::get('send-varification-email',  [App\Http\Controllers\Api\UserController::class, 'sendVerifyEmail']);
Route::get('reset-password-email',  [App\Http\Controllers\Api\UserController::class, 'resetPassword']);

//stripe
Route::get('stripe/add-card-customer', [App\Http\Controllers\Api\StripeController::class, 'createCusCard']);
