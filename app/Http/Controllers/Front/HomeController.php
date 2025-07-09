<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\Album;
use App\Models\CateringPackages;
use App\Models\Ceremonial;
use App\Models\CeremonialEvent;
use App\Models\Contact;
use App\Models\Decorations;
use App\Models\Event;
use App\Models\EventMakeups;
use App\Models\Foto;
use App\Models\Live;
use App\Models\LiveMusic;
use App\Models\Slider;
use App\Models\Sound;
use App\Models\SoundSystem;
use App\Models\TeamLanoer;
use App\Models\Video;
use App\Models\Wedding;
use App\Models\WeddingMakeups;
use App\Models\PremiumCatering;
use App\Models\MediumCatering;
use App\Models\Weddings;
use App\Models\GalleryFoto;
use App\Models\VideoGallery;
use App\Models\FotoGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\views;
use Spatie\SchemaOrg\Schema;
use Illuminate\Support\Str;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\JsonLdMulti;

class HomeController extends Controller
{
    public function index()
    {
        $event = Event::inRandomOrder()->get();
        $wedding = Weddings::inRandomOrder()->get();
        $eventMakeup = EventMakeups::inRandomOrder()->get();
        $weddingMakeup = WeddingMakeups::inRandomOrder()->get();
        return view('front.pages.home.index', compact('event', 'wedding', 'eventMakeup', 'weddingMakeup'));
    }

    public function about()
    {
        $about = About::first();
        if ($about) {
            views($about)->record();
        }
        // schema.org
        $logoUrl = $about->image ? asset('back/images/about/' . $about->image) : '';
        $featuredImage = $about->image ? asset('/storage/back/images/about/' . $about->image) : '';
        $articleSchema = Schema::article()
            ->headline($about->name)
            ->author("admin")
            ->datePublished($about->created_at->toW3CString())
            ->dateModified($about->updated_at->toW3CString())
            ->mainEntityOfPage(Schema::webPage()->identifier(url()->current()))
            ->image($featuredImage)
            ->publisher(Schema::organization()
                ->name('About us - Lanoer Wedding & Event Organizer')
                ->logo($logoUrl));
        $data = [
            'pageTitle' => Str::ucfirst($about->name),
            'about' => $about,
            'articleSchema' => $articleSchema,
        ];

        SEOMeta::setTitle($about->name);
        SEOMeta::setCanonical(url()->current());  // Set canonical URL
        SEOMeta::setDescription($about->meta_description);
        SEOMeta::addMeta('article:published_time', $about->created_at->toW3CString(), 'property');
        SEOMeta::addMeta('article:section', $about->name, 'property');
        SEOMeta::addKeyword($about->meta_keywords);

        OpenGraph::setDescription($about->meta_description);
        OpenGraph::setTitle($about->name);
        OpenGraph::setUrl(url()->current());
        OpenGraph::addProperty('type', 'article');
        OpenGraph::addProperty('locale', 'id-ID');
        OpenGraph::addProperty('locale:alternate', ['en-us']);

        JsonLdMulti::setTitle($about->name);
        JsonLdMulti::setDescription($about->meta_description);
        JsonLdMulti::setType('Article');
        JsonLdMulti::addImage($about->image);
        if (!JsonLdMulti::isEmpty()) {
            JsonLdMulti::newJsonLd();
            JsonLdMulti::setType('WebPage');
            JsonLdMulti::setTitle('Page Article - ' . $about->name);
        }
        $teamCreative = TeamLanoer::get();
        return view('front.pages.home.about', compact('about', 'teamCreative'));
    }

    public function makeups()
    {
        $teamCreative = TeamLanoer::get();
        return view('front.pages.home.makeups.index', compact('teamCreative'));
    }


    public function services()
    {
        $weddings = Weddings::with('weddingMakeups')->paginate(3);
        $event = event::with('eventMakeup')->paginate(3);


        return view('front.pages.home.services', compact('weddings', 'event'));
    }

