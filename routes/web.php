<?php

use App\Models\AlQuran;
use App\Models\AlQuranTranslation;
use App\Models\AuthorLanguage;
use App\Models\Book;
use App\Models\BookContent;
use App\Models\Category;
use App\Models\Hadees;
use App\Models\HadeesBookCombination;
use App\Models\HadeesBooks;
use App\Models\Juz;
use App\Models\Languages;
use App\Models\Surah;
use App\Models\HadeesTranslation;
use App\Models\HadithChapter;
use App\Models\Khatoot;
use App\Models\RecitationCombination;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\RoleAndPermissinController;
Use App\Http\Controllers\AuthorController;
use App\Http\Controllers\AlQuranController;
use App\Http\Controllers\HadeesController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\AppSectionController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseSeriesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ActivitiesController;
use App\Http\Controllers\GrantController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\GlossoryController;

use Meilisearch\Client;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Jobs\SurahCombination as SurahCombinationJob;
use App\Models\Course;
use App\Models\CourseLesson;
use App\Models\Scopes\DeletedAtScope;
use App\Models\UserSubscription;
use Carbon\Carbon;
use MongoDB\Operation\Count;

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


Route::get('roles', [RoleAndPermissinController::class, 'roles'])->name('allRole')->middleware('IsSuperAdmin');

Route::get('permission', [RoleAndPermissinController::class, 'permission'])->name('role.permission')->middleware('IsSuperAdmin');
Route::get('edit-permission/{id}', [RoleAndPermissinController::class, 'editPermission'])->name('role.editPermission')->middleware('IsSuperAdmin');


Route::post('role-save', [RoleAndPermissinController::class, 'roleSave'])->name('role.save');
Route::post('update-permission', [RoleAndPermissinController::class, 'updatePermission'])->name('role.updatePermission');

