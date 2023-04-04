<?php

use App\Models\User;
use Illuminate\Http\Request;
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
});
