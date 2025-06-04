<?php

namespace App\Http\Livewire\Back;

use App\Models\{
    CateringPackages,
    Decorations,
    Event,
    LiveMusic,
    SoundSystem,
    User,
    Weddings,
    CeremonialEvent,
    Album,
    Post
};
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use CyrildeWit\EloquentViewable\Support\Period;
use Spatie\Analytics\Facades\Analytics;
use Spatie\Analytics\Period as AnalyticsPeriod;

class Home extends Component
{
    public $totalUsers, $totalWeddings, $totalEvent, $totalCatering,
        $totalDecorations, $totalMusic, $totalSoundSystem, $totalArticles;

    public $dailyViews, $weeklyViews, $monthlyViews;
    public $topVisitedItems, $selectedPeriod = '7'; // Default selected period is 7 days

    public $topOperatingSystems = [], $topBrowsers = [], $countryViews = [];

    public function mount()
    {
        $this->fetchCounts();
        $this->fetchTopVisitedItems();
        $this->fetchAnalytics(); // Initial analytics fetch
    }

    private function fetchCounts()
    {
        $this->totalUsers = Cache::remember('totalUsers', 60, fn() => User::count());
        $this->totalWeddings = Cache::remember('totalWeddings', 60, fn() => Weddings::count());
        $this->totalEvent = Cache::remember('totalEvent', 60, fn() => Event::count());
        $this->totalCatering = Cache::remember('totalCatering', 60, fn() => CateringPackages::count());
        $this->totalDecorations = Cache::remember('totalDecorations', 60, fn() => Decorations::count());
        $this->totalMusic = Cache::remember('totalMusic', 60, fn() => LiveMusic::count());
        $this->totalSoundSystem = Cache::remember('totalSoundSystem', 60, fn() => SoundSystem::count());
        $this->totalArticles = Cache::remember('totalArticles', 60, fn() => Post::count());
    }

    private function fetchTopVisitedItems()
    {
        $period = Period::pastWeeks(1); // Default period to past 1 week

        $items = collect();

        // Collect items for various models
        $items = $items->concat(
            Weddings::with('weddingMakeups')->get()->map(function ($item) use ($period) {
                $makeupSlug = $item->weddingMakeups->slug ?? null;
                return [
                    'title' => $item->name ?? '-',
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
                    'title' => $item->name ?? '-',
                    'model' => 'Event',
                    'views' => views($item)->period($period)->count(),
                    'url' => ($makeupSlug && $item->slug) ? route('makeup.event.detail', [$makeupSlug, $item->slug]) : '#',
                ];
            })
        );

        $items = $items->concat(
            Album::get()->map(function ($item) use ($period) {
                return [
                    'title' => $item->album_name ?? '-',
                    'model' => 'Album',
                    'views' => views($item)->period($period)->count(),
                    'url' => $item->slug ? route('documentation.main.show', $item->slug) : '#',
                ];
            })
        );

        $items = $items->concat(
            CateringPackages::get()->map(fn($item) => [
                'title' => $item->name ?? '-',
                'model' => 'Catering',
                'views' => views($item)->period($period)->count(),
                'url' => $item->slug ? route('catering.detail.show', $item->slug) : '#',
            ])
        );

        $items = $items->concat(
            Decorations::get()->map(fn($item) => [
                'title' => $item->name ?? '-',
                'model' => 'Decoration',
                'views' => views($item)->period($period)->count(),
                'url' => $item->slug ? route('decoration.detail.show', $item->slug) : '#',
            ])
        );

        $items = $items->concat(
            CeremonialEvent::with('ceremonial')->get()->map(function ($item) use ($period) {
                return [
                    'title' => $item->name ?? '-',
                    'model' => 'Ceremonial Event',
                    'views' => views($item)->period($period)->count(),
                    'url' => ($item->ceremonial->slug && $item->slug) ? route('entertainment.ceremony.detail.show', [$item->ceremonial->slug, $item->slug]) : '#',
                ];
            })
        );

        $items = $items->concat(
            LiveMusic::get()->map(fn($item) => [
                'title' => $item->name ?? '-',
                'model' => 'Live Music',
                'views' => views($item)->period($period)->count(),
                'url' => $item->slug ? route('entertainment.live.detail.show', [$item->slug, $item->slug]) : '#',
            ])
        );

        $items = $items->concat(
            SoundSystem::get()->map(fn($item) => [
                'title' => $item->name ?? '-',
                'model' => 'Sound System',
                'views' => views($item)->period($period)->count(),
                'url' => $item->slug ? route('entertainment.sound.detail.show', [$item->slug, $item->slug]) : '#',
            ])
        );

        $this->topVisitedItems = $items->sortByDesc('views')->take(5)->values();
    }

    public function fetchAnalytics()
    {
        $period = AnalyticsPeriod::days((int) $this->selectedPeriod); // Adjust the period based on selectedPeriod

        $this->dailyViews = Cache::remember(
            'dailyViews',
            60,
            fn() =>
            Analytics::fetchVisitorsAndPageViews(AnalyticsPeriod::days(1))->sum('screenPageViews')
        );

        $this->weeklyViews = Cache::remember(
            'weeklyViews',
            60,
            fn() =>
            Analytics::fetchVisitorsAndPageViews(AnalyticsPeriod::days(7))->sum('screenPageViews')
        );

        $this->monthlyViews = Cache::remember(
            'monthlyViews',
            60,
            fn() =>
            Analytics::fetchVisitorsAndPageViews(AnalyticsPeriod::days(30))->sum('screenPageViews')
        );

        // Fetch other analytics data
        $this->topBrowsers = Analytics::fetchTopBrowsers($period, 5);
        $this->topOperatingSystems = Analytics::fetchTopOperatingSystems($period, 5);
        $this->countryViews = Analytics::fetchTopCountries($period, 5);
    }

    public function updatedSelectedPeriod()
    {
        // This method is triggered when the selectedPeriod changes
        $this->fetchAnalytics(); // Refetch analytics data with the updated selected period
        $this->fetchTopVisitedItems(); // Re-fetch top visited items based on the updated period
    }

    public function render()
    {
        $posts = Cache::remember(
            'mostVisitedPosts',
            60,
            fn() =>
            Post::with('author')->orderByViews()->limit(5)->get()
        );

        return view('livewire.back.home', [
            'posts' => $posts,
        ]);
    }
}
