<?php

use App\Http\Controllers\Back\AboutController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Back\AuthController;
use App\Http\Controllers\Back\CateringController;
use App\Http\Controllers\Back\ClientController;
use App\Http\Controllers\Back\ContactController;
use App\Http\Controllers\Back\DashboardController;
use App\Http\Controllers\Back\DecorationController;
use App\Http\Controllers\Back\DocumentationController;
use App\Http\Controllers\Back\EventController;
use App\Http\Controllers\Back\PermissionController;
use App\Http\Controllers\Back\RecycleController;
use App\Http\Controllers\Back\RoleController;
use App\Http\Controllers\Back\UserController;
use App\Http\Controllers\Back\UserListController;
use App\Http\Controllers\Back\WeddingController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\Back\EntertainmentController;
use App\Http\Controllers\Back\LiveController;
use App\Http\Controllers\Back\SliderController;
use App\Http\Controllers\Back\TeamLanoerController;
use App\Http\Controllers\Back\TestimoniController;
use App\Http\Controllers\Front\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index']);
Route::get('/about', [HomeController::class, 'about'])->name('aboutHome');
Route::get('/makeups', [HomeController::class, 'makeups'])->name('makeups');
Route::get('makeup/event/{eventMakeupSlug}', [HomeController::class, 'detailEvent'])->name('makeup.event');
Route::get('makeup/event/{eventMakeupSlug}/{slug}', [HomeController::class, 'showEvent'])->name('makeup.event.detail');
Route::get('makeup/wedding/{weddingMakeupSlug}', [HomeController::class, 'detailWedding'])->name('makeup.wedding');
Route::get('makeup/wedding/{weddingMakeupSlug}/{slug}', [HomeController::class, 'showWedding'])->name('makeup.wedding.detail');

Route::get('decoration/list', [HomeController::class, 'decorationList'])->name('decoration.list');
Route::get('decoration/{slug}', [HomeController::class, 'showDecoration'])->name('decoration.detail.show');

Route::get('entertainment/list', [HomeController::class, 'entertainmentList'])
    ->name('entertainment.list');

Route::get('entertainment/{soundSystemSlug}/{slug}', [HomeController::class, 'showEntertainmentSound'])
    ->name('entertainment.sound.detail.show');

Route::get('entertainment/{liveSlug}/{liveSubSlug}', [HomeController::class, 'showEntertainmentLive'])
    ->name('entertainment.live.detail.show');


Route::get('entertainment/{slug}', [HomeController::class, 'showEntertainmentCeremony'])
    ->name('entertainment.ceremony.detail.show');



Route::get('/services', [HomeController::class, 'services'])->name('servicesHome');
Route::get('/portfolio', [HomeController::class, 'portfolio'])->name('portfolioHome');
Route::get('/blog', [HomeController::class, 'blog'])->name('blogHome');
Route::get('/contact', [HomeController::class, 'contact'])->name('contactHome');


// ROUTE BACKEND
Route::prefix('auth')->name('auth.')->group(function () {
    Route::view('/login', 'back.pages.auth.login')->name('login')->middleware('guest');
    Route::view('/forgot-password', 'back.pages.auth.forgot')->name('forgot-password')->middleware('guest');
    Route::get('/password/reset/{token}', [AuthController::class, 'ResetForm'])->name('reset-form')->middleware('guest');
});


