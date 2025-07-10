<?php

use App\Http\Controllers\Back\AboutController;
use App\Http\Controllers\Back\AlbumController;
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
use App\Http\Controllers\Back\GalleryController;
use App\Http\Controllers\Back\LiveController;
use App\Http\Controllers\Back\PinterestAuthController;
use App\Http\Controllers\Back\PinterestController;
use App\Http\Controllers\Back\PostController;
use App\Http\Controllers\Back\SliderController;
use App\Http\Controllers\Back\TeamLanoerController;
use App\Http\Controllers\Back\TestimoniController;
use App\Http\Controllers\Front\BlogController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\SitemapController;
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

Route::get('/documentation', [HomeController::class, 'documentation'])->name('portofolio');
Route::get('/documentation/foto/{slug}', [HomeController::class, 'showDocumentation'])->name('documentation.main.show');

Route::get('/gallery/list/', [HomeController::class, 'galleryMain'])->name('galleri');
Route::get('gallery/{slug}', [HomeController::class, 'showFotoGallery'])->name('gallery.main.show');

Route::get('makeup/event/{eventMakeupSlug}', [HomeController::class, 'detailEvent'])->name('makeup.event');
Route::get('makeup/event/show/{eventMakeupSlug}/{slug}', [HomeController::class, 'showEvent'])->name('makeup.event.detail');

Route::get('makeup/wedding/{weddingMakeupSlug}', [HomeController::class, 'detailWedding'])->name('makeup.wedding');
Route::get('makeup/wedding/{weddingMakeupSlug}/{slug}', [HomeController::class, 'showWedding'])->name('makeup.wedding.detail');

Route::get('decoration/list', [HomeController::class, 'decorationList'])->name('decoration.list');
Route::get('decoration/{slug}', [HomeController::class, 'showDecoration'])->name('decoration.detail.show');

Route::get('catering/list', [HomeController::class, 'cateringList'])->name('catering.list');
Route::get('catering/{slug}', [HomeController::class, 'showCatering'])->name('catering.detail.show');

Route::get('catering/premium/{slug}', [HomeController::class, 'showCateringPremium'])->name('premium.detail.show');
Route::get('catering/medium/{slug}', [HomeController::class, 'showCateringMedium'])->name('medium.detail.show');

Route::get('entertainment/list', [HomeController::class, 'entertainmentList'])
    ->name('entertainment.list');

Route::get('entertainment/detail/sound/{slug}/{soundSystemSlug}', [HomeController::class, 'showEntertainmentSound'])
    ->name('entertainment.sound.detail.show');

Route::get('entertainment/detail/live/{liveSlug}/{liveSubSlug}', [HomeController::class, 'showEntertainmentLive'])
    ->name('entertainment.live.detail.show');


Route::get('entertainment/detail/ceremony/{ceremonySlug}/{ceremonySubSlug}', [HomeController::class, 'showEntertainmentCeremony'])
    ->name('entertainment.ceremony.detail.show');



Route::get('/services', [HomeController::class, 'services'])->name('servicesHome');
Route::get('/blog', [HomeController::class, 'blog'])->name('blogHome');
Route::get('/contact', [HomeController::class, 'contact'])->name('contactHome');
Route::post('/contact', [HomeController::class, 'contactStore'])->name('contact.store');

Route::view('/blog', 'front.pages.home.blog.index')->name('blog');
Route::get('/blog/{any}', [BlogController::class, 'blogDetail'])->name('blog.detail');
Route::get('/blog/category/{any}', [BlogController::class, 'categoryPost'])->name('blog.category');
Route::get('/blog/tag/{any}', [BlogController::class, 'tagPost'])->name('blog.tag');
Route::get('/blog/{any}', [BlogController::class, 'readPost'])->name('blog.detail');

Route::middleware('throttle:10,1')->post('/search', [BlogController::class, 'searchBlog'])->name('blog.search');
Route::get('/search', [BlogController::class, 'showSearchResults'])->name('blog.search.results');
Route::get('/global-search', [HomeController::class, 'globalSearch'])->name('global.search');
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
Route::get('/robots.txt', [HomeController::class, 'robotsTxt']);
Route::get('/privacy-policy', [HomeController::class, 'privacyPolicy'])->name('privacy.policy');