    public function showEvent($eventMakeupSlug, $slug)
    {
        $eventMakeup = EventMakeups::where('slug', $eventMakeupSlug)->first();
        $event = Event::where('slug', $slug)->first();
        if ($event) {
            views($event)->record();
        }
        if (!$eventMakeup || !$event) {
            abort(404);
        }

        $teamCreative = TeamLanoer::get();

        // schema.or
        $logoUrl = $event->image ? asset('back/images/event/eventmakeup/' . $event->image) : '';
        $featuredImage = $event->image ? asset('/storage/back/images/event/eventmakeup/' . $event->image) : '';
        $articleSchema = Schema::article()
            ->headline($event->name)
            ->author("admin")
            ->datePublished($event->created_at->toW3CString())
            ->dateModified($event->updated_at->toW3CString())
            ->mainEntityOfPage(Schema::webPage()->identifier(url()->current()))
            ->image($featuredImage)
            ->publisher(Schema::organization()
                ->name('Lanoer Wedding & Event Organizer')
                ->logo($logoUrl));
        $data = [
            'pageTitle' => Str::ucfirst($event->name),
            'event' => $event,
            'articleSchema' => $articleSchema,
        ];

        SEOMeta::setTitle($event->name);
        SEOMeta::setCanonical(url()->current());  // Set canonical URL
        SEOMeta::setDescription($event->meta_description);
        SEOMeta::addMeta('article:published_time', $event->created_at->toW3CString(), 'property');
        SEOMeta::addMeta('article:section', $event->name, 'property');
        SEOMeta::addKeyword($event->meta_keywords);

        OpenGraph::setDescription($event->meta_description);
        OpenGraph::setTitle($event->name);
        OpenGraph::setUrl(url()->current());
        OpenGraph::addProperty('type', 'article');
        OpenGraph::addProperty('locale', 'id-ID');
        OpenGraph::addProperty('locale:alternate', ['en-us']);

        JsonLdMulti::setTitle($event->name);
        JsonLdMulti::setDescription($event->meta_description);
        JsonLdMulti::setType('Article');
        JsonLdMulti::addImage($event->image);
        if (!JsonLdMulti::isEmpty()) {
            JsonLdMulti::newJsonLd();
            JsonLdMulti::setType('WebPage');
            JsonLdMulti::setTitle('Page Article - ' . $event->name);
        }

        // Menampilkan halaman detail event
        return view('front.pages.home.makeups.show', compact('eventMakeup', 'event', 'teamCreative', 'articleSchema', 'data'));
    }


    public function detailEvent($eventMakeupSlug)
    {
        $eventMakeup = EventMakeups::where('slug', $eventMakeupSlug)
            ->with('events') // eager load relasi events
            ->first();
        if ($eventMakeup) {
            views($eventMakeup)->record();
        }
        if (!$eventMakeup) {
            abort(404);
        }

        $teamCreative = TeamLanoer::get();

        return view('front.pages.home.makeups.detail', compact('eventMakeup', 'teamCreative'));
    }



    public function showWedding($weddingMakeupSlug, $slug)
    {
        $weddingMakeup = WeddingMakeups::where('slug', $weddingMakeupSlug)->first();
        $wedding = Weddings::where('slug', $slug)->first();
        if ($wedding) {
            views($wedding)->record();
        }
        if (!$weddingMakeup || !$wedding) {
            abort(404);
        }

        // schema.org
        $logoUrl = $wedding->image ? asset('back/images/event/wedding/' . $wedding->image) : '';
        $featuredImage = $wedding->image ? asset('/storage/back/images/event/wedding/' . $wedding->image) : '';
        $articleSchema = Schema::article()
            ->headline($wedding->name)
            ->author("admin")
            ->datePublished($wedding->created_at->toW3CString())
            ->dateModified($wedding->updated_at->toW3CString())
            ->mainEntityOfPage(Schema::webPage()->identifier(url()->current()))
            ->image($featuredImage)
            ->publisher(Schema::organization()
                ->name('Lanoer Wedding & Event Organizer')
                ->logo($logoUrl));
        $data = [
            'pageTitle' => Str::ucfirst($wedding->name),
            'wedding' => $wedding,
            'articleSchema' => $articleSchema,
        ];

        SEOMeta::setTitle($wedding->name);
        SEOMeta::setCanonical(url()->current());  // Set canonical URL
        SEOMeta::setDescription($wedding->meta_description);
        SEOMeta::addMeta('article:published_time', $wedding->created_at->toW3CString(), 'property');
        SEOMeta::addMeta('article:section', $wedding->name, 'property');
        SEOMeta::addKeyword($wedding->meta_keywords);

        OpenGraph::setDescription($wedding->meta_description);
        OpenGraph::setTitle($wedding->name);
        OpenGraph::setUrl(url()->current());
        OpenGraph::addProperty('type', 'article');
        OpenGraph::addProperty('locale', 'id-ID');
        OpenGraph::addProperty('locale:alternate', ['en-us']);

        JsonLdMulti::setTitle($wedding->name);
        JsonLdMulti::setDescription($wedding->meta_description);
        JsonLdMulti::setType('Article');
        JsonLdMulti::addImage($wedding->image);
        if (!JsonLdMulti::isEmpty()) {
            JsonLdMulti::newJsonLd();
            JsonLdMulti::setType('WebPage');
            JsonLdMulti::setTitle('Page Article - ' . $wedding->name);
        }

        // Menampilkan halaman detail wedding
        return view('front.pages.home.weddings.show', compact('weddingMakeup', 'wedding', 'articleSchema', 'data'));
    }