Route::middleware('auth:web')->group(function () {
    Route::get('/home', [DashboardController::class, 'index'])->name('home');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::resource('users', UserController::class);
    Route::post('/change-profile-picture', [UserController::class, 'changeProfilePicture'])->name('change-profile-picture');



    Route::prefix('konfigurasi')->name('konfigurasi.')->group(function () {
        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);
        Route::resource('users-list', UserListController::class);
    });

    Route::resource('settings', SettingController::class);
    Route::post('/change-web-logo', [SettingController::class, 'changeWebLogo'])->name('change-web-logo');
    Route::post('/change-email-logo', [SettingController::class, 'changeEmailLogo'])->name('change-email-logo');
    Route::post('/change-web-favicon', [SettingController::class, 'changeWebFavicon'])->name('change-web-favicon');
    Route::post('/change-web-front', [SettingController::class, 'changeWebFront'])->name('change-web-front');
    Route::post('/change-web-front2', [SettingController::class, 'changeWebFront2'])->name('change-web-front2');

    Route::prefix('makeup')->name('makeup.')->group(function () {
        Route::view('/list', 'back.pages.makeup.list')->name('list');
        // event
        Route::resource('/', EventController::class);
        Route::get('event/edit/{id}', [EventController::class, 'edit'])->name('event.edit');
        Route::put('event/update/{id}', [EventController::class, 'update'])->name('event.update');
        Route::get('event/show/{id}', [EventController::class, 'show'])->name('event.show');
        Route::get('event/create', [EventController::class, 'create'])->name('event.create');
        Route::get('event/makeup/create', [EventController::class, 'createMakeup'])->name('makeupevent.create');
        Route::post('event/makeup/store', [EventController::class, 'storeMakeup'])->name('makeupevent.store');
        Route::get('event/makeup/edit/{id}', [EventController::class, 'editMakeup'])->name('makeupevent.edit');
        Route::put('event/makeup/update/{id}', [EventController::class, 'updateMakeup'])->name('makeupevent.update');
        Route::delete('event/makeup/destroy/{id}', [EventController::class, 'destroyMakeup'])->name('makeupevent.destroy');
        // wedding
        Route::resource('/', WeddingController::class);
        Route::get('wedding/main/edit/{id}', [WeddingController::class, 'edit'])->name('wedding.edit');
        Route::put('wedding/main/update/{id}', [WeddingController::class, 'update'])->name('wedding.update');
        Route::get('wedding/main/show/{id}', [WeddingController::class, 'show'])->name('wedding.show');
        Route::get('wedding/main/create', [WeddingController::class, 'create'])->name('wedding.create');
        Route::get('wedding/create', [WeddingController::class, 'createWedding'])->name('weddingmakeup.create');
        Route::post('wedding/store', [WeddingController::class, 'storeWedding'])->name('weddingmakeup.store');
        Route::get('wedding/edit/{id}', [WeddingController::class, 'editWedding'])->name('weddingmakeup.edit');
        Route::put('wedding/update/{id}', [WeddingController::class, 'updateWedding'])->name('weddingmakeup.update');
        Route::delete('wedding/destroy/{id}', [WeddingController::class, 'destroyWedding'])->name('weddingmakeup.destroy');
    });

    Route::prefix('decoration')->name('decoration.')->group(function () {
        Route::resource('/', DecorationController::class);
        // Route::get('edit/{id}', [DecorationController::class, 'edit'])->name('edit');
        // Route::put('update/{id}', [DecorationController::class, 'update'])->name('update');
        // Route::delete('destroy/{id}', [DecorationController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('entertainment')->name('entertainment.')->group(function () {
        Route::resource('/', EntertainmentController::class);
        Route::get('sound/edit/{id}', [EntertainmentController::class, 'edit'])->name('sound.edit');
        Route::put('sound/update/{id}', [EntertainmentController::class, 'update'])->name('sound.update');
        Route::delete('sound/destroy/{id}', [EntertainmentController::class, 'destroy'])->name('sound.destroy');
        Route::get('sound/show/{id}', [EntertainmentController::class, 'show'])->name('sound.show');
        Route::get('sound/create', [EntertainmentController::class, 'createSound'])->name('sound.create');
        Route::post('sound/store', [EntertainmentController::class, 'storeSound'])->name('sound.store');
        // Route::get('sound/show/{id}', [EntertainmentController::class, 'showSound'])->name('soundSystem.show');
        Route::get('sound/soundSystem/edit/{id}', [EntertainmentController::class, 'editSound'])->name('soundSystem.edit');
        Route::put('sound/soundSystem/update/{id}', [EntertainmentController::class, 'updateSound'])->name('soundSystem.update');
        Route::delete('sound/soundSystem/destroy/{id}', [EntertainmentController::class, 'destroySound'])->name('soundSystem.destroy');

        Route::get('live/edit/{id}', [EntertainmentController::class, 'editLive'])->name('live.edit');
        Route::put('live/update/{id}', [EntertainmentController::class, 'updateLive'])->name('live.update');
        Route::delete('live/destroy/{id}', [EntertainmentController::class, 'destroyLive'])->name('live.destroy');
        Route::get('live/show/{id}', [EntertainmentController::class, 'showLive'])->name('live.show');
        Route::get('live/create', [EntertainmentController::class, 'createLive'])->name('live.create');
        Route::post('live/store', [EntertainmentController::class, 'storeLive'])->name('live.store');
        Route::get('live/livemusic/edit/{id}', [EntertainmentController::class, 'editLiveMusic'])->name('livemusic.edit');
        Route::put('live/livemusic/update/{id}', [EntertainmentController::class, 'updateLiveMusic'])->name('livemusic.update');
        Route::delete('live/livemusic/destroy/{id}', [EntertainmentController::class, 'destroyLiveMusic'])->name('livemusic.destroy');



        Route::get('ceremonial/edit/{id}', [EntertainmentController::class, 'editCeremonial'])->name('ceremonial.edit');
        Route::put('ceremonial/update/{id}', [EntertainmentController::class, 'updateCeremonial'])->name('ceremonial.update');
        Route::delete('ceremonial/destroy/{id}', [EntertainmentController::class, 'destroyCeremonial'])->name('ceremonial.destroy');
        Route::get('ceremonial/show/{id}', [EntertainmentController::class, 'showCeremonial'])->name('ceremonial.show');
        Route::get('ceremonial/create', [EntertainmentController::class, 'createCeremonial'])->name('ceremonial.create');
        Route::post('ceremonial/store', [EntertainmentController::class, 'storeCeremonial'])->name('ceremonial.store');

        Route::get('ceremonial/ceremonialevent/edit/{id}', [EntertainmentController::class, 'editCeremonialEvent'])->name('ceremonialevent.edit');
        Route::put('ceremonial/ceremonialevent/update/{id}', [EntertainmentController::class, 'updateCeremonialEvent'])->name('ceremonialevent.update');
        Route::delete('ceremonial/ceremonialevent/destroy/{id}', [EntertainmentController::class, 'destroyCeremonialEvent'])->name('ceremonialevent.destroy');
    });
    Route::prefix('documentation')->name('documentation.')->group(function () {
        Route::resource('/', DocumentationController::class);
        Route::get('add-foto', [DocumentationController::class, 'addFoto'])->name('add-foto');
        Route::post('store-foto', [DocumentationController::class, 'storeFoto'])->name('store-foto');
    });

    Route::prefix('catering')->name('catering.')->group(function () {
        Route::resource('/', CateringController::class);
        // Route::get('edit/{id}', [CateringController::class, 'edit'])->name('edit');
        // Route::put('update/{id}', [CateringController::class, 'update'])->name('update');
        // Route::delete('destroy/{id}', [CateringController::class, 'destroy'])->name('destroy');
    });

    // recycle
    Route::prefix('recycle')->name('recycle.')->group(function () {
        Route::resource('', RecycleController::class);
    });

    Route::prefix('inbox')->name('inbox.')->group(function () {
        Route::view('/', 'back.pages.inbox.index')->name('index');
    });

    Route::prefix('aboutBackend')->name('aboutBackend.')->group(function () {
        Route::view('/', 'back.pages.about.index')->name('index');
    });

    Route::prefix('team')->name('team.')->group(function () {
        Route::view('/list', 'back.pages.team.index')->name('list');
        Route::resource('/', TeamLanoerController::class);
        // Route::get('edit/{id}', [TeamLanoerController::class, 'edit'])->name('edit');
        // Route::put('update/{id}', [TeamLanoerController::class, 'update'])->name('update');
        // Route::delete('destroy/{id}', [TeamLanoerController::class, 'destroy'])->name('destroy');
    });

    Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);

    Route::resource('slider', SliderController::class);
    Route::resource('testimoni', TestimoniController::class);
    Route::resource('client', ClientController::class);
});



Route::get('/test/env', function () {
    dd(env('lanoerwedding')); // Dump 'db' variable value one by one
});