// ROUTE BACKEND

Route::prefix('auth')->name('auth.')->group(function () {
    Route::view('/login', 'back.pages.auth.login')->name('login')->middleware('guest');
    Route::view('/forgot-password', 'back.pages.auth.forgot')->name('forgot-password')->middleware('guest');
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot-password.submit')->middleware('guest');
    Route::get('/reset-password/{token}', [AuthController::class, 'resetPasswordForm'])->name('reset-password.form')->middleware('guest');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('reset-password.submit')->middleware('guest');
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

    // event
    Route::prefix('event')->name('event.')->group(function () {
        Route::get('main/edit/{id}', [EventController::class, 'edit'])->name('main.edit');
        Route::put('main/update/{id}', [EventController::class, 'update'])->name('main.update');
        Route::get('main/show/{id}', [EventController::class, 'show'])->name('main.show');
        Route::get('main/create', [EventController::class, 'create'])->name('main.create');
        Route::get('sub/create', [EventController::class, 'createMakeup'])->name('sub.create');
        Route::post('sub/store', [EventController::class, 'storeMakeup'])->name('sub.store');
        Route::get('sub/edit/{id}', [EventController::class, 'editMakeup'])->name('sub.edit');
        Route::put('sub/update/{id}', [EventController::class, 'updateMakeup'])->name('sub.update');
        Route::delete('sub/destroy/{id}', [EventController::class, 'destroyMakeup'])->name('sub.destroy');
        Route::post('sub/upload-image', [EventController::class, 'uploadImage'])->name('upload.image');
        Route::post('sub/delete-image', [EventController::class, 'deleteImage'])->name('delete.image');
    });

    // wedding
    Route::prefix('wedding')->name('wedding.')->group(function () {
        Route::get('main/edit/{id}', [WeddingController::class, 'edit'])->name('main.edit');
        Route::put('main/update/{id}', [WeddingController::class, 'update'])->name('main.update');
        Route::get('main/show/{id}', [WeddingController::class, 'show'])->name('main.show');
        Route::get('main/create', [WeddingController::class, 'create'])->name('main.create');
        Route::get('sub/create', [WeddingController::class, 'createWedding'])->name('sub.create');
        Route::post('sub/store', [WeddingController::class, 'storeWedding'])->name('sub.store');
        Route::get('sub/edit/{id}', [WeddingController::class, 'editWedding'])->name('sub.edit');
        Route::put('sub/update/{id}', [WeddingController::class, 'updateWedding'])->name('sub.update');
        Route::delete('sub/destroy/{id}', [WeddingController::class, 'destroyWedding'])->name('sub.destroy');
        Route::post('sub/upload-image', [WeddingController::class, 'uploadImage'])->name('upload.image');
        Route::post('sub/delete-image', [WeddingController::class, 'deleteImage'])->name('delete.image');
    });

    Route::prefix('makeup')->name('makeup.')->group(function () {
        Route::view('/list', 'back.pages.makeup.list')->name('list');
    });

    Route::prefix('decoration')->name('decoration.')->group(function () {
        Route::resource('/', DecorationController::class);
        Route::get('main/edit/{id}', [DecorationController::class, 'edit'])->name('edit.decor');
        Route::put('main/update/{id}', [DecorationController::class, 'update'])->name('update.decor');
        Route::delete('main/destroy/{id}', [DecorationController::class, 'destroy'])->name('destroy.decor');
        Route::get('main/create', [DecorationController::class, 'create'])->name('create.decor');
        Route::delete('/decoration/gallery-image/{id}', [DecorationController::class, 'deleteGalleryImage'])->name('delete.gallery.image');
        Route::post('/upload-image', [DecorationController::class, 'uploadImage'])->name('upload.image');
        Route::post('/delete-image', [DecorationController::class, 'deleteImage'])->name('delete.image');
    });

    Route::prefix('entertainment')->name('entertainment.')->group(function () {
        Route::resource('/', EntertainmentController::class);
        // sound
        Route::get('sound/edit/{id}', [EntertainmentController::class, 'edit'])->name('sound.edit');
        Route::put('sound/update/{id}', [EntertainmentController::class, 'update'])->name('sound.update');
        Route::delete('sound/destroy/{id}', [EntertainmentController::class, 'destroy'])->name('sound.destroy');
        Route::get('sound/show/{id}', [EntertainmentController::class, 'show'])->name('sound.show');
        Route::get('sound/soundSystem/create', [EntertainmentController::class, 'createSound'])->name('sound.create');
        Route::post('sound/soundSystem/store', [EntertainmentController::class, 'storeSound'])->name('sound.store');
        Route::post('sound/soundSystem/upload', [EntertainmentController::class, 'soundContentImage'])->name('sound.uploadImage');
        // Route::get('sound/show/{id}', [EntertainmentController::class, 'showSound'])->name('soundSystem.show');
        Route::get('sound/soundSystem/edit/{id}', [EntertainmentController::class, 'editSound'])->name('soundSystem.edit');
        Route::put('sound/soundSystem/update/{id}', [EntertainmentController::class, 'updateSound'])->name('soundSystem.update');
        Route::delete('sound/soundSystem/destroy/{id}', [EntertainmentController::class, 'destroySound'])->name('soundSystem.destroy');
        Route::post('sound/soundSystem/upload-image', [EntertainmentController::class, 'uploadImage'])->name('upload.image');
        Route::post('sound/soundSystem/delete-image', [EntertainmentController::class, 'deleteImage'])->name('delete.image');

        // live
        Route::get('live/edit/{id}', [EntertainmentController::class, 'editLive'])->name('live.edit');
        Route::put('live/update/{id}', [EntertainmentController::class, 'updateLive'])->name('live.update');
        Route::delete('live/destroy/{id}', [EntertainmentController::class, 'destroyLive'])->name('live.destroy');
        Route::get('live/show/{id}', [EntertainmentController::class, 'showLive'])->name('live.show');
        Route::get('live/livemusic/create', [EntertainmentController::class, 'createLive'])->name('live.create');
        Route::post('live/livemusic/store', [EntertainmentController::class, 'storeLive'])->name('live.store');
        Route::get('live/livemusic/edit/{id}', [EntertainmentController::class, 'editLiveMusic'])->name('livemusic.edit');
        Route::put('live/livemusic/update/{id}', [EntertainmentController::class, 'updateLiveMusic'])->name('livemusic.update');
        Route::delete('live/livemusic/destroy/{id}', [EntertainmentController::class, 'destroyLiveMusic'])->name('livemusic.destroy');

        Route::post('live/livemusic/upload-image', [EntertainmentController::class, 'uploadImageLive'])->name('upload.image');
        Route::post('live/livemusic/delete-image', [EntertainmentController::class, 'deleteImageLive'])->name('delete.image');
        // ceremonial
        Route::get('ceremonial/edit/{id}', [EntertainmentController::class, 'editCeremonial'])->name('ceremonial.edit');
        Route::put('ceremonial/update/{id}', [EntertainmentController::class, 'updateCeremonial'])->name('ceremonial.update');
        Route::delete('ceremonial/destroy/{id}', [EntertainmentController::class, 'destroyCeremonial'])->name('ceremonial.destroy');
        Route::get('ceremonial/show/{id}', [EntertainmentController::class, 'showCeremonial'])->name('ceremonial.show');
        Route::get('ceremonial/ceremonialevent/create', [EntertainmentController::class, 'createCeremonial'])->name('ceremonial.create');
        Route::post('ceremonial/ceremonialevent/store', [EntertainmentController::class, 'storeCeremonial'])->name('ceremonial.store');

        Route::get('ceremonial/ceremonialevent/edit/{id}', [EntertainmentController::class, 'editCeremonialEvent'])->name('ceremonialevent.edit');
        Route::put('ceremonial/ceremonialevent/update/{id}', [EntertainmentController::class, 'updateCeremonialEvent'])->name('ceremonialevent.update');
        Route::delete('ceremonial/ceremonialevent/destroy/{id}', [EntertainmentController::class, 'destroyCeremonialEvent'])->name('ceremonialevent.destroy');

        Route::post('ceremonial/ceremonialevent/upload-image', [EntertainmentController::class, 'uploadImageCere'])->name('upload.image');
        Route::post('ceremonial/ceremonialevent/delete-image', [EntertainmentController::class, 'deleteImageCere'])->name('delete.image');
    });
    Route::prefix('documentationBack')->name('documentation.')->group(function () {
        Route::resource('/', DocumentationController::class);
        Route::get('add-foto', [DocumentationController::class, 'addFoto'])->name('add-foto');
        Route::post('store-foto', [DocumentationController::class, 'storeFoto'])->name('store-foto');
    });

    Route::prefix('catering')->name('catering.')->group(function () {

        Route::resource('/', CateringController::class);
        Route::get('main/create', [CateringController::class, 'create'])->name('main.create');
        Route::post('main/store', [CateringController::class, 'store'])->name('main.store');
        Route::get('main/edit/{id}', [CateringController::class, 'edit'])->name('main.edit');
        Route::put('main/update/{id}', [CateringController::class, 'update'])->name('main.update');
        Route::delete('main/destroy/{id}', [CateringController::class, 'destroy'])->name('main.destroy');
        Route::post('upload-image', [CateringController::class, 'uploadImage'])->name('upload.image');
        Route::post('delete-image', [CateringController::class, 'deleteImage'])->name('delete.image');


        // PREMIUM CATERING
        Route::get('sub/view/premium/{id}', [CateringController::class, 'viewPremium'])->name('sub.viewPremium');
        Route::get('sub/create/premium', [CateringController::class, 'createPremiumCatering'])->name('sub.createPremium');
        Route::post('sub/store/premium', [CateringController::class, 'storePremiumCatering'])->name('sub.storePremium');
        Route::get('sub/premium/edit/{id}', [CateringController::class, 'editPremiumCatering'])->name('sub.editPremium');
        Route::put('sub/premium/update/{id}', [CateringController::class, 'updatePremiumCatering'])->name('sub.updatePremium');
        Route::delete('/sub/premium/{id}', [CateringController::class, 'destroyPremiumCatering'])->name('sub.destroyPremium');
        Route::post('/sub/premium/upload-image/', [CateringController::class, 'uploadImagePremium'])->name('upload.imagePremium');
        Route::post('/sub/premium/delete-image/', [CateringController::class, 'deleteImagePremium'])->name('delete.imagePremium');
        Route::delete('/sub/gallery-image/{id}', [CateringController::class, 'deleteGalleryImage'])->name('delete.premiumGallery.image');



        // MEDIUM CATERING
        Route::get('sub/view/medium/{id}', [CateringController::class, 'viewMedium'])->name('sub.viewMedium');

        Route::get('sub/medium/create', [CateringController::class, 'createMediumCatering'])->name('sub.createMedium');
        Route::post('sub/medium/store', [CateringController::class, 'storeMediumCatering'])->name('sub.storeMedium');
        Route::get('sub/medium/edit/{id}', [CateringController::class, 'editMediumCatering'])->name('sub.editMedium');
        Route::put('sub/medium/update/{id}', [CateringController::class, 'updateMediumCatering'])->name('sub.updateMedium');
        Route::delete('sub/medium/destroy/{id}', [CateringController::class, 'destroyMediumCatering'])->name('sub.destroyMedium');
        Route::post('sub/medium/upload-image', [CateringController::class, 'uploadImageMedium'])->name('upload.imageMedium');
        Route::post('sub/medium/delete-image', [CateringController::class, 'deleteImageMedium'])->name('delete.imageMedium');
        Route::delete('/sub/medium/gallery-image/{id}', [CateringController::class, 'deleteGalleryImageMedium'])->name('delete.mediumGallery.image');
    });

    // recycle
    Route::prefix('recycle')->name('recycle.')->group(function () {
        Route::resource('', RecycleController::class);
    });

    Route::prefix('inbox')->name('inbox.')->group(function () {
        Route::view('/', 'back.pages.inbox.index')->name('index');
    });

    Route::prefix('aboutBackend')->name('aboutBackend.')->group(function () {
        Route::get('/main', [AboutController::class, 'mainAbout'])->name('main');
        Route::get('/main/edit/{id}', [AboutController::class, 'editAbout'])->name('mainEdit');
        Route::put('/main/{id}', [AboutController::class, 'updateAbout'])->name('update');
        Route::post('upload-image', [AboutController::class, 'uploadImage'])->name('upload.image');
        Route::post('delete-image', [AboutController::class, 'deleteImage'])->name('delete.image');
    });

    Route::prefix('team')->name('team.')->group(function () {
        Route::view('/list', 'back.pages.team.index')->name('list');
        // Route::resource('/', TeamLanoerController::class);
        Route::get('create', [TeamLanoerController::class, 'create'])->name('create');
        Route::post('store', [TeamLanoerController::class, 'store'])->name('store');
        Route::get('edit/{id}', [TeamLanoerController::class, 'edit'])->name('edit');
        Route::put('update/{id}', [TeamLanoerController::class, 'update'])->name('update');
        Route::delete('destroy/{id}', [TeamLanoerController::class, 'destroy'])->name('destroy');
    });

    Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index'])->name('logs');
    Route::resource('slider', SliderController::class);
    Route::resource('testimoni', TestimoniController::class);
    Route::resource('client', ClientController::class);

    Route::feeds();

    Route::prefix('posts')->name('posts.')->group(function () {
        Route::view('/categories', 'back.pages.posts.categories')->name('categories')->middleware('can:read category');
        Route::view('/add-post', 'back.pages.posts.add-post')->name('add-posts')->middleware('can:create post');
        Route::post('/create', [PostController::class, 'createPost'])->name('create');
        Route::view('/all-post', 'back.pages.posts.all_posts')->name('all_posts')
            ->middleware('can:read post');
        Route::get('/edit-posts', [PostController::class, 'editPost'])->name('edit-posts')
            ->middleware('can:update post');
        Route::post('/update-post', [PostController::class, 'updatePost'])->name('update-post')
            ->middleware('can:update post');
        Route::post('/post-upload', [PostController::class, 'contentImage'])->name('post-upload')
            ->middleware('can:create post');
    });

    Route::view('/comments', 'back.pages.comment.index')->name('comments');


    Route::post('/albums', [AlbumController::class, 'store'])->name('albums.store');
    Route::post('/albums/{id}', [AlbumController::class, 'update'])->name('albums.update');



    Route::view('/insert-code', 'back.pages.insert-code.index')->name('insert-code');
    Route::view('/indexing', 'back.pages.indexing.index')->name('indexing');

    Route::prefix('gallery')->name('gallery.')->group(function () {
        Route::resource('/', GalleryController::class);
        Route::get('add-foto-gallery', [GalleryController::class, 'addFotoGallery'])->name('add-foto.gallery');
        Route::post('store-foto-gallery', [GalleryController::class, 'storeFotoGallery'])->name('store-foto.gallery');
        Route::post('/gallery', [GalleryController::class, 'storeGallery'])->name('store');
        Route::post('/gallery/{id}', [GalleryController::class, 'updateGallery'])->name('update');
    });



    Route::get('/admin/pinterest/login', [PinterestAuthController::class, 'redirect'])->name('pinterest.login');
    Route::get('/pinterest/callback', [PinterestAuthController::class, 'callback'])->name('pinterest.callback');

    Route::get('/admin/pinterest/post-to-pinterest/{type}/{id}', [PinterestController::class, 'postToPinterest'])
        ->name('pinterest.post');

    Route::get('/admin/pinterest/boards', [PinterestController::class, 'listBoards'])->name('admin.pinterest.boards');
    Route::view('/admin/pinterest/access-token', 'back.pages.pinterest.access')->name('pinterest.accessToken');
});
