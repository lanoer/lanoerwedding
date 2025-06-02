<?php

use App\Models\About;
use App\Models\CateringPackages;
use App\Models\CeremonialEvent;
use App\Models\Client;
use App\Models\Comment;
use App\Models\Contact;
use App\Models\ContactHome;
use App\Models\Decorations;
use App\Models\Event;
use App\Models\Foto;
use App\Models\InsertHeader;
use App\Models\LiveMusic;
use App\Models\Logo;
use App\Models\Post;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\Setting;
use App\Models\Slider;
use App\Models\Social;
use App\Models\SocialMedia;
use App\Models\SoundSystem;
use App\Models\SubCategory;
use App\Models\SubServiceCategory;
use App\Models\TeamLanoer;
use App\Models\Testimonial;
use App\Models\Weddings;
use Illuminate\Support\Carbon;

// chek if user online have internet connection

if (! function_exists('isOnline')) {
    function isOnline($site = 'https://www.youtube.com/')
    {
        if (@fopen($site, 'r')) {
            return true;
        } else {
            return false;
        }
    }
}

if (! function_exists('webCode')) {
    function webCode()
    {
        return InsertHeader::find(1);
    }
}
if (! function_exists('webInfo')) {
    function webInfo()
    {
        return Setting::find(1);
    }
}
if (!function_exists('webLogo')) {
    function webLogo()
    {
        return Logo::find(1);
    }
}
if (! function_exists('webSosmed')) {
    function webSosmed()
    {
        return Social::find(1);
    }
}

if (! function_exists('lates_home_3post')) {
    function lates_home_3post()
    {
        return Post::where('isActive', 1)
            ->with('author', 'subcategory')
            ->orderBy('created_at', 'desc')
            ->paginate(3);
    }
}

if (! function_exists('words')) {
    function words($value, $words = 15, $end = '...')
    {
        return Str::words(strip_tags($value), $words, $end);
    }
}
// date format
if (! function_exists('date_formatter')) {
    function date_formatter($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->isoFormat('LL');
    }
}

if (! function_exists('readDuration')) {
    function readDuration(...$text)
    {
        Str::macro('timeCounter', function ($text) {
            $totalWords = str_word_count(implode(' ', $text));
            $minutesToRead = round($totalWords / 200);

            return (int) max(1, $minutesToRead);
        });

        return Str::timeCounter($text);
    }
}
if (! function_exists('categories')) {
    function categories()
    {
        return SubCategory::whereHas('posts')
            ->with('posts', function ($q) {
                $q->where('isActive', '=', 1);
            })
            ->orderBy('subcategory_name', 'asc')
            ->get();
    }
}
// tags
if (! function_exists('all_tags')) {
    function all_tags($except = null, $limit = null)
    {
        $tags = Post::whereNotNull('post_tags')
            ->pluck('post_tags')
            ->toArray();

        $allTags = [];

        foreach ($tags as $tagList) {
            $splitTags = explode(',', $tagList);
            foreach ($splitTags as $tag) {
                $allTags[] = trim($tag);
            }
        }

        $uniqueTags = array_unique($allTags);

        if (! is_null($except)) {
            $uniqueTags = array_diff($uniqueTags, (array) $except);
        }

        if (! is_null($limit)) {
            $uniqueTags = array_slice($uniqueTags, 0, $limit);
        }

        return $uniqueTags;
    }
}
if (! function_exists('recommended_post')) {
    function recommended_post()
    {
        return Post::where('isActive', '=', 1)->with('author')
            ->with('subcategory')
            ->limit(4)
            ->inRandomOrder()
            ->get();
    }
}

if (! function_exists('single_latest_post')) {
    function single_latest_post()
    {
        return Post::where('isActive', '=', 1)->with('author')
            ->with('subcategory')
            ->limit(1)
            ->orderBy('created_at', 'desc')
            ->first();
    }
}

if (! function_exists('notifications')) {
    function notifications()
    {
        return Contact::where('isActive', false)->get();
    }
}
if (! function_exists('webAbout')) {
    function webAbout()
    {
        return About::find(1);
    }
}
if (! function_exists('galery')) {
    function galery()
    {
        return Foto::latest()->take(6)->get();
    }
}
if (! function_exists('ContactSpecifically')) {
    function ContactSpecifically()
    {
        return ContactHome::find(1);
    }
}
if (! function_exists('categoriesProducts')) {
    function categoriesProducts()
    {
        return ServiceCategory::whereHas('subservices')
            ->orderBy('service_name', 'asc')
            ->get();
    }
}



if (! function_exists('random_services')) {
    function random_services($limit = 3)
    {
        $services = Service::where('isActive', 1)->inRandomOrder()->take($limit)->get();

        return $services;
    }
}

if (! function_exists('recommended_post')) {
    function recommended_post()
    {
        return Post::where('isActive', '=', 1)->with('author')
            ->with('subcategory')
            ->limit(4)
            ->inRandomOrder()
            ->get();
    }
}

if (! function_exists('random_post')) {
    function random_post($currentPostId = null, $limit = 4)
    {
        $query = Post::where('isActive', 1)
            ->with('author', 'subcategory')
            ->inRandomOrder();

        if ($currentPostId) {
            $query->where('id', '!=', $currentPostId);
        }

        return $query->limit($limit)->get();
    }
}

if (! function_exists('limit_words')) {
    function limit_words($string, $word_limit)
    {
        $words = explode(' ', $string);
        if (count($words) > $word_limit) {
            return implode(' ', array_slice($words, 0, $word_limit)) . '...';
        }
        return $string;
    }
}
if (! function_exists('approved_comment')) {
    function approved_comment()
    {
        return Comment::where('approved', 0)->get();
    }
}

if (! function_exists('recycle_bin')) {
    function recycle_bin()
    {
        $events = Event::onlyTrashed()->get();
        $weddings = Weddings::onlyTrashed()->get();
        $decorations = Decorations::onlyTrashed()->get();
        $soundSystems = SoundSystem::onlyTrashed()->get();
        $liveMusics = LiveMusic::onlyTrashed()->get();
        $ceremonialEvents = CeremonialEvent::onlyTrashed()->get();
        $fotos = Foto::onlyTrashed()->get();
        $caterings = CateringPackages::onlyTrashed()->get();
        $teamLanoers = TeamLanoer::onlyTrashed()->get();
        $sliders = Slider::onlyTrashed()->get();
        $testimonials = Testimonial::onlyTrashed()->get();
        return $events->concat($weddings)->concat($decorations)->concat($soundSystems)->concat($liveMusics)->concat($ceremonialEvents)->concat($fotos)->concat($caterings)->concat($teamLanoers)->concat($sliders)->concat($testimonials);
    }
}

if (! function_exists('unread_inbox')) {
    function unread_inbox()
    {
        return Contact::where('isActive', false)->count();
    }
}
if (! function_exists('slider')) {
    function slider()
    {
        return Slider::get();
    }
}
if (! function_exists('testimonials')) {
    function testimonials()
    {
        return Testimonial::get();
    }
}

if (! function_exists('clients')) {
    function clients()
    {
        return Client::get();
    }


    if (! function_exists('slider')) {
        function slider()
        {
            return Slider::get();
        }
    }
    if (! function_exists('teamCreative')) {
        function teamCreative()
        {
            return TeamLanoer::get();
        }
    }
}