Route::get('sendEmailToPrevoius',  [App\Http\Controllers\HomeController::class, 'sendEmailToPrevoius']);
Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::get('ajax/users-data', [App\Http\Controllers\DashboardController::class, 'ajaxUsersData'])->name('ajax.user.data');
    Route::get('ajax/top-read-data', [App\Http\Controllers\DashboardController::class, 'topReadBooks'])->name('ajax.topread.data');
    Route::get('ajax/subscription-data', [App\Http\Controllers\DashboardController::class, 'subscriptionData'])->name('ajax.subscription.data');
    Route::get('ajax/top-read-book-data/{type}', [App\Http\Controllers\DashboardController::class, 'getTopReadBooksByType'])->name('ajax.most-read-book.data');
    Route::get('ajax/top-course-data/{type}', [App\Http\Controllers\DashboardController::class, 'getTopReadCourseData'])->name('ajax.most-read-course.data');

    //Al-Quran
    // Route::get('ayat/create/{id}', [App\Http\Controllers\AlQuranController::class, 'add'])->name('ayat.add');
    // Route::post('ayat/store', [App\Http\Controllers\AlQuranController::class, 'store'])->name('ayat.store');
    // Route::get('ayat/edit/{surah_id}/{ayat_id}', [App\Http\Controllers\AlQuranController::class, 'edit'])->name('ayat.edit');
    // Route::post('ayat/update', [App\Http\Controllers\AlQuranController::class, 'update'])->name('ayat.update');
    
    ////Proteted/////
    Route::post('author_lang', [App\Http\Controllers\AlQuranController::class, 'authorLanguage'])->name('ayat.author_language');
    Route::get('disable/author_lang/{id}', [App\Http\Controllers\AlQuranController::class, 'disableCombination']);
    ////Proteted/////


    //Ayat Translations
    ////Proteted/////
    
    
    Route::get('ayat/translation/delete', [App\Http\Controllers\AlQuranController::class, 'deleteTranslation'])->name('ayat.translaton.delete');
    Route::post('ayat/translation/update', [App\Http\Controllers\AlQuranController::class, 'updateTranslation'])->name('ayat.translaton.update');
    
    
    ////Proteted/////
    
    //Route::post('ayat/translation/save', [App\Http\Controllers\AlQuranController::class, 'saveTranslation'])->name('ayat.translaton.save');


    
    //Ayat Tafseer
    // Route::get('ayat/tafseer/delete', [App\Http\Controllers\AlQuranController::class, 'deleteTafseer'])->name('ayat.tafseer.delete');
    // Route::post('ayat/tafseer/update', [App\Http\Controllers\AlQuranController::class, 'updateTafseer'])->name('ayat.tafseer.update');
    // Route::post('ayat/tafseer/save', [App\Http\Controllers\AlQuranController::class, 'saveTafseer'])->name('ayat.tafseer.save');

    //Ayat Reference
    Route::get('referene/get_files', [App\Http\Controllers\AlQuranController::class, 'getFiles'])->name('ayat.reference.files');
    Route::get('reference/delete', [App\Http\Controllers\ReferenceController::class, 'delete'])->name('ayat.reference.delete');

    //juz
    // Route::get('juz', [App\Http\Controllers\JuzController::class, 'index'])->name('juz');
    // Route::get('all-juz', [App\Http\Controllers\JuzController::class, 'allJuz'])->name('juz.all');
    // Route::get('juz/create', [App\Http\Controllers\JuzController::class, 'add'])->name('juz.add');
    // Route::post('juz/store', [App\Http\Controllers\JuzController::class, 'store'])->name('juz.store');
    // Route::get('juz/edit/{id}', [App\Http\Controllers\JuzController::class, 'edit'])->name('juz.edit');
    // Route::post('juz/update', [App\Http\Controllers\JuzController::class, 'update'])->name('juz.update');

    //Surah
    // Route::get('al-Quran', [App\Http\Controllers\SurahController::class, 'index'])->name('al-Quran');
    // Route::get('all-surah', [App\Http\Controllers\SurahController::class, 'allSurah'])->name('surah');
    // Route::get('surah/create', [App\Http\Controllers\SurahController::class, 'add'])->name('surah.add');
    // Route::post('surah/store', [App\Http\Controllers\SurahController::class, 'store'])->name('surah.store');
    // Route::get('surah/edit/{id}', [App\Http\Controllers\SurahController::class, 'edit'])->name('surah.edit');
    // Route::post('surah/update', [App\Http\Controllers\SurahController::class, 'update'])->name('surah.update');

    //publisher
    Route::get('publisher', [PublisherController::class, 'index'])->name('publisher')->middleware('permission:publisher-view');
    Route::get('all-publisher', [PublisherController::class, 'allPublisher'])->name('publisher.all');
    Route::get('publisher/create', [PublisherController::class, 'add'])->name('publisher.add')->middleware('permission:publisher-create');
    Route::post('publisher/store', [PublisherController::class, 'store'])->name('publisher.store')->middleware('permission:publisher-create');
    Route::get('publisher/edit/{id}', [PublisherController::class, 'edit'])->name('publisher.edit')->middleware('permission:publisher-edit');
    Route::post('publisher/update', [PublisherController::class, 'update'])->name('publisher.update')->middleware('permission:publisher-edit');
    Route::get('publisher/books_reading_details/{id}', [PublisherController::class, 'publisherBookReadingDetail'])->name('publisher.bookReadingDetail');

    //Hadith
    Route::get('hadith/books/{type}', [App\Http\Controllers\HadeesController::class, 'index'])->name('hadith');
    Route::get('hadith/book/create/{type}', [HadeesController::class, 'addBook'])->middleware('permission:add-hadith-book');
    Route::post('hadith/book/create', [HadeesController::class, 'storeBook'])->middleware('permission:add-hadith-book');
    Route::get('hadith/create/{type}/{id}/{combination}', [HadeesController::class, 'add'])->middleware('permission:add-hadith');
    Route::post('hadith/store', [HadeesController::class, 'store'])->name('hadith.store')->middleware('permission:add-hadith');
    //Route::get('all-hadith-books', [App\Http\Controllers\HadeesController::class, 'allBook'])->name('hadith.books');
    // Route::get('hadith/edit/{bookId}/{hadeesId}', [HadeesController::class, 'edit'])->name('hadith.edit');
    // Route::post('hadith/update', [HadeesController::class, 'update'])->name('hadith.update');
    // Route::get('hadith/book/edit/{id}', [HadeesController::class, 'editBook'])->name('hadith.book.edit');

    Route::get('hadith/translation/delete', [HadeesController::class, 'deleteTranslation'])->name('hadith.translaton.delete');
    Route::post('hadith/translation/update', [HadeesController::class, 'updateTranslation'])->name('hadith.translaton.update');
    Route::post('hadith/add_chapter', [HadeesController::class, 'addChapter'])->name('hadith.addChapter');

    //author
    ////Proteted/////
    Route::get('authors/{type?}', [AuthorController::class, 'index'])->name('author');
    Route::get('all-author', [AuthorController::class, 'allauthor'])->name('author.all');
    Route::get('author/create/{type?}', [AuthorController::class, 'add'])->name('author.add');
    Route::post('author/store', [AuthorController::class, 'store'])->name('author.store');
    Route::get('author/edit/{id}', [AuthorController::class, 'edit'])->name('author.edit');
    Route::post('author/update', [AuthorController::class, 'update'])->name('author.update');
    ////Proteted/////
    //books


    Route::get('books/{type}', [App\Http\Controllers\BookController::class, 'index'])->name('books')->middleware('contentPermission:view');
    Route::get('all-book', [App\Http\Controllers\BookController::class, 'allBooks'])->name('book.all');
    Route::get('book/{type}/create', [App\Http\Controllers\BookController::class, 'add'])->name('book.add')->middleware('contentPermission:create');
    Route::post('book/store', [App\Http\Controllers\BookController::class, 'store'])->name('book.store')->middleware('contentPermission:create');
    Route::get('book/{type}/edit/{id}', [App\Http\Controllers\BookController::class, 'edit'])->name('book.edit')->middleware('contentPermission:edit');
    Route::get('book/{type}/list/{id}', [App\Http\Controllers\BookController::class, 'list'])->name('book.list');
    Route::post('book/update/sequence', [App\Http\Controllers\BookController::class, 'updateSequence'])->name('book.sequence')->middleware('permission:edit-audio-book-chapter');
    Route::post('book/update', [App\Http\Controllers\BookController::class, 'update'])->name('book.update')->middleware('contentPermission:edit');
    Route::get('book/update-status/{id}', [App\Http\Controllers\BookController::class, 'updateStatus'])->name('book.statusUpdate');
    
    
    
    Route::get('book/pending-for-approval/{type}', [App\Http\Controllers\BookController::class, 'pendingForApprove'])->name('book.pendingForApprove')->middleware('approvalPermission');
    Route::get('all-pending-book', [App\Http\Controllers\BookController::class, 'allPendingForApprovalBooks'])->name('book.all-panding');
    Route::get('book/rejected', [App\Http\Controllers\BookController::class, 'rejected'])->name('book.rejected');
    Route::get('all-rejected-book', [App\Http\Controllers\BookController::class, 'allRejectedBooks'])->name('book.all-rejected');
    Route::get('book/approve/{id}', [App\Http\Controllers\BookController::class, 'approveBook'])->name('book.approveBook');
    Route::get('book/reject/{id}', [App\Http\Controllers\BookController::class, 'rejectBook'])->name('book.approveBook');
    Route::get('book/view/{id}', [App\Http\Controllers\BookController::class, 'viewBook'])->name('book.viewBook');
    Route::get('book/during_period/{type}', [App\Http\Controllers\BookController::class, 'bookDuringPeriod'])->name('bookduringPeriod');
    Route::get('book/approved', [App\Http\Controllers\BookController::class, 'approved'])->name('book.approved')->middleware('permission:approved-content');
    Route::get('all-approved-book', [App\Http\Controllers\BookController::class, 'allApprovedBooks'])->name('book.all-approved');
    Route::get('book/rejected_by_you', [App\Http\Controllers\BookController::class, 'adminRejected'])->name('book.admin.rejected')->middleware('permission:rejected-content');
    Route::get('all-admin-rejected-book', [App\Http\Controllers\BookController::class, 'allAdminRejectedBooks'])->name('book.all-admin-rejected');

    //delete audio chapter

    Route::get('delete/audio/{id}', [App\Http\Controllers\BookController::class, 'deleteAudioChapter'])->name('book.audio.delete.chapter')->middleware('permission:delete-audio-book-chapter');
    Route::get('update/audio/name', [App\Http\Controllers\BookController::class, 'updateChapterName'])->name('book.audio.update.chapter')->middleware('permission:edit-audio-book-chapter');
    Route::post('add/audio/chapter', [App\Http\Controllers\BookController::class, 'addAudioChapter'])->name('book.audio.add.chapter')->middleware('permission:add-audio-book-chapter');

    //podcast
    Route::get('podcast/edit/{id}', [App\Http\Controllers\BookController::class, 'podcastEdit'])->name('podcast.edit')->middleware('permission:podcast-edit');
    Route::post('podcast/episode', [App\Http\Controllers\BookController::class, 'podcastEpisode'])->name('podcast.episode');
    Route::post('podcast/bulk/episode', [App\Http\Controllers\BookController::class, 'podcastBulkEpisode'])->name('podcast.bulk.episode');
    Route::get('podcast/episode/delete/{id}', [App\Http\Controllers\BookController::class, 'deleteEpisode'])->name('podcast.episode.delete')->middleware('permission:delete-podcast-episode');

    Route::get('podcast/episode/undo-delete/{id}', [App\Http\Controllers\BookController::class, 'undoDeleteEpisode'])->name('podcast.episode.undo-delete')->middleware('permission:delete-podcast-episode');

    //super admin revet
    Route::get('activities', [ActivitiesController::class, 'index'])->name('book.activities')->middleware('permission:activities_view');;
    Route::get('all-activities', [ActivitiesController::class, 'allActivities'])->name('book.all-activities');
    Route::get('content/revert/{id}/{activity_id}', [ActivitiesController::class, 'revert'])->name('book.revet')->middleware('permission:activities_undo');;
    Route::get('book/update-status/{id}/{activity_id}', [ActivitiesController::class, 'updateStatusActivity'])->name('book.superadmin.statusUpdate');
    //admin users
    Route::get('user-management', [UserController::class, 'index'])->name('user.index')->middleware('permission:view-admin-user');
    Route::get('all-user', [UserController::class, 'allUser'])->name('user.all');
    Route::get('user/create', [UserController::class, 'add'])->name('user.add')->middleware('permission:create-admin-user');
    Route::post('user/store', [UserController::class, 'store'])->name('user.store')->middleware('permission:create-admin-user');
    Route::get('user/edit/{id}', [UserController::class, 'edit'])->name('user.edit')->middleware('permission:edit-admin-user');
    Route::post('user/update', [UserController::class, 'update'])->name('user.update')->middleware('permission:edit-admin-user');
    Route::get('user/delete/{id}', [UserController::class, 'delete'])->name('user.delete')->middleware('permission:delete-admin-user');;

    Route::post('reset-password', [UserController::class, 'resetPassword'])->name('reset.password')->middleware('permission:reset-password-admin-user');

    //app users
    Route::get('app-users', [UserController::class, 'appUsers'])->name('app.user')->middleware('permission:app-user-view');
    Route::get('all-app-user', [UserController::class, 'allAppUser'])->name('all.app.user');
    Route::get('app-user/profile/{id}', [UserController::class, 'profile'])->name('app.user.profile')->middleware('permission:app-user-profile');
    Route::post('app-user/subscription', [UserController::class, 'giveSubscription'])->name('app.user.subscription');
    Route::get('app-user/books_reading_details/{id}', [UserController::class, 'userBookReadingDetail'])->name('user.books-readings')->middleware('permission:app-user-details');
    Route::get('affiliate/app-user/books_reading_details/{id}', [UserController::class, 'userBookReadingDetail'])->name('user.books-readings')->middleware('permission:affiliate-users-detail');
    Route::get('family/app-user/books_reading_details/{id}', [UserController::class, 'userBookReadingDetail'])->name('user.books-readings')->middleware('permission:family-members-detail');
    Route::get('cancel_subscriptions', [UserController::class, 'cancelSubscription'])->name('user.cancelsubscription')->middleware('permission:view-cancel-subscription');
    Route::get('all/cancel_subscriptions', [UserController::class, 'allCancelSubscription'])->name('all.cancelsubscription');

    //categories
    Route::get('categories', [CategoryController::class, 'index'])->middleware('permission:category-view');
    Route::get('categories/inactive', [CategoryController::class, 'inActive'])->middleware('permission:category-view');
    Route::get('category/create', [CategoryController::class, 'create'])->name('category.add')->middleware('permission:category-create');
    Route::post('category/store', [CategoryController::class, 'store'])->name('category.store')->middleware('permission:category-create');
    Route::get('category/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit')->middleware('permission:category-edit');
    Route::post('categroy/update', [CategoryController::class, 'update'])->name('category.update')->middleware('permission:category-edit');
    Route::get('category/update-status/{id}', [CategoryController::class, 'updateStatus'])->name('category.statusUpdate');
    Route::post('category/change_content_category', [CategoryController::class, 'updateContentCategory'])->name('category.update.contentCategory');
    
    
    Route::get('all-inactive-category', [CategoryController::class, 'allInactiveCategory'])->name('inactive-category.all');
    Route::get('all-category', [CategoryController::class, 'allCategory'])->name('category.all');
    //courses
    Route::get('courses', [CourseController::class, 'index'])->name('courses')->middleware('permission:course-view');
    Route::get('all-courses', [CourseController::class, 'allCourses'])->name('courses.all');
    Route::get('course/create', [CourseController::class, 'add'])->name('course.add')->middleware('permission:course-create');
    Route::post('course/store', [CourseController::class, 'store'])->name('course.store')->middleware('permission:course-create');
    Route::get('course/edit/{id}', [CourseController::class, 'edit'])->name('course.edit')->middleware('permission:course-edit');
    Route::post('course/update', [CourseController::class, 'update'])->name('course.update')->middleware('permission:course-edit');
    Route::get('course/update-status/{id}', [CourseController::class, 'updateStatus'])->name('course.statusUpdate')->middleware('permission:course-toggle');
    Route::get('all-pending-courses', [CourseController::class, 'allPendingCourses'])->name('courses.pending.all');
    Route::get('course/approve/{id}', [CourseController::class, 'approveCourse'])->name('course.approve');
    Route::get('course/reject/{id}', [CourseController::class, 'rejectCourse'])->name('course.reject');
    Route::get('all-rejected-by-you-courses', [CourseController::class, 'allRejectedByYouCourses'])->name('courses.rejected.all');
    Route::get('all-approved-by-you-courses', [CourseController::class, 'allApprovedByYouCourses'])->name('courses.approved.all');
    Route::get('all-rejected-courses', [CourseController::class, 'allRejectedCourses'])->name('courses.rejected.all');
    Route::post('course/lessons', [CourseController::class, 'courseLessons'])->name('course.lessons');
    Route::post('course/bulk/episode', [CourseController::class, 'courseBulkEpisode'])->name('course.bulk.episode')->middleware('permission:edit-course-lesson');
    Route::get('update/lesson/title', [CourseController::class, 'updateLessonName'])->name('course.lesson.update.title')->middleware('permission:edit-course-lesson');
    Route::get('course/lesson/delete/{id}', [CourseController::class, 'deleteLesson'])->name('course.lesson.delete')->middleware('permission:delete-course-lesson');
    Route::get('course/lesson/undo-delete/{id}', [CourseController::class, 'UndoDeleteLesson'])->name('course.lesson.delete')->middleware('permission:delete-course-lesson');

    //lesson quiz
    Route::get('lesson/quiz/add/{course_id}', [CourseController::class, 'addQuiz'])->name('quiz.add');
    Route::post('lesson/quiz/post', [CourseController::class, 'postQuiz'])->name('quiz.post');
    Route::get('lesson/quiz/edit/{course_id}/{id}', [CourseController::class, 'manageQuiz'])->name('quiz.add');
    Route::post('lesson/quiz/update', [CourseController::class, 'updateQuiz'])->name('quiz.update');
    Route::get('lesson/quiz/results/{course_id}/{id}', [CourseController::class, 'quizResults'])->name('quiz.results');
    Route::get('lesson/quiz/results/{user_id}', [CourseController::class, 'userAttemptsResults'])->name('quiz.user.results');

    //course series
    Route::get('series', [CourseSeriesController::class, 'seriesIndex'])->name('series')->middleware('permission:course-series-view');
    Route::get('all-series', [CourseSeriesController::class, 'allSeries'])->name('series.all');
    Route::get('series/create', [CourseSeriesController::class, 'add'])->name('series.add')->middleware('permission:course-series-create');
    Route::post('series/store', [CourseSeriesController::class, 'store'])->name('series.store')->middleware('permission:course-series-create');
    Route::get('series/edit/{id}', [CourseSeriesController::class, 'edit'])->name('series.edit')->middleware('permission:course-series-edit');
    Route::post('series/update', [CourseSeriesController::class, 'update'])->name('series.update')->middleware('permission:course-series-edit');
    Route::get('series/update-status/{id}', [CourseSeriesController::class, 'updateStatus'])->name('series.statusUpdate')->middleware('permission:course-series-toggle');

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
    Route::get('subscription_email', [App\Http\Controllers\HomeController::class, 'allEmails'])->name('subscription')->middleware('permission:email-subscriptions');
    Route::get('all_subcription_email', [App\Http\Controllers\HomeController::class, 'allSubscriptionEmail'])->name('subscription.all');
    Route::get('export_email', [App\Http\Controllers\HomeController::class, 'exportEmail'])->name('export')->middleware('permission:email-subscriptions-export');

    //Glossory
    Route::get('glossary', [GlossoryController::class, 'index'])->name('glossary')->middleware('permission:glossory-view');
    Route::get('all-glossary', [GlossoryController::class, 'allglossory'])->name('glossary.all');
    Route::get('glossary/create', [GlossoryController::class, 'add'])->name('glossary.add')->middleware('permission:glossory-create');
    Route::post('glossary/store', [GlossoryController::class, 'store'])->name('glossary.store')->middleware('permission:glossory-create');
    Route::get('glossary/edit/{id}', [GlossoryController::class, 'edit'])->name('glossary.edit')->middleware('permission:glossory-edit');
    Route::post('glossary/update', [GlossoryController::class, 'update'])->name('glossary.update')->middleware('permission:glossory-edit');

    //Notifications
    Route::get('notification', [NotificationController::class, 'index'])->name('notification')->middleware('permission:notifications-view');
    Route::get('all-notification', [NotificationController::class, 'allNotifications'])->name('notification.all');
    Route::get('notification/create', [NotificationController::class, 'add'])->name('notification.add')->middleware('permission:notifications-create');
    Route::post('notification/store', [NotificationController::class, 'store'])->name('notification.store')->middleware('permission:notifications-create');

    //Popups
    Route::get('popups', [NotificationController::class, 'popupIndex'])->name('popup');
    Route::get('all-popup', [NotificationController::class, 'allPopup'])->name('popup.all');
    Route::get('popup/create', [NotificationController::class, 'addPopup'])->name('popup.add');
    Route::post('popup/store', [NotificationController::class, 'storePopup'])->name('popup.store');
    Route::get('popup/edit/{id}', [NotificationController::class, 'editPopup'])->name('popup.edit');
    Route::post('popup/updatePopup', [NotificationController::class, 'updatePopup'])->name('popup.update');
    Route::get('popup/update-status/{id}', [NotificationController::class, 'popupStatusUpdate'])->name('popup.statusUpdate');

    //book for sale
    Route::get('books_for_sale', [App\Http\Controllers\BookForSaleController::class, 'index'])->name('books_for_sale')->middleware('permission:books-for-sale');
    Route::get('all_books_for_sale', [App\Http\Controllers\BookForSaleController::class, 'allBookForSale'])->name('books_for_sale.all');
    Route::get('book_for_sale/create', [App\Http\Controllers\BookForSaleController::class, 'add'])->name('book_for_sale.add')->middleware('permission:books-for-sale-create');
    Route::post('book_for_sale/store', [App\Http\Controllers\BookForSaleController::class, 'store'])->name('book_for_sale.store')->middleware('permission:books-for-sale-create');
    Route::get('book_for_sale/edit/{id}', [App\Http\Controllers\BookForSaleController::class, 'edit'])->name('book_for_sale.edit')->middleware('permission:books-for-sale-edit');
    Route::post('book_for_sale/update', [App\Http\Controllers\BookForSaleController::class, 'update'])->name('book_for_sale.update')->middleware('permission:books-for-sale-edit');

    Route::get('/cities', [App\Http\Controllers\BookForSaleController::class, 'cities'])->name('cities');
    //Grant
    Route::get('grant', [GrantController::class, 'index'])->name('grant')->middleware('permission:grant');
    Route::get('all-grants', [GrantController::class, 'allgrants'])->name('grant.all');
    Route::get('grant/rejected', [GrantController::class, 'rejected'])->name('grant.rejected')->middleware('permission:approved-grant');
    Route::get('all-grants-rejected', [GrantController::class, 'allRejectedGrants'])->name('grant.all.rejected');
    Route::get('grant/approved', [GrantController::class, 'approved'])->name('grant.approved')->middleware('permission:rejected-grant');
    Route::get('all-grants-approved', [GrantController::class, 'allApprovedGrants'])->name('grant.all.approved');

    Route::get('grant/approve/{id}', [GrantController::class, 'approveGrant'])->name('grant.approve');
    Route::get('grant/reject/{id}', [GrantController::class, 'rejectGrant'])->name('grant.reject');
    Route::get('grant/book/view/{id}', [GrantController::class, 'viewBook'])->name('grant.book.view');
    Route::get('grant/update/status/{id}', [GrantController::class, 'statusUpdate'])->name('grant.status');

    //coupon
    Route::get('coupon', [App\Http\Controllers\CouponController::class, 'index'])->name('coupon')->middleware('permission:coupon-view');
    Route::get('all-coupon', [App\Http\Controllers\CouponController::class, 'allcoupon'])->name('coupon.all');
    Route::get('coupon/create', [App\Http\Controllers\CouponController::class, 'add'])->name('coupon.add')->middleware('permission:coupon-create');
    Route::post('coupon/store', [App\Http\Controllers\CouponController::class, 'store'])->name('coupon.store')->middleware('permission:coupon-create');
    Route::get('coupon/delete/{id}', [App\Http\Controllers\CouponController::class, 'delete'])->name('coupon.edit')->middleware('permission:coupon-delete');
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
    // Route::post('institute/import/user', [App\Http\Controllers\UserController::class, 'importUser'])->name('institute.user.import');
    Route::post('institute/import/user', [App\Http\Controllers\UserController::class, 'importUserForInstitueTable'])->name('institute.user.import');
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

    //addition review
    Route::get('addition_review', [App\Http\Controllers\ReviewBookController::class, 'allAddtionaReview'])->name('review.addition');
    Route::get('all-addition-review-book', [App\Http\Controllers\ReviewBookController::class, 'allBookAddtionaReview'])->name('review.addition.all');
    Route::get('addition_review_approve/{id}', [App\Http\Controllers\ReviewBookController::class, 'additionApprove'])->name('review.addition.approve');
    Route::get('addition_review_reject/{id}', [App\Http\Controllers\ReviewBookController::class, 'additionReject'])->name('review.addition.reject');
    //book mistakes
    Route::get('mistakes', [App\Http\Controllers\BookMistakeController::class, 'index'])->name('mistakes');
    Route::get('all-mistakes', [App\Http\Controllers\BookMistakeController::class, 'allMistakes'])->name('mistakes.all');
    Route::get('mistake/understood/{id}', [App\Http\Controllers\BookMistakeController::class, 'understood'])->name('mistakes.understood');

    //Save Translation Through Files
    Route::post('translation/file/store', [App\Http\Controllers\HomeController::class, 'translationFileStore'])->name('translation.file.store');

    //comments
    Route::get('reflections', [App\Http\Controllers\CommentsController::class, 'index'])->name('commetns');
    Route::get('all-comments', [App\Http\Controllers\CommentsController::class, 'allComments'])->name('comments.all');
    Route::get('all-reflections', [App\Http\Controllers\CommentsController::class, 'allReflection'])->name('reflection.all');
    Route::get('comment/approved/{id}', [App\Http\Controllers\CommentsController::class, 'approved'])->name('mistakes.approved');
    Route::get('comment/reject/{id}', [App\Http\Controllers\CommentsController::class, 'reject'])->name('mistakes.reject');

    //Add Ayat and Translation
    Route::get('api_rendering', [App\Http\Controllers\HomeController::class, 'renderApi']);
    Route::get('translations_api_rendering/{translation_id}/{combination_id}', [App\Http\Controllers\HomeController::class, 'AlQuranTranslations']);



    //New AL-Quran Module

    ////Proteted/////
    Route::get('all_surah_translations/{type}', [AlQuranController::class, 'newAllSurah']);
    Route::get('surah_translations/{type}/{id}', [AlQuranController::class, 'surah']);
    Route::get('surah/translations/{type}/{surah_id}/{combination}', [AlQuranController::class, 'surahAyats']);
    ////Proteted/////


    
    //Al-Quran Recitations
    //Route::get('all_surah_recitations', [App\Http\Controllers\AlQuranController::class, 'surahRecitation']);

    //New Hadith
    //Route::get('all_hadith_books/{type}', [App\Http\Controllers\AlQuranController::class, 'newAllBooks']);
    Route::get('hadith/books/combination/{type}/{id}', [HadeesController::class, 'hadithCombination']);
    Route::get('/hadith/books/combination/{type}/{book_id}/{combination}', [HadeesController::class, 'Hadiths']);

    
    //languages
    Route::get('language', [App\Http\Controllers\LanguageController::class, 'index'])->middleware('permission:language-view');
    Route::get('language/create', [App\Http\Controllers\LanguageController::class, 'create'])->name('language.create')->middleware('permission:language-create');
    Route::post('language', [App\Http\Controllers\LanguageController::class, 'store'])->name('language.store');
    Route::get('language/edit/{id}', [App\Http\Controllers\LanguageController::class, 'edit'])->name('language.edit')->middleware('permission:language-edit');

    //affiliate
    Route::get('affiliate', [App\Http\Controllers\UserController::class, 'affiliate'])->name('affiliate')->middleware('permission:affiliate-users');
    Route::get('affiliate/reffered/{id}', [App\Http\Controllers\UserController::class, 'reffered'])->name('affiliate.reffered')->middleware('permission:affiliate-child-users');



    //family
    Route::get('family', [App\Http\Controllers\UserController::class, 'family'])->name('affiliate')->middleware('permission:family');
    Route::get('family/members/{id}', [App\Http\Controllers\UserController::class, 'members'])->name('family.members')->middleware('permission:family-members');

    //app versions
    Route::get('app/versions', [App\Http\Controllers\HomeController::class, 'appVersions'])->name('appVersions')->middleware('permission:app-versions-view');
    Route::get('app/all-versions', [App\Http\Controllers\HomeController::class, 'allVersions'])->name('allVersions.all');
    Route::get('app/versions/create', [App\Http\Controllers\HomeController::class, 'createVersion'])->name('appVersions.create')->middleware('permission:app-versions-create');
    Route::post('app/versions', [App\Http\Controllers\HomeController::class, 'storeVersions'])->name('appVersions.store')->middleware('permission:app-versions-create');

    //section
    Route::get('app-section', [AppSectionController::class, 'index'])->name('app-section')->middleware('permission:app-section-view');
    Route::get('all-app-section', [AppSectionController::class, 'allSection'])->name('app-section.all');
    Route::get('app-section/create', [AppSectionController::class, 'add'])->name('app-section.add')->middleware('permission:app-section-create');
    Route::post('app-section/store', [AppSectionController::class, 'store'])->name('app-section.store')->middleware('permission:app-section-create');
    Route::get('app-section/edit/{id}', [AppSectionController::class, 'edit'])->name('app-section.edit')->middleware('permission:app-section-edit');
    Route::post('app-section/update', [AppSectionController::class, 'update'])->name('app-section.update')->middleware('permission:app-section-edit');
    Route::get('app-section/update-status/{id}', [AppSectionController::class, 'updateSectionStatus'])->name('app-section.update.status')->middleware('permission:app-section-toggle');

    Route::post('app-section/content', [AppSectionController::class, 'sectionContent'])->name('app-section.content')->middleware('permission:add-content');
    //render api
    Route::get('renderApi',  [App\Http\Controllers\HomeController::class, 'renderApi']);

    //chunks
    Route::post('/upload-chunks',  [App\Http\Controllers\FileUploadController::class, 'uploadChunks']);
});
Route::get('file/upload',  [App\Http\Controllers\DevController::class, 'uploadFile'])->name('file.upload');
Route::post('file/upload',  [App\Http\Controllers\DevController::class, 'post'])->name('file.upload');