    public function detailWedding($weddingMakeupSlug)
    {
        $weddingMakeup = WeddingMakeups::where('slug', $weddingMakeupSlug)
            ->with('weddings') // eager load relasi events
            ->first();
        if ($weddingMakeup) {
            views($weddingMakeup)->record();
        }
        if (!$weddingMakeup) {
            abort(404);
        }

        $teamCreative = TeamLanoer::get();

        return view('front.pages.home.weddings.detail', compact('weddingMakeup', 'teamCreative'));
    }
    public function decorationList()
    {
        $decoration = Decorations::get();
        $teamCreative = TeamLanoer::get();
        return view('front.pages.home.decoration.list', compact('decoration', 'teamCreative'));
    }

    public function showDecoration($slug)
    {
        $decoration = Decorations::with('images')->where('slug', $slug)->first();
        $galleryImages = $decoration->images()->paginate(3);
        if ($decoration) {
            views($decoration)->record();
        }

        // schema.org
        $logoUrl = $decoration->image ? asset('back/images/decoration/' . $decoration->image) : '';
        $featuredImage = $decoration->image ? asset('/storage/back/images/decoration/' . $decoration->image) : '';
        $articleSchema = Schema::article()
            ->headline($decoration->name)
            ->author("admin")
            ->datePublished($decoration->created_at->toW3CString())
            ->dateModified($decoration->updated_at->toW3CString())
            ->mainEntityOfPage(Schema::webPage()->identifier(url()->current()))
            ->image($featuredImage)
            ->publisher(Schema::organization()
                ->name('Lanoer Wedding & Event Organizer')
                ->logo($logoUrl));
        $data = [
            'pageTitle' => Str::ucfirst($decoration->name),
            'decoration' => $decoration,
            'articleSchema' => $articleSchema,
        ];

        SEOMeta::setTitle($decoration->name);
        SEOMeta::setCanonical(url()->current());
        SEOMeta::setDescription($decoration->meta_description);
        SEOMeta::addMeta('article:published_time', $decoration->created_at->toW3CString(), 'property');
        SEOMeta::addMeta('article:section', $decoration->name, 'property');
        SEOMeta::addKeyword($decoration->meta_keywords);

        OpenGraph::setDescription($decoration->description, 150);
        OpenGraph::setTitle($decoration->name);
        OpenGraph::setUrl(url()->current());
        OpenGraph::addProperty('type', 'article');
        OpenGraph::addProperty('locale', 'id-ID');
        OpenGraph::addProperty('locale:alternate', ['en-us']);

        JsonLdMulti::setTitle($decoration->name);
        JsonLdMulti::setDescription($decoration->meta_description, 150);
        JsonLdMulti::setType('Article');
        JsonLdMulti::addImage($decoration->image);
        if (!JsonLdMulti::isEmpty()) {
            JsonLdMulti::newJsonLd();
            JsonLdMulti::setType('WebPage');
            JsonLdMulti::setTitle('Page Article - ' . $decoration->name);
        }
        OpenGraph::setTitle($decoration->name)
            ->setDescription($decoration->meta_description, 150)
            ->setType('article')
            ->setArticle([
                'created_at' => 'datetime',
                'updated_at' => 'datetime',
                'expiration_time' => 'datetime',
                'author' => "admin",
                'section' => "Decoration",
            ]);
        return view('front.pages.home.decoration.show', compact('decoration', 'articleSchema', 'data', 'galleryImages'));
    }

