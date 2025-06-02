<?php

namespace App\Http\Livewire\Back;

use App\Models\CateringPackages;
use App\Models\Decorations;
use App\Models\Event;
use App\Models\EventMakeups;
use App\Models\LiveMusic;
use App\Models\SoundSystem;
use App\Models\User;
use App\Models\WeddingMakeups;
use App\Models\Weddings;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use CyrildeWit\EloquentViewable\Support\Period;
use App\Models\Foto;
use App\Models\CeremonialEvent;
use App\Models\About;
use App\Models\Album;
use App\Models\Post;

class Home extends Component
{
    public $totalUsers, $totalWeddings, $totalEvent, $totalCatering, $totalDecorations, $totalMusic, $totalSoundSystem, $totalArticles;
    public $topPages;
    public $topVisitedItems;

    public function mount()
    {
        $this->totalArticles = Cache::remember('totalArticles', 60, function () {
            return Post::count();
        });
        $this->totalUsers = Cache::remember('totalUsers', 60, fn() => User::count());
        $this->totalWeddings = Cache::remember('totalWeddings', 60, fn() => Weddings::count());
        $this->totalEvent = Cache::remember('totalEvent', 60, fn() => Event::count());
        $this->totalCatering = Cache::remember('totalCatering', 60, fn() => CateringPackages::count());
        $this->totalDecorations = Cache::remember('totalDecorations', 60, fn() => Decorations::count());
        $this->totalMusic = Cache::remember('totalMusic', 60, fn() => LiveMusic::count());
        $this->totalSoundSystem = Cache::remember('totalSoundSystem', 60, fn() => SoundSystem::count());

        $period = Period::pastWeeks(1);

        $items = collect();

        // Gabungkan semua entitas dari model yang ingin dimonitor
        $items = $items->concat(
            Weddings::with('weddingMakeups')->get()->map(function ($item) use ($period) {
                $makeupSlug = $item->weddingMakeups->slug ?? null;
                return [
                    'title' => $item->name ?? $item->title ?? '-',
                    'model' => 'Weddings',
                    'views' => views($item)->period($period)->count(),
                    'url' => ($makeupSlug && $item->slug) ? route('makeup.wedding.detail', [$makeupSlug, $item->slug]) : '#',
                ];
            })
        );
        $items = $items->concat(
            Event::with('eventMakeup')->get()->map(function ($item) use ($period) {
                $makeupSlug = $item->eventMakeup->slug ?? null;
                return [
                    'title' => $item->name ?? $item->title ?? '-',
                    'model' => 'Event',
                    'views' => views($item)->period($period)->count(),
                    'url' => ($makeupSlug && $item->slug) ? route('makeup.event.detail', [$makeupSlug, $item->slug]) : '#',
                ];
            })
        );
        $items = $items->concat(
            Album::with('Foto')->get()->map(function ($item) use ($period) {
                $albumSlug = $item->slug ?? null;
                return [
                    'title' => $item->album_name ?? '-',
                    'model' => 'Album',
                    'views' => views($item)->period($period)->count(),
                    'url' => $albumSlug ? route('documentation.main.show', $albumSlug) : '#',
                ];
            })
        );
        $items = $items->concat(
            CateringPackages::get()->map(function ($item) use ($period) {
                $cateringSlug = $item->slug ?? null;
                return [
                    'title' => $item->name ?? '-',
                    'model' => 'Catering',
                    'views' => views($item)->period($period)->count(),
                    'url' => $cateringSlug ? route('catering.detail.show', $cateringSlug) : '#',
                ];
            })
        );
        $items = $items->concat(
            Decorations::get()->map(function ($item) use ($period) {
                $decorationSlug = $item->slug ?? null;
                return [
                    'title' => $item->name ?? '-',
                    'model' => 'Decoration',
                    'views' => views($item)->period($period)->count(),
                    'url' => $decorationSlug ? route('decoration.detail.show', $decorationSlug) : '#',
                ];
            })
        );
        $items = $items->concat(
            CeremonialEvent::get()->map(function ($item) use ($period) {
                $ceremonialSlug = $item->ceremonial->slug ?? null;
                $ceremonySubSlug = $item->slug ?? null;
                return [
                    'title' => $item->name ?? '-',
                    'model' => 'Ceremonial Event',
                    'views' => views($item)->period($period)->count(),
                    'url' => $ceremonialSlug ? route('entertainment.ceremony.detail.show', [$ceremonialSlug, $ceremonySubSlug]) : '#',
                ];
            })
        );
        $items = $items->concat(
            LiveMusic::get()->map(function ($item) use ($period) {
                $liveSlug = $item->slug ?? null;
                return [
                    'title' => $item->name ?? '-',
                    'model' => 'Live Music',
                    'views' => views($item)->period($period)->count(),
                    'url' => $liveSlug ? route('entertainment.live.detail.show', [$liveSlug, $item->slug]) : '#',
                ];
            })
        );
        $items = $items->concat(
            SoundSystem::get()->map(function ($item) use ($period) {
                $soundSlug = $item->slug ?? null;
                return [
                    'title' => $item->name ?? '-',
                    'model' => 'Sound System',
                    'views' => views($item)->period($period)->count(),
                    'url' => $soundSlug ? route('entertainment.sound.detail.show', [$soundSlug, $item->slug]) : '#',
                ];
            })
        );

        // Urutkan dan ambil top 10
        $this->topVisitedItems = $items->sortByDesc('views')->take(5)->values();
    }

    public function render()
    {
        $posts = Cache::remember('mostVisitedPosts', 60, function () {
            return Post::with('author')->orderByViews()->limit(5)->get();
        });
        return view('livewire.back.home', [
            'posts' => $posts,
        ]);
    }
}
