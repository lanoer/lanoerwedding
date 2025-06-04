<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class SitemapController extends Controller
{
    public function index()
    {
        $urls = [
            ['loc' => URL::to('/'), 'priority' => '1.00', 'lastmod' => now()->toAtomString(), 'changefreq' => 'daily'],
            ['loc' => URL::to('/about'), 'priority' => '1.00', 'lastmod' => now()->toAtomString(), 'changefreq' => 'monthly'],

            ['loc' => URL::to('/contact'), 'priority' => '0.85', 'lastmod' => now()->toAtomString(), 'changefreq' => 'monthly'],
            ['loc' => URL::to('/blog'), 'priority' => '0.80', 'lastmod' => now()->toAtomString(), 'changefreq' => 'weekly'],
            ['loc' => URL::to('/services'), 'priority' => '0.80', 'lastmod' => now()->toAtomString(), 'changefreq' => 'weekly'],
            ['loc' => URL::to('/documentation'), 'priority' => '0.80', 'lastmod' => now()->toAtomString(), 'changefreq' => 'monthly'],

            ['loc' => URL::to('/makeups'), 'priority' => '0.70', 'lastmod' => now()->toAtomString(), 'changefreq' => 'monthly'],

            ['loc' => URL::to('/entertainment/list'), 'priority' => '0.75', 'lastmod' => now()->toAtomString(), 'changefreq' => 'weekly'],
            ['loc' => URL::to('/entertainment/detail/sound/{slug}/{soundSystemSlug}'), 'priority' => '0.60', 'lastmod' => now()->toAtomString(), 'changefreq' => 'monthly'],
            ['loc' => URL::to('/entertainment/detail/live/{liveSlug}/{liveSubSlug}'), 'priority' => '0.60', 'lastmod' => now()->toAtomString(), 'changefreq' => 'monthly'],
            ['loc' => URL::to('/entertainment/detail/ceremony/{ceremonySlug}/{ceremonySubSlug}'), 'priority' => '0.60', 'lastmod' => now()->toAtomString(), 'changefreq' => 'monthly'],

            ['loc' => URL::to('/catering/list'), 'priority' => '0.75', 'lastmod' => now()->toAtomString(), 'changefreq' => 'weekly'],
            ['loc' => URL::to('/catering/{slug}'), 'priority' => '0.60', 'lastmod' => now()->toAtomString(), 'changefreq' => 'monthly'],
        ];

        $articles = Post::all();
        foreach ($articles as $article) {
            $urls[] = [
                'loc' => URL::to("/blog/{$article->slug}"),
                'priority' => '0.80',
                'lastmod' => $article->updated_at->toAtomString(),
                'changefreq' => 'weekly',
            ];
        }

        $categories = SubCategory::all();
        foreach ($categories as $category) {
            $urls[] = [
                'loc' => URL::to("/blog/category/{$category->slug}"),
                'priority' => '0.80',
                'lastmod' => $category->updated_at->toAtomString(),
                'changefreq' => 'weekly',
            ];
        }

        return response()->view('sitemap', compact('urls'))->header('Content-Type', 'text/xml');
    }
}