    public function entertainmentList()
    {
        $sound = Sound::first();
        $soundSystem = SoundSystem::get();
        $live = Live::first();
        $liveMusic = LiveMusic::get();
        $ceremony = Ceremonial::first();
        $ceremonySub = CeremonialEvent::get();
        $teamCreative = TeamLanoer::get();


        return view('front.pages.home.entertainment.list', compact('sound', 'soundSystem', 'live', 'liveMusic', 'ceremony', 'ceremonySub', 'teamCreative'));
    }

    public function showEntertainmentSound($slug, $soundSystemSlug)
    {

        $sound = Sound::where('slug', $slug)->first();
        $soundSystem = SoundSystem::where('slug', $soundSystemSlug)->first();
        if (!$sound || !$soundSystem) {
            abort(404);
        }
        if ($soundSystem) {
            views($soundSystem)->record();
        }
        $teamCreative = TeamLanoer::get();
        // schema.org
        $logoUrl = $soundSystem->image ? asset('back/images/sound/' . $soundSystem->image) : '';
        $featuredImage = $soundSystem->image ? asset('/storage/back/images/sound/' . $soundSystem->image) : '';
        $articleSchema = Schema::article()
            ->headline($soundSystem->name)
            ->author("admin")
            ->datePublished($soundSystem->created_at->toW3CString())
            ->dateModified($soundSystem->updated_at->toW3CString())
            ->mainEntityOfPage(Schema::webPage()->identifier(url()->current()))
            ->image($featuredImage)
            ->publisher(Schema::organization()
                ->name('Lanoer Wedding & Event Organizer')
                ->logo($logoUrl));
        $data = [
            'pageTitle' => Str::ucfirst($soundSystem->name),
            'sound' => $soundSystem,
            'articleSchema' => $articleSchema,
        ];

        SEOMeta::setTitle($soundSystem->name);
        SEOMeta::setCanonical(url()->current());
        SEOMeta::setDescription($soundSystem->meta_description);
        SEOMeta::addMeta('article:published_time', $soundSystem->created_at->toW3CString(), 'property');
        SEOMeta::addMeta('article:section', $soundSystem->name, 'property');
        SEOMeta::addKeyword($soundSystem->meta_keywords);

        OpenGraph::setDescription($soundSystem->meta_description);
        OpenGraph::setTitle($soundSystem->name);
        OpenGraph::setUrl(url()->current());
        OpenGraph::addProperty('type', 'article');
        OpenGraph::addProperty('locale', 'id-ID');
        OpenGraph::addProperty('locale:alternate', ['en-us']);

        JsonLdMulti::setTitle($soundSystem->name);
        JsonLdMulti::setDescription($soundSystem->meta_description);
        JsonLdMulti::setType('Article');
        JsonLdMulti::addImage($soundSystem->image);
        if (!JsonLdMulti::isEmpty()) {
            JsonLdMulti::newJsonLd();
            JsonLdMulti::setType('WebPage');
            JsonLdMulti::setTitle('Page Article - ' . $soundSystem->name);
        }
        OpenGraph::setTitle($soundSystem->name)
            ->setDescription($soundSystem->meta_description)
            ->setType('article')
            ->setArticle([
                'created_at' => 'datetime',
                'updated_at' => 'datetime',
                'expiration_time' => 'datetime',
                'author' => "admin",
                'section' => "Sound",
            ]);

        return view('front.pages.home.entertainment.sound.show', compact('soundSystem', 'sound', 'teamCreative', 'articleSchema', 'data'));
    }
    public function showEntertainmentLive($liveSlug, $liveSubSlug)
    {
        $live = Live::where('slug', $liveSlug)->first();
        $liveMusic = LiveMusic::where('slug', $liveSubSlug)->first();

        if (!$live || !$liveMusic) {
            abort(404);
        }
        if ($live) {
            views($live)->record();
        }
        if ($liveMusic) {
            views($liveMusic)->record();
        }
        $teamCreative = TeamLanoer::get();

        // schema.org
        $logoUrl = $liveMusic->image ? asset('back/images/live/' . $liveMusic->image) : '';
        $featuredImage = $liveMusic->image ? asset('/storage/back/images/live/' . $liveMusic->image) : '';
        $articleSchema = Schema::article()
            ->headline($liveMusic->name)
            ->author("admin")
            ->datePublished($liveMusic->created_at->toW3CString())
            ->dateModified($liveMusic->updated_at->toW3CString())
            ->mainEntityOfPage(Schema::webPage()->identifier(url()->current()))
            ->image($featuredImage)
            ->publisher(Schema::organization()
                ->name('Lanoer Wedding & Event Organizer')
                ->logo($logoUrl));
        $data = [
            'pageTitle' => Str::ucfirst($liveMusic->name),
            'live' => $liveMusic,
            'articleSchema' => $articleSchema,
        ];

        SEOMeta::setTitle($liveMusic->name);
        SEOMeta::setCanonical(url()->current());
        SEOMeta::setDescription($live->meta_description);
        SEOMeta::addMeta('article:published_time', $liveMusic->created_at->toW3CString(), 'property');
        SEOMeta::addMeta('article:section', $liveMusic->name, 'property');
        SEOMeta::addKeyword($liveMusic->meta_keywords);

        OpenGraph::setDescription($liveMusic->meta_description);
        OpenGraph::setTitle($liveMusic->name);
        OpenGraph::setUrl(url()->current());
        OpenGraph::addProperty('type', 'article');
        OpenGraph::addProperty('locale', 'id-ID');
        OpenGraph::addProperty('locale:alternate', ['en-us']);

        JsonLdMulti::setTitle($liveMusic->name);
        JsonLdMulti::setDescription($liveMusic->meta_description);
        JsonLdMulti::setType('Article');
        JsonLdMulti::addImage($liveMusic->image);
        if (!JsonLdMulti::isEmpty()) {
            JsonLdMulti::newJsonLd();
            JsonLdMulti::setType('WebPage');
            JsonLdMulti::setTitle('Page Article - ' . $liveMusic->name);
        }
        OpenGraph::setTitle($liveMusic->name)
            ->setDescription($liveMusic->meta_description)
            ->setType('article')
            ->setArticle([
                'created_at' => 'datetime',
                'updated_at' => 'datetime',
                'expiration_time' => 'datetime',
                'author' => "admin",
                'section' => "Live",
            ]);

        return view('front.pages.home.entertainment.live.show', compact('live', 'liveMusic', 'teamCreative', 'articleSchema', 'data'));
    }


