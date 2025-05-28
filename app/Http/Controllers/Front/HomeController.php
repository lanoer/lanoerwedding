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

        if (!$eventMakeup || !$event) {
            abort(404);
        }

        $teamCreative = TeamLanoer::get();

        // Logika untuk menampilkan detail event
        return view('front.pages.home.makeups.show', compact('eventMakeup', 'event', 'teamCreative'));
    }

    public function detailEvent($eventMakeupSlug)
    {
        $eventMakeup = EventMakeups::where('slug', $eventMakeupSlug)
            ->with('events') // eager load relasi events
            ->first();

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

        if (!$weddingMakeup || !$wedding) {
            abort(404);
        }

        $teamCreative = TeamLanoer::get();
        return view('front.pages.home.weddings.show', compact('weddingMakeup', 'wedding', 'teamCreative'));
    }

    public function decorationList()
    {
        $decoration = Decorations::get();
        $teamCreative = TeamLanoer::get();
        return view('front.pages.home.decoration.list', compact('decoration', 'teamCreative'));
    }

    public function showDecoration($slug)
    {
        $decoration = Decorations::where('slug', $slug)->first();
        $teamCreative = TeamLanoer::get();
        return view('front.pages.home.decoration.show', compact('decoration', 'teamCreative'));
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

    public function showEntertainmentSound($soundSystemSlug, $slug)
    {

        $soundSystem = SoundSystem::where('slug', $soundSystemSlug)->first();
        $sound = Sound::where('slug', $slug)->first();
        if (!$soundSystem || !$sound) {
            abort(404);
        }
        $teamCreative = TeamLanoer::get();
        return view('front.pages.home.entertainment.sound.show', compact('soundSystem', 'sound', 'teamCreative'));
    }
    public function showEntertainmentLive($liveSlug, $liveSubSlug)
    {
        $live = Live::where('slug', $liveSlug)->first();
        $liveMusic = LiveMusic::where('slug', $liveSubSlug)->first();

        if (!$live || !$liveMusic) {
            abort(404);
        }

        $teamCreative = TeamLanoer::get();

        return view('front.pages.home.entertainment.live.show', compact('live', 'liveMusic', 'teamCreative'));
    }


    public function showEntertainmentCeremony($slug)
    {
        $ceremony = Ceremonial::where('slug', $slug)->first();
        $ceremonySub = CeremonialEvent::where('slug', $ceremony->slug)->first();

        if (!$ceremonySub || !$ceremony) {
            abort(404);
        }
        $teamCreative = TeamLanoer::get();
        return view('front.pages.home.entertainment.ceremony.show', compact('ceremony', 'ceremonySub', 'teamCreative'));
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
        $teamCreative = TeamLanoer::get();
        return view('front.pages.home.catering.show', compact('catering', 'teamCreative'));
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
}