Route::get('videoConversion',  [App\Http\Controllers\DevController::class, 'videoConversion'])->name('video.conversion');


Route::get('updateModel', function () {
    set_time_limit(0);
    $chapters = HadithChapter::where('book_id', '65e9a1249de8bf4c113a2d30')->whereNull('parent_id')->pluck('_id');
    // ->whereNull('parent_id')
    foreach ($chapters as $key => $ch) {
        $var = 20;
        $page = 1;
        // $subchapters = HadithChapter::where('book_id', '65e96911d67654aab27f7cb8')->where('parent_id', $ch)->pluck('_id');
        $hadith =  Hadees::where('chapter_id', $ch)->get();
        // $hadith =  Hadees::whereIn('chapter_id', $subchapters)->get();

        foreach ($hadith as $key => $h) {

            if ($var == $key + 1) {
                $var = $var + 20;
                $page = $page + 1;
            }


            $h->page_no = $page;
            $h->save();
        }
    }
    return 'done';
});
Route::get('phpinfo', function () {
    return phpinfo();

});
Route::get('dev', function () {
    // \File::makeDirectory(public_path('videos'), 777, true, true);
    // \File::deleteDirectory(public_path('videos'), 777, true, true);

   

    system("rm -rf ".escapeshellarg(public_path('videos')));
    return 'ok';
    $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
    return  $stripe->coupons->retrieve('QO3huApM', []);
});
Route::get('/indexing/{id}', function ($id) {
    ini_set('max_execution_time', '0');
    ini_set("memory_limit", "-1");
    $client = new  Client('http://localhost:7700', '3bc7ba18215601c4de218ef53f0f90e830a7f144');

    $client->createIndex('alHadeestranslations');
    $books = HadeesBooks::where('_id', $id)->first();
    if ($books) {
        // Fetch the translations for the book
        $data = HadeesTranslation::where('book_id', $books->_id)->get()->map(function ($tran) {
            $tran->main_chapter = $tran->mainChapter();
            return $tran;
        });

        // Add documents to the index
        $client->index('alHadeestranslations')->addDocuments($data->toArray(), '_id');
    }

    return 'ok';
});