    public function showEntertainmentCeremony($ceremonySlug, $ceremonySubSlug)
    {
        $ceremony = Ceremonial::where('slug', $ceremonySlug)->first();
        $ceremonySub = CeremonialEvent::where('slug', $ceremonySubSlug)->first();

        if (!$ceremony || !$ceremonySub) {
            abort(404);
        }
        if ($ceremony) {
            views($ceremony)->record();
        }
        if ($ceremonySub) {
            views($ceremonySub)->record();
        }
        $teamCreative = TeamLanoer::get();

        // schema.org
        $logoUrl = $ceremonySub->image ? asset('back/images/ceremony/' . $ceremonySub->image) : '';
        $featuredImage = $ceremonySub->image ? asset('/storage/back/images/ceremony/' . $ceremonySub->image) : '';
        $articleSchema = Schema::article()
            ->headline($ceremonySub->name)
            ->author("admin")
            ->datePublished($ceremonySub->created_at->toW3CString())
            ->dateModified($ceremonySub->updated_at->toW3CString())
            ->mainEntityOfPage(Schema::webPage()->identifier(url()->current()))
            ->image($featuredImage)
            ->publisher(Schema::organization()
                ->name('Lanoer Wedding & Event Organizer')
                ->logo($logoUrl));
        $data = [
            'pageTitle' => Str::ucfirst($ceremonySub->name),
            'ceremony' => $ceremonySub,
            'articleSchema' => $articleSchema,
        ];

        SEOMeta::setTitle($ceremonySub->name);
        SEOMeta::setCanonical(url()->current());
        SEOMeta::setDescription($ceremonySub->meta_description);
        SEOMeta::addMeta('article:published_time', $ceremonySub->created_at->toW3CString(), 'property');
        SEOMeta::addMeta('article:section', $ceremonySub->name, 'property');
        SEOMeta::addKeyword($ceremonySub->meta_keywords);

        OpenGraph::setDescription($ceremonySub->meta_description);
        OpenGraph::setTitle($ceremonySub->name);
        OpenGraph::setUrl(url()->current());
        OpenGraph::addProperty('type', 'article');
        OpenGraph::addProperty('locale', 'id-ID');
        OpenGraph::addProperty('locale:alternate', ['en-us']);

        JsonLdMulti::setTitle($ceremonySub->name);
        JsonLdMulti::setDescription($ceremonySub->description);
        JsonLdMulti::setType('Article');
        JsonLdMulti::addImage($ceremonySub->image);
        if (!JsonLdMulti::isEmpty()) {
            JsonLdMulti::newJsonLd();
            JsonLdMulti::setType('WebPage');
            JsonLdMulti::setTitle('Page Article - ' . $ceremonySub->name);
        }
        OpenGraph::setTitle($ceremonySub->name)
            ->setDescription($ceremonySub->description)
            ->setType('article')
            ->setArticle([
                'created_at' => 'datetime',
                'updated_at' => 'datetime',
                'expiration_time' => 'datetime',
                'author' => "admin",
                'section' => "Ceremony",
            ]);
        return view('front.pages.home.entertainment.ceremony.show', compact('ceremony', 'ceremonySub', 'teamCreative', 'articleSchema', 'data'));
    }


