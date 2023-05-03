<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use MongoDB\Client;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------s
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['domain' => '127.0.0.1'], function () {
    Route::get('/', function () {
        return view('static_page');
    });
});
Route::group(['domain' => 'admin.trueilm.com'], function () {
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

        Route::get('books/{type}', [App\Http\Controllers\BookController::class, 'index'])->name('books');
        Route::get('all-book', [App\Http\Controllers\BookController::class, 'allBooks'])->name('book.all');
        Route::get('book/{type}/create', [App\Http\Controllers\BookController::class, 'add'])->name('book.add');
        Route::post('book/store', [App\Http\Controllers\BookController::class, 'store'])->name('book.store');
        Route::get('book/{type}/edit/{id}', [App\Http\Controllers\BookController::class, 'edit'])->name('book.edit');
        Route::post('book/update', [App\Http\Controllers\BookController::class, 'update'])->name('book.update');
        Route::get('book/update-status/{id}', [App\Http\Controllers\BookController::class, 'updateStatus'])->name('book.statusUpdate');
        Route::get('book/pending-for-approval', [App\Http\Controllers\BookController::class, 'pendingForApprove'])->name('book.pendingForApprove');
        Route::get('all-pending-book', [App\Http\Controllers\BookController::class, 'allPendingForApprovalBooks'])->name('book.all-panding');
        Route::get('book/approve/{id}', [App\Http\Controllers\BookController::class, 'approveBook'])->name('book.approveBook');
        Route::get('book/reject/{id}', [App\Http\Controllers\BookController::class, 'rejectBook'])->name('book.approveBook');

        Route::get('user-management', [App\Http\Controllers\UserController::class, 'index'])->name('user.index');
        Route::get('all-user', [App\Http\Controllers\UserController::class, 'allUser'])->name('user.all');
        Route::get('user/create', [App\Http\Controllers\UserController::class, 'add'])->name('user.add');
        Route::post('user/store', [App\Http\Controllers\UserController::class, 'store'])->name('user.store');
        Route::get('user/edit/{id}', [App\Http\Controllers\UserController::class, 'edit'])->name('user.edit');
        Route::post('user/update', [App\Http\Controllers\UserController::class, 'update'])->name('user.update');
        Route::get('user/delete/{id}', [App\Http\Controllers\UserController::class, 'delete'])->name('user.delete');

        Route::get('categories/{type}', [App\Http\Controllers\CategoryController::class, 'index'])->name('categories');
        Route::get('all-category', [App\Http\Controllers\CategoryController::class, 'allCategory'])->name('category.all');
        Route::get('category/{type}/create', [App\Http\Controllers\CategoryController::class, 'create'])->name('category.add');
        Route::post('category/store', [App\Http\Controllers\CategoryController::class, 'store'])->name('category.store');
        Route::get('category/{type}/edit/{id}', [App\Http\Controllers\CategoryController::class, 'edit'])->name('category.edit');
        Route::post('categroy/update', [App\Http\Controllers\CategoryController::class, 'update'])->name('category.update');
        Route::get('category/update-status/{id}', [App\Http\Controllers\CategoryController::class, 'updateStatus'])->name('category.statusUpdate');

        Route::get('courses', [App\Http\Controllers\CourseController::class, 'index'])->name('courses');
        Route::get('all-courses', [App\Http\Controllers\CourseController::class, 'allCourses'])->name('courses.all');
        Route::get('course/create', [App\Http\Controllers\CourseController::class, 'add'])->name('course.add');
        Route::post('course/store', [App\Http\Controllers\CourseController::class, 'store'])->name('course.store');
        Route::get('course/edit/{id}', [App\Http\Controllers\CourseController::class, 'edit'])->name('course.edit');
        Route::post('course/update', [App\Http\Controllers\CourseController::class, 'update'])->name('course.update');
        Route::get('course/update-status/{id}', [App\Http\Controllers\CourseController::class, 'updateStatus'])->name('course.statusUpdate');
    });
});
