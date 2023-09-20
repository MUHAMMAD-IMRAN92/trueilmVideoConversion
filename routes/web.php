<?php

use App\Models\AlQuranTranslation;
use App\Models\Book;
use App\Models\Category;
use App\Models\Languages;
use App\Models\Surah;
use App\Models\SurahCombinations;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
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

Route::group(['domain' => 'trueilm.com'], function () {
    Route::get('/', function () {
        return view('static_page');
    });
    Route::post('/', [App\Http\Controllers\HomeController::class, 'saveEmail']);
});

Route::get('sendEmailToPrevoius',  [App\Http\Controllers\HomeController::class, 'sendEmailToPrevoius']);
Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    //Al-Quran
    Route::get('ayat/create/{id}', [App\Http\Controllers\AlQuranController::class, 'add'])->name('ayat.add');
    Route::post('ayat/store', [App\Http\Controllers\AlQuranController::class, 'store'])->name('ayat.store');
    Route::get('ayat/edit/{surah_id}/{ayat_id}', [App\Http\Controllers\AlQuranController::class, 'edit'])->name('ayat.edit');
    Route::post('ayat/update', [App\Http\Controllers\AlQuranController::class, 'update'])->name('ayat.update');
    Route::post('author_lang', [App\Http\Controllers\AlQuranController::class, 'authorLanguage'])->name('ayat.author_language');
    //Ayat Translations
    Route::get('ayat/translation/delete', [App\Http\Controllers\AlQuranController::class, 'deleteTranslation'])->name('ayat.translaton.delete');
    Route::post('ayat/translation/update', [App\Http\Controllers\AlQuranController::class, 'updateTranslation'])->name('ayat.translaton.update');
    Route::post('ayat/translation/save', [App\Http\Controllers\AlQuranController::class, 'saveTranslation'])->name('ayat.translaton.save');

    //Ayat Tafseer
    Route::get('ayat/tafseer/delete', [App\Http\Controllers\AlQuranController::class, 'deleteTafseer'])->name('ayat.tafseer.delete');
    Route::post('ayat/tafseer/update', [App\Http\Controllers\AlQuranController::class, 'updateTafseer'])->name('ayat.tafseer.update');
    Route::post('ayat/tafseer/save', [App\Http\Controllers\AlQuranController::class, 'saveTafseer'])->name('ayat.tafseer.save');

    //Ayat Reference
    Route::get('referene/get_files', [App\Http\Controllers\AlQuranController::class, 'getFiles'])->name('ayat.reference.files');
    Route::get('reference/delete', [App\Http\Controllers\ReferenceController::class, 'delete'])->name('ayat.reference.delete');

    //juz
    Route::get('juz', [App\Http\Controllers\JuzController::class, 'index'])->name('juz');
    Route::get('all-juz', [App\Http\Controllers\JuzController::class, 'allJuz'])->name('juz.all');
    Route::get('juz/create', [App\Http\Controllers\JuzController::class, 'add'])->name('juz.add');
    Route::post('juz/store', [App\Http\Controllers\JuzController::class, 'store'])->name('juz.store');
    Route::get('juz/edit/{id}', [App\Http\Controllers\JuzController::class, 'edit'])->name('juz.edit');
    Route::post('juz/update', [App\Http\Controllers\JuzController::class, 'update'])->name('juz.update');

    //Surah
    Route::get('al-Quran', [App\Http\Controllers\SurahController::class, 'index'])->name('al-Quran');
    Route::get('all-surah', [App\Http\Controllers\SurahController::class, 'allSurah'])->name('surah');
    Route::get('surah/create', [App\Http\Controllers\SurahController::class, 'add'])->name('surah.add');
    Route::post('surah/store', [App\Http\Controllers\SurahController::class, 'store'])->name('surah.store');
    Route::get('surah/edit/{id}', [App\Http\Controllers\SurahController::class, 'edit'])->name('surah.edit');
    Route::post('surah/update', [App\Http\Controllers\SurahController::class, 'update'])->name('surah.update');

    //publisher
    Route::get('publisher', [App\Http\Controllers\PublisherController::class, 'index'])->name('publisher');
    Route::get('all-publisher', [App\Http\Controllers\PublisherController::class, 'allPublisher'])->name('publisher.all');
    Route::get('publisher/create', [App\Http\Controllers\PublisherController::class, 'add'])->name('publisher.add');
    Route::post('publisher/store', [App\Http\Controllers\PublisherController::class, 'store'])->name('publisher.store');
    Route::get('publisher/edit/{id}', [App\Http\Controllers\PublisherController::class, 'edit'])->name('publisher.edit');
    Route::post('publisher/update', [App\Http\Controllers\PublisherController::class, 'update'])->name('publisher.update');
    Route::get('publisher/books_reading_details/{id}', [App\Http\Controllers\PublisherController::class, 'publisherBookReadingDetail'])->name('publisher.bookReadingDetail');

    //Hadith
    Route::get('hadith/books', [App\Http\Controllers\HadeesController::class, 'index'])->name('hadith');
    Route::get('all-hadith-books', [App\Http\Controllers\HadeesController::class, 'allBook'])->name('hadith.books');
    Route::get('hadith/book/create', [App\Http\Controllers\HadeesController::class, 'addBook'])->name('hadith.book.add');
    Route::post('hadith/book/create', [App\Http\Controllers\HadeesController::class, 'storeBook'])->name('hadith.book.store');
    Route::get('hadith/create/{id}', [App\Http\Controllers\HadeesController::class, 'add'])->name('hadith.add');
    Route::post('hadith/store', [App\Http\Controllers\HadeesController::class, 'store'])->name('hadith.store');
    Route::get('hadith/edit/{bookId}/{hadeesId}', [App\Http\Controllers\HadeesController::class, 'edit'])->name('hadith.edit');
    Route::post('hadith/update', [App\Http\Controllers\HadeesController::class, 'update'])->name('hadith.update');
    Route::get('hadith/book/edit/{id}', [App\Http\Controllers\HadeesController::class, 'editBook'])->name('hadith.book.edit');

    Route::get('hadith/translation/delete', [App\Http\Controllers\HadeesController::class, 'deleteTranslation'])->name('hadith.translaton.delete');
    Route::post('hadith/translation/update', [App\Http\Controllers\HadeesController::class, 'updateTranslation'])->name('hadith.translaton.update');
    Route::post('hadith/add_chapter', [App\Http\Controllers\HadeesController::class, 'addChapter'])->name('hadith.addChapter');

    //author
    Route::get('author', [App\Http\Controllers\AuthorController::class, 'index'])->name('author');
    Route::get('all-author', [App\Http\Controllers\AuthorController::class, 'allauthor'])->name('author.all');
    Route::get('author/create', [App\Http\Controllers\AuthorController::class, 'add'])->name('author.add');
    Route::post('author/store', [App\Http\Controllers\AuthorController::class, 'store'])->name('author.store');
    Route::get('author/edit/{id}', [App\Http\Controllers\AuthorController::class, 'edit'])->name('author.edit');
    Route::post('author/update', [App\Http\Controllers\AuthorController::class, 'update'])->name('author.update');

    //books
    Route::get('books/{type}', [App\Http\Controllers\BookController::class, 'index'])->name('books');
    Route::get('all-book', [App\Http\Controllers\BookController::class, 'allBooks'])->name('book.all');
    Route::get('book/{type}/create', [App\Http\Controllers\BookController::class, 'add'])->name('book.add');
    Route::post('book/store', [App\Http\Controllers\BookController::class, 'store'])->name('book.store');
    Route::get('book/{type}/edit/{id}', [App\Http\Controllers\BookController::class, 'edit'])->name('book.edit');
    Route::get('book/{type}/list/{id}', [App\Http\Controllers\BookController::class, 'list'])->name('book.list');
    Route::post('book/update/sequence', [App\Http\Controllers\BookController::class, 'updateSequence'])->name('book.sequence');
    Route::post('book/update', [App\Http\Controllers\BookController::class, 'update'])->name('book.update');
    Route::get('book/update-status/{id}', [App\Http\Controllers\BookController::class, 'updateStatus'])->name('book.statusUpdate');
    Route::get('book/pending-for-approval', [App\Http\Controllers\BookController::class, 'pendingForApprove'])->name('book.pendingForApprove');
    Route::get('all-pending-book', [App\Http\Controllers\BookController::class, 'allPendingForApprovalBooks'])->name('book.all-panding');
    Route::get('book/rejected', [App\Http\Controllers\BookController::class, 'rejected'])->name('book.rejected');
    Route::get('all-rejected-book', [App\Http\Controllers\BookController::class, 'allRejectedBooks'])->name('book.all-rejected');
    Route::get('book/approve/{id}', [App\Http\Controllers\BookController::class, 'approveBook'])->name('book.approveBook');
    Route::get('book/reject/{id}', [App\Http\Controllers\BookController::class, 'rejectBook'])->name('book.approveBook');
    Route::get('book/view/{id}', [App\Http\Controllers\BookController::class, 'viewBook'])->name('book.viewBook');
    Route::post('book/during_period/{type}', [App\Http\Controllers\BookController::class, 'bookDuringPeriod'])->name('bookduringPeriod');
    Route::get('book/approved', [App\Http\Controllers\BookController::class, 'approved'])->name('book.approved');
    Route::get('all-approved-book', [App\Http\Controllers\BookController::class, 'allApprovedBooks'])->name('book.all-approved');
    Route::get('books/rejected/{id}', [App\Http\Controllers\BookController::class, 'adminRejected'])->name('book.admin.rejected');
    Route::get('all-admin-rejected-book', [App\Http\Controllers\BookController::class, 'allAdminRejectedBooks'])->name('book.all-admin-rejected');

    //super admin revet
    Route::get('activities', [App\Http\Controllers\ActivitiesController::class, 'index'])->name('book.activities');
    Route::get('all-activities', [App\Http\Controllers\ActivitiesController::class, 'allActivities'])->name('book.all-activities');
    Route::get('content/revert/{id}/{activity_id}', [App\Http\Controllers\ActivitiesController::class, 'revert'])->name('book.revet');
    Route::get('book/update-status/{id}/{activity_id}', [App\Http\Controllers\ActivitiesController::class, 'updateStatusActivity'])->name('book.superadmin.statusUpdate');
    //admin users
    Route::get('user-management', [App\Http\Controllers\UserController::class, 'index'])->name('user.index');
    Route::get('all-user', [App\Http\Controllers\UserController::class, 'allUser'])->name('user.all');
    Route::get('user/create', [App\Http\Controllers\UserController::class, 'add'])->name('user.add');
    Route::post('user/store', [App\Http\Controllers\UserController::class, 'store'])->name('user.store');
    Route::get('user/edit/{id}', [App\Http\Controllers\UserController::class, 'edit'])->name('user.edit');
    Route::post('user/update', [App\Http\Controllers\UserController::class, 'update'])->name('user.update');
    Route::get('user/delete/{id}', [App\Http\Controllers\UserController::class, 'delete'])->name('user.delete');
    //app users
    Route::get('app-users', [App\Http\Controllers\UserController::class, 'appUsers'])->name('app.user');
    Route::get('all-app-user', [App\Http\Controllers\UserController::class, 'allAppUser'])->name('all.app.user');
    Route::get('app-user/books_reading_details/{id}', [App\Http\Controllers\UserController::class, 'userBookReadingDetail'])->name('user.books-readings');

    //categories
    Route::get('categories/{type}', [App\Http\Controllers\CategoryController::class, 'index'])->name('categories');
    Route::get('all-category', [App\Http\Controllers\CategoryController::class, 'allCategory'])->name('category.all');
    Route::get('category/{type}/create', [App\Http\Controllers\CategoryController::class, 'create'])->name('category.add');
    Route::post('category/store', [App\Http\Controllers\CategoryController::class, 'store'])->name('category.store');
    Route::get('category/{type}/edit/{id}', [App\Http\Controllers\CategoryController::class, 'edit'])->name('category.edit');
    Route::post('categroy/update', [App\Http\Controllers\CategoryController::class, 'update'])->name('category.update');
    Route::get('category/update-status/{id}', [App\Http\Controllers\CategoryController::class, 'updateStatus'])->name('category.statusUpdate');

    //courses
    Route::get('courses', [App\Http\Controllers\CourseController::class, 'index'])->name('courses');
    Route::get('all-courses', [App\Http\Controllers\CourseController::class, 'allCourses'])->name('courses.all');
    Route::get('course/create', [App\Http\Controllers\CourseController::class, 'add'])->name('course.add');
    Route::post('course/store', [App\Http\Controllers\CourseController::class, 'store'])->name('course.store');
    Route::get('course/edit/{id}', [App\Http\Controllers\CourseController::class, 'edit'])->name('course.edit');
    Route::post('course/update', [App\Http\Controllers\CourseController::class, 'update'])->name('course.update');
    Route::get('course/update-status/{id}', [App\Http\Controllers\CourseController::class, 'updateStatus'])->name('course.statusUpdate');

    Route::get('referene/add', [App\Http\Controllers\ReferenceController::class, 'add'])->name('reference.add');
    Route::get('languages', [App\Http\Controllers\LanguageController::class, 'allLanguage'])->name('languages');
    Route::get('/fileupload', [App\Http\Controllers\UserController::class, 'fileupload']);

    //support
    Route::get('support', [App\Http\Controllers\SupportController::class, 'index'])->name('support');
    Route::get('all-support', [App\Http\Controllers\SupportController::class, 'allSupport'])->name('support.all');
    Route::get('support/details/{id}', [App\Http\Controllers\SupportController::class, 'details'])->name('support.details');
    Route::get('support/approve/{id}', [App\Http\Controllers\SupportController::class, 'approveSupport'])->name('support.approve');
    Route::post('support/reply', [App\Http\Controllers\SupportController::class, 'reply'])->name('support.reply');

    //subcription email
    Route::get('subscription_email', [App\Http\Controllers\HomeController::class, 'allEmails'])->name('subscription');
    Route::get('all_subcription_email', [App\Http\Controllers\HomeController::class, 'allSubscriptionEmail'])->name('subscription.all');
    Route::get('export_email', [App\Http\Controllers\HomeController::class, 'exportEmail'])->name('export');

    //Glossory
    Route::get('glossary', [App\Http\Controllers\GlossoryController::class, 'index'])->name('glossary');
    Route::get('all-glossary', [App\Http\Controllers\GlossoryController::class, 'allglossory'])->name('glossary.all');
    Route::get('glossary/create', [App\Http\Controllers\GlossoryController::class, 'add'])->name('glossary.add');
    Route::post('glossary/store', [App\Http\Controllers\GlossoryController::class, 'store'])->name('glossary.store');
    Route::get('glossary/edit/{id}', [App\Http\Controllers\GlossoryController::class, 'edit'])->name('glossary.edit');
    Route::post('glossary/update', [App\Http\Controllers\GlossoryController::class, 'update'])->name('glossary.update');

    //book for sale
    Route::get('books_for_sale', [App\Http\Controllers\BookForSaleController::class, 'index'])->name('books_for_sale');
    Route::get('all_books_for_sale', [App\Http\Controllers\BookForSaleController::class, 'allBookForSale'])->name('books_for_sale.all');
    Route::get('book_for_sale/create', [App\Http\Controllers\BookForSaleController::class, 'add'])->name('book_for_sale.add');
    Route::post('book_for_sale/store', [App\Http\Controllers\BookForSaleController::class, 'store'])->name('book_for_sale.store');
    Route::get('book_for_sale/edit/{id}', [App\Http\Controllers\BookForSaleController::class, 'edit'])->name('book_for_sale.edit');
    Route::post('book_for_sale/update', [App\Http\Controllers\BookForSaleController::class, 'update'])->name('book_for_sale.update');

    Route::get('/cities', [App\Http\Controllers\BookForSaleController::class, 'cities'])->name('cities');
    //Grant
    Route::get('grant', [App\Http\Controllers\GrantController::class, 'index'])->name('grant');
    Route::get('all-grants', [App\Http\Controllers\GrantController::class, 'allgrants'])->name('grant.all');
    Route::get('grant/rejected', [App\Http\Controllers\GrantController::class, 'rejected'])->name('grant.rejected');
    Route::get('all-grants-rejected', [App\Http\Controllers\GrantController::class, 'allRejectedGrants'])->name('grant.all.rejected');
    Route::get('grant/approved', [App\Http\Controllers\GrantController::class, 'approved'])->name('grant.approved');
    Route::get('all-grants-approved', [App\Http\Controllers\GrantController::class, 'allApprovedGrants'])->name('grant.all.approved');

    Route::get('grant/approve/{id}', [App\Http\Controllers\GrantController::class, 'approveGrant'])->name('grant.approve');
    Route::get('grant/reject/{id}', [App\Http\Controllers\GrantController::class, 'rejectGrant'])->name('grant.reject');
    Route::get('grant/book/view/{id}', [App\Http\Controllers\GrantController::class, 'viewBook'])->name('grant.book.view');

    //coupon
    Route::get('coupon', [App\Http\Controllers\CouponController::class, 'index'])->name('coupon');
    Route::get('all-coupon', [App\Http\Controllers\CouponController::class, 'allcoupon'])->name('coupon.all');
    Route::get('coupon/create', [App\Http\Controllers\CouponController::class, 'add'])->name('coupon.add');
    Route::post('coupon/store', [App\Http\Controllers\CouponController::class, 'store'])->name('coupon.store');
    Route::get('coupon/delete/{id}', [App\Http\Controllers\CouponController::class, 'delete'])->name('coupon.edit');
    Route::post('coupon/update', [App\Http\Controllers\CouponController::class, 'update'])->name('coupon.update');

    //institue user
    Route::get('institute/users',  [App\Http\Controllers\UserController::class, 'instituteUsers'])->name('institute.users');
    Route::get('all-institute-users', [App\Http\Controllers\UserController::class, 'allInstituteUsers'])->name('institute.users.all');
    Route::get('institute/user/create', [App\Http\Controllers\UserController::class, 'addInstituteUsers'])->name('institute.user.add');
    Route::post('institute/user/store', [App\Http\Controllers\UserController::class, 'storeInstituteUsers'])->name('institute.user.store');
    Route::get('institute/user/edit/{id}', [App\Http\Controllers\UserController::class, 'editInstituteUsers'])->name('institute.user.edit');
    Route::post('institute/user/update', [App\Http\Controllers\UserController::class, 'updateInstituteUsers'])->name('institute.user.update');
    Route::get('institute/user/delete/{id}', [App\Http\Controllers\UserController::class, 'deleteInstituteUsers'])->name('institute.user.delete');
    Route::get('institute/download/sample', [App\Http\Controllers\UserController::class, 'downloadSample'])->name('institute.download.sample');
    Route::post('institute/import/user', [App\Http\Controllers\UserController::class, 'importUser'])->name('institute.user.import');
    //order
    Route::get('order', [App\Http\Controllers\OrderController::class, 'index'])->name('order');
    Route::get('all-order', [App\Http\Controllers\OrderController::class, 'allOrder'])->name('order.all');
    Route::get('order/change_status', [App\Http\Controllers\OrderController::class, 'changeStatus'])->name('order.change_status');

    //book review
    Route::get('review', [App\Http\Controllers\ReviewBookController::class, 'index'])->name('review');
    Route::get('all-review-book', [App\Http\Controllers\ReviewBookController::class, 'allReview'])->name('review.all');
    Route::get('review/{id}', [App\Http\Controllers\ReviewBookController::class, 'create'])->name('review.create');
    Route::post('review/store', [App\Http\Controllers\ReviewBookController::class, 'store'])->name('review.store');
    Route::get('review/book/view/{id}', [App\Http\Controllers\ReviewBookController::class, 'viewBook'])->name('grant.book.view');

    //book mistakes
    Route::get('mistakes', [App\Http\Controllers\BookMistakeController::class, 'index'])->name('mistakes');
    Route::get('all-mistakes', [App\Http\Controllers\BookMistakeController::class, 'allMistakes'])->name('mistakes.all');
    Route::get('mistake/understood/{id}', [App\Http\Controllers\BookMistakeController::class, 'understood'])->name('mistakes.understood');

    //Save Translation Through Files
    Route::post('translation/file/store', [App\Http\Controllers\HomeController::class, 'translationFileStore'])->name('translation.file.store');

    //Add Ayat and Translation
    Route::get('api_rendering', [App\Http\Controllers\HomeController::class, 'renderApi']);
    Route::get('translations_api_rendering', [App\Http\Controllers\HomeController::class, 'AlQuranTranslations']);
    Route::get('deleteTranslation', function () {
        $alQuranTranslation = AlQuranTranslation::where('650afac28704f705eb010142', '650afac28704f705eb010142')->delete();

        return 'done';
    });


    //New AL-Quran Module
    Route::get('all_surah_translations/{type}', [App\Http\Controllers\AlQuranController::class, 'newAllSurah']);
    Route::get('surah_translations/{type}/{id}', [App\Http\Controllers\AlQuranController::class, 'surah']);
    Route::get('surah/translations/{type}/{surah_id}/{combination}', [App\Http\Controllers\AlQuranController::class, 'surahAyats']);
});