    public function Slider()
    {
        $slider = Slider::get();
        return view('front.pages.home.slider', compact('slider'));
    }
    public function documentation()
    {
        $album = Album::with('Foto')->paginate(6);
        $videos = Video::paginate(3);

        return view('front.pages.home.documentation.index', compact('album', 'videos'));
    }


    public function showDocumentation($slug)
    {
        $album = Album::where('slug', $slug)->first();
        $fotos = $album ? $album->Foto()->paginate(3) : collect(); // paginate 6 per page
        $videos = Video::get();
        if ($album) {
            views($album)->record();
        }
        return view('front.pages.home.documentation.show', compact('album', 'fotos', 'videos'));
    }
    public function galleryMain()
    {
        $gallery = GalleryFoto::with('FotoGallery')->paginate(6);
        $videosGallery = VideoGallery::paginate(3);

        return view('front.pages.home.gallery.index', compact('gallery', 'videosGallery'));
    }


    public function showFotoGallery($slug)
    {
        $gallery = GalleryFoto::where('slug', $slug)->first();
        $fotosGallery = $gallery ? $gallery->FotoGallery()->paginate(3) : collect(); // paginate 6 per page
        $videosGallery = Video::get();
        if ($gallery) {
            views($gallery)->record();
        }
        return view('front.pages.home.gallery.show', compact('gallery', 'fotosGallery', 'videosGallery'));
    }


    public function cateringList()
    {
        // Mengambil semua catering packages beserta relasi mediumCaterings dan premiumCaterings
        $cateringList = CateringPackages::with(['premiumCaterings', 'mediumCaterings'])->get();

        // Memeriksa jika data kosong
        if ($cateringList->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada data catering packages');
        }

        // Mengirim data ke view
        return view('front.pages.home.catering.list', compact('cateringList'));
    }





