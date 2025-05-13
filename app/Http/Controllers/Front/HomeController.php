<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\Ceremonial;
use App\Models\CeremonialEvent;
use App\Models\Decorations;
use App\Models\Event;
use App\Models\EventMakeups;
use App\Models\Live;
use App\Models\LiveMusic;
use App\Models\Sound;
use App\Models\SoundSystem;
use App\Models\TeamLanoer;
use App\Models\Wedding;
use App\Models\WeddingMakeups;
use App\Models\Weddings;
use Illuminate\Http\Request;

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
        $ceremonySound = CeremonialEvent::get();
        $teamCreative = TeamLanoer::get();


        return view('front.pages.home.entertainment.list', compact('sound', 'soundSystem', 'live', 'liveMusic', 'ceremony', 'ceremonySound', 'teamCreative'));
    }
}
