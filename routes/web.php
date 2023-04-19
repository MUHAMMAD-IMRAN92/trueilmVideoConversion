<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use MongoDB\Client;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::get('al-Quran', [App\Http\Controllers\AlQuranController::class, 'index'])->name('al-Quran');
    Route::get('all-surah', [App\Http\Controllers\AlQuranController::class, 'allAyat'])->name('ayat');
    Route::get('ayat/create', [App\Http\Controllers\AlQuranController::class, 'add'])->name('ayat.add');
    Route::post('ayat/store', [App\Http\Controllers\AlQuranController::class, 'store'])->name('ayat.store');
    Route::get('ayat/edit/{id}', [App\Http\Controllers\AlQuranController::class, 'edit'])->name('ayat.edit');
    Route::post('ayat/update', [App\Http\Controllers\AlQuranController::class, 'update'])->name('ayat.update');

    Route::get('publisher', [App\Http\Controllers\PublisherController::class, 'index'])->name('publisher');
    Route::get('all-publisher', [App\Http\Controllers\PublisherController::class, 'allPublisher'])->name('publisher.all');
    Route::get('publisher/create', [App\Http\Controllers\PublisherController::class, 'add'])->name('publisher.add');
    Route::post('publisher/store', [App\Http\Controllers\PublisherController::class, 'store'])->name('publisher.store');
    Route::get('publisher/edit/{id}', [App\Http\Controllers\PublisherController::class, 'edit'])->name('publisher.edit');
    Route::post('publisher/update', [App\Http\Controllers\PublisherController::class, 'update'])->name('publisher.update');


    Route::get('hadith', [App\Http\Controllers\HadeesController::class, 'index'])->name('hadith');
    Route::get('all-hadith', [App\Http\Controllers\HadeesController::class, 'allhadith'])->name('hadith');
    Route::get('hadith/create', [App\Http\Controllers\HadeesController::class, 'add'])->name('hadith.add');
    Route::post('hadith/store', [App\Http\Controllers\HadeesController::class, 'store'])->name('hadith.store');
    Route::get('hadith/edit/{id}', [App\Http\Controllers\HadeesController::class, 'edit'])->name('hadith.edit');
    Route::post('hadith/update', [App\Http\Controllers\HadeesController::class, 'update'])->name('hadith.update');


    Route::get('eBook', [App\Http\Controllers\BookController::class, 'index'])->name('eBook');
    Route::get('all-eBook', [App\Http\Controllers\BookController::class, 'allPublisher'])->name('eBook.all');
    Route::get('eBook/create', [App\Http\Controllers\BookController::class, 'add'])->name('eBook.add');
    Route::post('eBook/store', [App\Http\Controllers\BookController::class, 'store'])->name('eBook.store');
    Route::get('eBook/edit/{id}', [App\Http\Controllers\BookController::class, 'edit'])->name('eBook.edit');
    Route::post('eBook/update', [App\Http\Controllers\BookController::class, 'update'])->name('eBook.update');

    Route::get('user-management', [App\Http\Controllers\UserController::class, 'index'])->name('user.index');
    Route::get('all-user', [App\Http\Controllers\UserController::class, 'allUser'])->name('user.all');
    Route::get('user/create', [App\Http\Controllers\UserController::class, 'add'])->name('user.add');
    Route::post('user/store', [App\Http\Controllers\UserController::class, 'store'])->name('user.store');
    Route::get('user/edit/{id}', [App\Http\Controllers\UserController::class, 'edit'])->name('user.edit');
    Route::post('user/update', [App\Http\Controllers\UserController::class, 'update'])->name('user.update');
});