    public function showCatering($slug)
    {
        $catering = CateringPackages::where('slug', $slug)->first();
        if ($catering) {
            views($catering)->record();
        }
        $teamCreative = TeamLanoer::get();

        // schema.org
        $logoUrl = $catering->image ? asset('back/images/catering/' . $catering->image) : '';
        $featuredImage = $catering->image ? asset('/storage/back/images/catering/' . $catering->image) : '';
        $articleSchema = Schema::article()
            ->headline($catering->name)
            ->author("admin")
            ->datePublished($catering->created_at->toW3CString())
            ->dateModified($catering->updated_at->toW3CString())
            ->mainEntityOfPage(Schema::webPage()->identifier(url()->current()))
            ->image($featuredImage)
            ->publisher(Schema::organization()
                ->name('Lanoer Wedding & Event Organizer')
                ->logo($logoUrl));
        $data = [
            'pageTitle' => Str::ucfirst($catering->name),
            'catering' => $catering,
            'articleSchema' => $articleSchema,
        ];

        SEOMeta::setTitle($catering->name);
        SEOMeta::setCanonical(url()->current());
        SEOMeta::setDescription($catering->meta_description);
        SEOMeta::addMeta('article:published_time', $catering->created_at->toW3CString(), 'property');
        SEOMeta::addMeta('article:section', $catering->name, 'property');
        SEOMeta::addKeyword($catering->meta_keywords);

        OpenGraph::setDescription($catering->meta_description);
        OpenGraph::setTitle($catering->name);
        OpenGraph::setUrl(url()->current());
        OpenGraph::addProperty('type', 'article');
        OpenGraph::addProperty('locale', 'id-ID');
        OpenGraph::addProperty('locale:alternate', ['en-us']);

        JsonLdMulti::setTitle($catering->name);
        JsonLdMulti::setDescription($catering->meta_description);
        JsonLdMulti::setType('Article');
        JsonLdMulti::addImage($catering->image);
        if (!JsonLdMulti::isEmpty()) {
            JsonLdMulti::newJsonLd();
            JsonLdMulti::setType('WebPage');
            JsonLdMulti::setTitle('Page Article - ' . $catering->name);
        }
        OpenGraph::setTitle($catering->name)
            ->setDescription($catering->meta_description)
            ->setType('article')
            ->setArticle([
                'created_at' => 'datetime',
                'updated_at' => 'datetime',
                'expiration_time' => 'datetime',
                'author' => "admin",
                'section' => "Catering",
            ]);
        return view('front.pages.home.catering.show', compact('catering', 'teamCreative', 'articleSchema', 'data'));
    }
    public function showCateringPremium($slug)
    {
        $premium = PremiumCatering::with('images')->where('slug', $slug)->first();
        $galleryImages = $premium->images()->paginate(3);
        if ($premium) {
            views($premium)->record();
        }

        // schema.org
        $logoUrl = $premium->image ? asset('back/images/premium/' . $premium->image) : '';
        $featuredImage = $premium->image ? asset('/storage/back/images/premium/' . $premium->image) : '';
        $articleSchema = Schema::article()
            ->headline($premium->name)
            ->author("admin")
            ->datePublished($premium->created_at->toW3CString())
            ->dateModified($premium->updated_at->toW3CString())
            ->mainEntityOfPage(Schema::webPage()->identifier(url()->current()))
            ->image($featuredImage)
            ->publisher(Schema::organization()
                ->name('Lanoer Wedding & Event Organizer')
                ->logo($logoUrl));
        $data = [
            'pageTitle' => Str::ucfirst($premium->name),
            'premium' => $premium,
            'articleSchema' => $articleSchema,
        ];

        SEOMeta::setTitle($premium->name);
        SEOMeta::setCanonical(url()->current());
        SEOMeta::setDescription($premium->meta_description);
        SEOMeta::addMeta('article:published_time', $premium->created_at->toW3CString(), 'property');
        SEOMeta::addMeta('article:section', $premium->name, 'property');
        SEOMeta::addKeyword($premium->meta_keywords);

        OpenGraph::setDescription($premium->description, 150);
        OpenGraph::setTitle($premium->name);
        OpenGraph::setUrl(url()->current());
        OpenGraph::addProperty('type', 'article');
        OpenGraph::addProperty('locale', 'id-ID');
        OpenGraph::addProperty('locale:alternate', ['en-us']);

        JsonLdMulti::setTitle($premium->name);
        JsonLdMulti::setDescription($premium->meta_description, 150);
        JsonLdMulti::setType('Article');
        JsonLdMulti::addImage($premium->image);
        if (!JsonLdMulti::isEmpty()) {
            JsonLdMulti::newJsonLd();
            JsonLdMulti::setType('WebPage');
            JsonLdMulti::setTitle('Page Article - ' . $premium->name);
        }
        OpenGraph::setTitle($premium->name)
            ->setDescription($premium->meta_description, 150)
            ->setType('article')
            ->setArticle([
                'created_at' => 'datetime',
                'updated_at' => 'datetime',
                'expiration_time' => 'datetime',
                'author' => "admin",
                'section' => "premium",
            ]);
        return view('front.pages.home.catering.premium-show', compact('premium', 'articleSchema', 'data', 'galleryImages'));
    }

