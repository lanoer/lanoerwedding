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
use App\Models\Weddings;
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
        return view('front.pages.home.services');
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

        // schema.org
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
        SEOMeta::setCanonical(url()->current());
        SEOMeta::setDescription($event->meta_desc);
        SEOMeta::addMeta('article:published_time', $event->created_at->toW3CString(), 'property');
        SEOMeta::addMeta('article:section', $event->name, 'property');
        SEOMeta::addKeyword($event->meta_keywords);

        OpenGraph::setDescription($event->meta_desc);
        OpenGraph::setTitle($event->name);
        OpenGraph::setUrl(url()->current());
        OpenGraph::addProperty('type', 'article');
        OpenGraph::addProperty('locale', 'id-ID');
        OpenGraph::addProperty('locale:alternate', ['en-us']);

        JsonLdMulti::setTitle($event->name);
        JsonLdMulti::setDescription($event->meta_desc);
        JsonLdMulti::setType('Article');
        JsonLdMulti::addImage($event->image);
        if (!JsonLdMulti::isEmpty()) {
            JsonLdMulti::newJsonLd();
            JsonLdMulti::setType('WebPage');
            JsonLdMulti::setTitle('Page Article - ' . $event->name);
        }
        OpenGraph::setTitle($event->name)
            ->setDescription($event->meta_desc)
            ->setType('article')
            ->setArticle([
                'created_at' => 'datetime',
                'updated_at' => 'datetime',
                'expiration_time' => 'datetime',
                'author' => "admin",
                'section' => "Event Makeup",
            ]);

        // Logika untuk menampilkan detail event
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
        SEOMeta::setCanonical(url()->current());
        SEOMeta::setDescription($wedding->meta_desc);
        SEOMeta::addMeta('article:published_time', $wedding->created_at->toW3CString(), 'property');
        SEOMeta::addMeta('article:section', $wedding->name, 'property');
        SEOMeta::addKeyword($wedding->meta_keywords);

        OpenGraph::setDescription($wedding->description, 150);
        OpenGraph::setTitle($wedding->name);
        OpenGraph::setUrl(url()->current());
        OpenGraph::addProperty('type', 'article');
        OpenGraph::addProperty('locale', 'id-ID');
        OpenGraph::addProperty('locale:alternate', ['en-us']);

        JsonLdMulti::setTitle($wedding->name);
        JsonLdMulti::setDescription($wedding->description, 150);
        JsonLdMulti::setType('Article');
        JsonLdMulti::addImage($wedding->image);
        if (!JsonLdMulti::isEmpty()) {
            JsonLdMulti::newJsonLd();
            JsonLdMulti::setType('WebPage');
            JsonLdMulti::setTitle('Page Article - ' . $wedding->name);
        }
        OpenGraph::setTitle($wedding->name)
            ->setDescription($wedding->description, 150)
            ->setType('article')
            ->setArticle([
                'created_at' => 'datetime',
                'updated_at' => 'datetime',
                'expiration_time' => 'datetime',
                'author' => "admin",
                'section' => "Wedding Makeup",
            ]);

        $teamCreative = TeamLanoer::get();
        return view('front.pages.home.weddings.show', compact('weddingMakeup', 'wedding', 'teamCreative', 'articleSchema', 'data'));
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
        $teamCreative = TeamLanoer::get();

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
        SEOMeta::setDescription($decoration->meta_desc);
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
        JsonLdMulti::setDescription($decoration->description, 150);
        JsonLdMulti::setType('Article');
        JsonLdMulti::addImage($decoration->image);
        if (!JsonLdMulti::isEmpty()) {
            JsonLdMulti::newJsonLd();
            JsonLdMulti::setType('WebPage');
            JsonLdMulti::setTitle('Page Article - ' . $decoration->name);
        }
        OpenGraph::setTitle($decoration->name)
            ->setDescription($decoration->description, 150)
            ->setType('article')
            ->setArticle([
                'created_at' => 'datetime',
                'updated_at' => 'datetime',
                'expiration_time' => 'datetime',
                'author' => "admin",
                'section' => "Decoration",
            ]);
        return view('front.pages.home.decoration.show', compact('decoration', 'teamCreative', 'articleSchema', 'data', 'galleryImages'));
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
        if ($sound) {
            views($sound)->record();
        }
        $teamCreative = TeamLanoer::get();
        // schema.org
        $logoUrl = $sound->image ? asset('back/images/sound/' . $sound->image) : '';
        $featuredImage = $sound->image ? asset('/storage/back/images/sound/' . $sound->image) : '';
        $articleSchema = Schema::article()
            ->headline($sound->name)
            ->author("admin")
            ->datePublished($sound->created_at->toW3CString())
            ->dateModified($sound->updated_at->toW3CString())
            ->mainEntityOfPage(Schema::webPage()->identifier(url()->current()))
            ->image($featuredImage)
            ->publisher(Schema::organization()
                ->name('Lanoer Wedding & Event Organizer')
                ->logo($logoUrl));
        $data = [
            'pageTitle' => Str::ucfirst($sound->name),
            'sound' => $sound,
            'articleSchema' => $articleSchema,
        ];

        SEOMeta::setTitle($sound->name);
        SEOMeta::setCanonical(url()->current());
        SEOMeta::setDescription($sound->meta_desc);
        SEOMeta::addMeta('article:published_time', $sound->created_at->toW3CString(), 'property');
        SEOMeta::addMeta('article:section', $sound->name, 'property');
        SEOMeta::addKeyword($sound->meta_keywords);

        OpenGraph::setDescription($sound->description, 150);
        OpenGraph::setTitle($sound->name);
        OpenGraph::setUrl(url()->current());
        OpenGraph::addProperty('type', 'article');
        OpenGraph::addProperty('locale', 'id-ID');
        OpenGraph::addProperty('locale:alternate', ['en-us']);

        JsonLdMulti::setTitle($sound->name);
        JsonLdMulti::setDescription($sound->description, 150);
        JsonLdMulti::setType('Article');
        JsonLdMulti::addImage($sound->image);
        if (!JsonLdMulti::isEmpty()) {
            JsonLdMulti::newJsonLd();
            JsonLdMulti::setType('WebPage');
            JsonLdMulti::setTitle('Page Article - ' . $sound->name);
        }
        OpenGraph::setTitle($sound->name)
            ->setDescription($sound->description, 150)
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
        $logoUrl = $live->image ? asset('back/images/live/' . $live->image) : '';
        $featuredImage = $live->image ? asset('/storage/back/images/live/' . $live->image) : '';
        $articleSchema = Schema::article()
            ->headline($live->name)
            ->author("admin")
            ->datePublished($live->created_at->toW3CString())
            ->dateModified($live->updated_at->toW3CString())
            ->mainEntityOfPage(Schema::webPage()->identifier(url()->current()))
            ->image($featuredImage)
            ->publisher(Schema::organization()
                ->name('Lanoer Wedding & Event Organizer')
                ->logo($logoUrl));
        $data = [
            'pageTitle' => Str::ucfirst($live->name),
            'live' => $live,
            'articleSchema' => $articleSchema,
        ];

        SEOMeta::setTitle($live->name);
        SEOMeta::setCanonical(url()->current());
        SEOMeta::setDescription($live->meta_desc);
        SEOMeta::addMeta('article:published_time', $live->created_at->toW3CString(), 'property');
        SEOMeta::addMeta('article:section', $live->name, 'property');
        SEOMeta::addKeyword($live->meta_keywords);

        OpenGraph::setDescription($live->description, 150);
        OpenGraph::setTitle($live->name);
        OpenGraph::setUrl(url()->current());
        OpenGraph::addProperty('type', 'article');
        OpenGraph::addProperty('locale', 'id-ID');
        OpenGraph::addProperty('locale:alternate', ['en-us']);

        JsonLdMulti::setTitle($live->name);
        JsonLdMulti::setDescription($live->description, 150);
        JsonLdMulti::setType('Article');
        JsonLdMulti::addImage($live->image);
        if (!JsonLdMulti::isEmpty()) {
            JsonLdMulti::newJsonLd();
            JsonLdMulti::setType('WebPage');
            JsonLdMulti::setTitle('Page Article - ' . $live->name);
        }
        OpenGraph::setTitle($live->name)
            ->setDescription($live->description, 150)
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
        $logoUrl = $ceremony->image ? asset('back/images/ceremony/' . $ceremony->image) : '';
        $featuredImage = $ceremony->image ? asset('/storage/back/images/ceremony/' . $ceremony->image) : '';
        $articleSchema = Schema::article()
            ->headline($ceremony->name)
            ->author("admin")
            ->datePublished($ceremony->created_at->toW3CString())
            ->dateModified($ceremony->updated_at->toW3CString())
            ->mainEntityOfPage(Schema::webPage()->identifier(url()->current()))
            ->image($featuredImage)
            ->publisher(Schema::organization()
                ->name('Lanoer Wedding & Event Organizer')
                ->logo($logoUrl));
        $data = [
            'pageTitle' => Str::ucfirst($ceremony->name),
            'ceremony' => $ceremony,
            'articleSchema' => $articleSchema,
        ];

        SEOMeta::setTitle($ceremony->name);
        SEOMeta::setCanonical(url()->current());
        SEOMeta::setDescription($ceremony->meta_desc);
        SEOMeta::addMeta('article:published_time', $ceremony->created_at->toW3CString(), 'property');
        SEOMeta::addMeta('article:section', $ceremony->name, 'property');
        SEOMeta::addKeyword($ceremony->meta_keywords);

        OpenGraph::setDescription($ceremony->description, 150);
        OpenGraph::setTitle($ceremony->name);
        OpenGraph::setUrl(url()->current());
        OpenGraph::addProperty('type', 'article');
        OpenGraph::addProperty('locale', 'id-ID');
        OpenGraph::addProperty('locale:alternate', ['en-us']);

        JsonLdMulti::setTitle($ceremony->name);
        JsonLdMulti::setDescription($ceremony->description, 150);
        JsonLdMulti::setType('Article');
        JsonLdMulti::addImage($ceremony->image);
        if (!JsonLdMulti::isEmpty()) {
            JsonLdMulti::newJsonLd();
            JsonLdMulti::setType('WebPage');
            JsonLdMulti::setTitle('Page Article - ' . $ceremony->name);
        }
        OpenGraph::setTitle($ceremony->name)
            ->setDescription($ceremony->description, 150)
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


    public function cateringList()
    {
        $catering = CateringPackages::get();
        $teamCreative = TeamLanoer::get();
        return view('front.pages.home.catering.list', compact('catering', 'teamCreative'));
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
        SEOMeta::setDescription($catering->meta_desc);
        SEOMeta::addMeta('article:published_time', $catering->created_at->toW3CString(), 'property');
        SEOMeta::addMeta('article:section', $catering->name, 'property');
        SEOMeta::addKeyword($catering->meta_keywords);

        OpenGraph::setDescription($catering->description, 150);
        OpenGraph::setTitle($catering->name);
        OpenGraph::setUrl(url()->current());
        OpenGraph::addProperty('type', 'article');
        OpenGraph::addProperty('locale', 'id-ID');
        OpenGraph::addProperty('locale:alternate', ['en-us']);

        JsonLdMulti::setTitle($catering->name);
        JsonLdMulti::setDescription($catering->description, 150);
        JsonLdMulti::setType('Article');
        JsonLdMulti::addImage($catering->image);
        if (!JsonLdMulti::isEmpty()) {
            JsonLdMulti::newJsonLd();
            JsonLdMulti::setType('WebPage');
            JsonLdMulti::setTitle('Page Article - ' . $catering->name);
        }
        OpenGraph::setTitle($catering->name)
            ->setDescription($catering->description, 150)
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
            'User-agent: ' . config('robots-txt.user-agent'),
        ];

        foreach (config('robots-txt.disallow') as $disallow) {
            $lines[] = "Disallow: $disallow";
        }

        foreach (config('robots-txt.allow') as $allow) {
            $lines[] = "Allow: $allow";
        }

        return response(implode("\n", $lines), 200, ['Content-Type' => 'text/plain']);
    }
}