    public function showCateringMedium($slug)
    {
        $medium = MediumCatering::where('slug', $slug)->first();
        if ($medium) {
            views($medium)->record();
        }

        // schema.org
        $logoUrl = $medium->image ? asset('back/images/catering/medium/' . $medium->image) : '';
        $featuredImage = $medium->image ? asset('/storage/back/images/catering/medium/' . $medium->image) : '';
        $articleSchema = Schema::article()
            ->headline($medium->name)
            ->author("admin")
            ->datePublished($medium->created_at->toW3CString())
            ->dateModified($medium->updated_at->toW3CString())
            ->mainEntityOfPage(Schema::webPage()->identifier(url()->current()))
            ->image($featuredImage)
            ->publisher(Schema::organization()
                ->name('Lanoer Wedding & Event Organizer')
                ->logo($logoUrl));
        $data = [
            'pageTitle' => Str::ucfirst($medium->name),
            'catering' => $medium,
            'articleSchema' => $articleSchema,
        ];

        SEOMeta::setTitle($medium->name);
        SEOMeta::setCanonical(url()->current());
        SEOMeta::setDescription($medium->meta_description);
        SEOMeta::addMeta('article:published_time', $medium->created_at->toW3CString(), 'property');
        SEOMeta::addMeta('article:section', $medium->name, 'property');
        SEOMeta::addKeyword($medium->meta_keywords);

        OpenGraph::setDescription($medium->meta_description);
        OpenGraph::setTitle($medium->name);
        OpenGraph::setUrl(url()->current());
        OpenGraph::addProperty('type', 'article');
        OpenGraph::addProperty('locale', 'id-ID');
        OpenGraph::addProperty('locale:alternate', ['en-us']);

        JsonLdMulti::setTitle($medium->name);
        JsonLdMulti::setDescription($medium->meta_description);
        JsonLdMulti::setType('Article');
        JsonLdMulti::addImage($medium->image);
        if (!JsonLdMulti::isEmpty()) {
            JsonLdMulti::newJsonLd();
            JsonLdMulti::setType('WebPage');
            JsonLdMulti::setTitle('Page Article - ' . $medium->name);
        }
        OpenGraph::setTitle($medium->name)
            ->setDescription($medium->meta_description)
            ->setType('article')
            ->setArticle([
                'created_at' => 'datetime',
                'updated_at' => 'datetime',
                'expiration_time' => 'datetime',
                'author' => "admin",
                'section' => "medium",
            ]);
        return view('front.pages.home.catering.medium-show', compact('medium',  'articleSchema', 'data'));
    }


    public function contact()
    {
        return view('front.pages.home.contact');
    }


    public function contactStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'telp' => 'required',
            'pesan' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed.',
                'errors' => $validator->errors(),
            ], 422);
        }

        Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'telp' => $request->telp,
            'url' => $request->url,
            'pesan' => $request->pesan,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Message sent successfully.'
        ]);
    }


    public function robotsTxt()
    {
        $lines = [
            'User-agent: *',  // Semua user-agent (semua mesin pencari)

            // Mengizinkan crawling untuk semua halaman frontend yang dapat diakses publik
            'Allow: /',

            // Memblokir crawling untuk halaman backend dan halaman yang memerlukan login
            'Disallow: /auth/login',
            'Disallow: /auth/forgot-password',
            'Disallow: /auth/reset-password',
            'Disallow: /home',
            'Disallow: /dashboard',
            'Disallow: /admin',
            'Disallow: /users',
            'Disallow: /settings',
            'Disallow: /role',
            'Disallow: /permissions',
            'Disallow: /posts',
            'Disallow: /makeup',
            'Disallow: /wedding',
            'Disallow: /decoration',
            'Disallow: /entertainment',

            // Menambahkan lokasi sitemap
            'Sitemap: https://lanoerwedding.com/sitemap.xml' // Lokasi sitemap
        ];

        return response(implode("\n", $lines), 200, ['Content-Type' => 'text/plain']);
    }

    public function privacyPolicy()
    {
        return view('front.pages.home.privay-policy');
    }
}
