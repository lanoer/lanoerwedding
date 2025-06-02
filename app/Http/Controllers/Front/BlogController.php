<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Logo;
use App\Models\Post;
use App\Models\SubCategory;
use Illuminate\Support\Str;
use Spatie\SchemaOrg\Schema;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\JsonLdMulti;

class BlogController extends Controller
{
    public function searchBlog(Request $request)
    {

        $query = $request->query('query');
        if ($query && strlen($query) >= 1) {
            $searchValue = preg_split('/\s+/', $query, -1, PREG_SPLIT_NO_EMPTY);
            $posts = Post::query();
            $posts->where(function ($q) use ($searchValue) {
                foreach ($searchValue as $value) {
                    $q->orWhere('post_title', 'LIKE', "%{$value}%");
                    $q->orWhere('post_tags', 'LIKE', "%{$value}%");
                    $q->orWhere('meta_keywords', 'LIKE', "%{$value}%");
                }
            });

            $posts = $posts->where('isActive', 1)
                ->with('subcategory')
                ->with('author')
                ->orderBy('created_at', 'desc')
                ->paginate(4);

            // Set SEO Meta Tags
            SEOMeta::setTitle('Search results for: ' . $query);
            SEOMeta::setDescription('Search results for: ' . $query);
            SEOMeta::setCanonical(url('/search?query=' . urlencode($query)));

            OpenGraph::setTitle('Search results for: ' . $query)
                ->setDescription('Search results for: ' . $query)
                ->setUrl(url('/search?query=' . urlencode($query)))
                ->setType('website');

            JsonLdMulti::setTitle('Search results for: ' . $query);
            JsonLdMulti::setDescription('Search results for: ' . $query);
            JsonLdMulti::setType('WebPage');

            // Buat objek Schema.org untuk halaman pencarian
            $searchSchema = Schema::webPage()
                ->name('Search results for: ' . $query)
                ->description('Search results for: ' . $query)
                ->url(url('/search?query=' . urlencode($query)));

            // Jika tidak ada hasil, cari saran
            $suggestions = [];
            if ($posts->isEmpty()) {
                $allKeywords = Post::pluck('meta_keywords')->toArray();
                $allKeywords = array_unique(array_merge(...array_map(function ($keywords) {
                    return explode(',', $keywords);
                }, $allKeywords)));

                foreach ($allKeywords as $keyword) {
                    if (levenshtein($query, $keyword) <= 3) {
                        $suggestions[] = $keyword;
                    }
                }
            }

            $data = [
                'pageTitle' => 'Search results for: ' . $query,
                'posts' => $posts,
                'searchSchema' => $searchSchema,
                'query' => $query,
                'suggestions' => $suggestions,
            ];

            return view('front.pages.blog.search', $data);
        } else {
            return abort(404);
        }
    }

    public function categoryPost(Request $request, $slug)
    {
        if (!$slug) {
            return abort(404);
        } else {
            $subcategory = SubCategory::where('slug', $slug)->first();
            if (!$subcategory) {
                return abort(404);
            } else {
                $posts = Post::where('isActive', 1)
                    ->where('category_id', $subcategory->id)
                    ->orderBy('created_at', 'desc')
                    ->paginate(8);

                // Mengambil related posts
                $related_post = Post::where('isActive', 1)
                    ->where('category_id', $subcategory->id)
                    ->whereNotIn('id', $posts->pluck('id'))
                    ->inRandomOrder()
                    ->take(3)
                    ->get();

                // Set SEO Meta Tags
                SEOMeta::setTitle($subcategory->subcategory_name);
                SEOMeta::setDescription('Explore posts in the ' . $subcategory->subcategory_name . ' category');
                SEOMeta::setCanonical(url('/blog/category/' . $slug));

                OpenGraph::setTitle($subcategory->subcategory_name)
                    ->setDescription('Explore posts in the ' . $subcategory->subcategory_name . ' category')
                    ->setUrl(url('/blog/category/' . $slug))
                    ->setType('website');

                JsonLdMulti::setTitle($subcategory->subcategory_name);
                JsonLdMulti::setDescription('Explore posts in the ' . $subcategory->subcategory_name . ' category');
                JsonLdMulti::setType('WebPage');
                // Buat objek Schema.org untuk halaman kategori
                $categorySchema = Schema::webPage()
                    ->name($subcategory->subcategory_name)
                    ->description('Explore posts in the ' . $subcategory->subcategory_name . ' category')
                    ->url(url('/blog/category/' . $slug));
                $data = [
                    'pageTitle' => $subcategory->subcategory_name,
                    'category' => $subcategory,
                    'posts' => $posts,
                    'related_post' => $related_post,
                    'slug' => $slug,
                    'categorySchema' => $categorySchema,
                ];

                return view('front.pages.blog.category', $data);
            }
        }
    }

    public function readPost($slug)
    {
        if (!$slug) {
            abort(404);
        } else {
            $posts = Post::where('slug', $slug)
                ->with('subcategory')
                ->with('author')
                ->first();

            if (!$posts) {
                return abort(404);
            }

            $posts_tags = explode(',', $posts->post_tags);
            $related_post = Post::where('id', '!=', $posts->id)
                ->where(function ($query) use ($posts_tags) {
                    foreach ($posts_tags as $item) {
                        $query->orWhere('post_tags', 'LIKE', "%$item%");
                    }
                })
                ->inRandomOrder()
                ->take(3)
                ->get();

            $approved_comments = $posts->comments()->where('approved', true)->get();
            list($processedContent, $headings) = $this->addHeadingIdsAndInsertRelatedPosts($posts->post_content, $related_post);
            $posts->post_content = $processedContent;
            // schema.org
            $logo = Logo::first();
            $logoUrl = $logo ? asset('back/images/logo/' . $logo->logo_utama) : '';
            $featuredImage = $posts->featured_image ? asset('/storage/back/images/post_images/' . $posts->featured_image) : '';
            $articleSchema = Schema::article()
                ->headline($posts->post_title)
                ->author($posts->author->name)
                ->datePublished($posts->created_at->toW3CString())
                ->dateModified($posts->updated_at->toW3CString())
                ->mainEntityOfPage(Schema::webPage()->identifier(url()->current()))
                ->image($featuredImage)
                ->publisher(Schema::organization()
                    ->name('Lanoer Wedding & Event Organizer')
                    ->logo($logoUrl));
            $data = [
                'pageTitle' => Str::ucfirst($posts->post_title),
                'posts' => $posts,
                'related_post' => $related_post,
                'approved_comments' => $approved_comments,
                'headings' => $headings,
                'articleSchema' => $articleSchema,
            ];

            views($posts)->record();
            SEOMeta::setTitle($posts->post_title);
            SEOMeta::setCanonical(url()->current());
            SEOMeta::setDescription($posts->meta_desc);
            SEOMeta::addMeta('article:published_time', $posts->created_at->toW3CString(), 'property');
            SEOMeta::addMeta('article:section', $posts->subcategory->subcategory_name, 'property');
            SEOMeta::addKeyword($posts->meta_keywords);

            OpenGraph::setDescription($posts->meta_desc);
            OpenGraph::setTitle($posts->post_title);
            OpenGraph::setUrl(url()->current());
            OpenGraph::addProperty('type', 'article');
            OpenGraph::addProperty('locale', 'id-ID');
            OpenGraph::addProperty('locale:alternate', ['en-us']);

            JsonLdMulti::setTitle($posts->post_title);
            JsonLdMulti::setDescription($posts->meta_desc);
            JsonLdMulti::setType('Article');
            JsonLdMulti::addImage($posts->featured_image);
            if (!JsonLdMulti::isEmpty()) {
                JsonLdMulti::newJsonLd();
                JsonLdMulti::setType('WebPage');
                JsonLdMulti::setTitle('Page Article - ' . $posts->post_title);
            }
            OpenGraph::setTitle($posts->post_title)
                ->setDescription($posts->meta_desc)
                ->setType('article')
                ->setArticle([
                    'created_at' => 'datetime',
                    'updated_at' => 'datetime',
                    'expiration_time' => 'datetime',
                    'author' => $posts->author->name,
                    'section' => $posts->subcategory->subcategory_name,
                    'tag' => $posts->post_tags,
                ]);

            return view('front.pages.home.blog.single-post', $data);
        }
    }
    private function addHeadingIdsAndInsertRelatedPosts($content, $relatedPosts)
    {
        libxml_use_internal_errors(true);

        $dom = new \DOMDocument();
        @$dom->loadHTML(mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8'));


        $xpath = new \DOMXPath($dom);
        $headings = $xpath->query('//h2 | //h3 | //h4 | //h5');
        $headingArray = [];
        $relatedPostsHtml = $this->generateRelatedPostsHtml($relatedPosts);

        foreach ($headings as $index => $heading) {
            $id = 'heading-' . ($index + 1);
            $heading->setAttribute('id', $id);
            $headingArray[] = $heading->textContent;

            if ($index == 0) {
                $relatedPostsFragment = $dom->createDocumentFragment();
                $relatedPostsFragment->appendXML($relatedPostsHtml);
                $heading->parentNode->insertBefore($relatedPostsFragment, $heading->nextSibling);
            }
        }


        return [$dom->saveHTML(), $headingArray];
    }

    private function generateRelatedPostsHtml($relatedPosts)
    {
        $html = '<div class="related-posts"><span style="font-size: 16px; font-weight: bold;">Baca juga : </span><ul>';
        foreach ($relatedPosts as $post) {
            $html .= '<li><a href="' . route('blog.detail', $post->slug) . '">' . $post->post_title . '</a></li>';
        }
        $html .= '</ul></div>';
        return $html;
    }

    public function tagPost(Request $request, $tag)
    {
        $posts = Post::where('isActive', '=', 1)
            ->where('post_tags', 'LIKE', '%' . $tag . '%')
            ->with('subcategory', 'author')
            ->orderBy('created_at', 'desc')
            ->paginate(4);

        if ($posts->isEmpty()) {
            return abort(404);
        }

        // Mengambil related posts
        $related_post = Post::where('isActive', '=', 1)
            ->where('post_tags', 'LIKE', '%' . $tag . '%')
            ->whereNotIn('id', $posts->pluck('id')->toArray())
            ->inRandomOrder()
            ->take(3)
            ->get();

        // Set SEO Meta Tags
        SEOMeta::setTitle('Tag: ' . $tag);
        SEOMeta::setDescription('Explore posts tagged with ' . $tag);
        SEOMeta::setCanonical(url('/blog/tag/' . $tag));

        OpenGraph::setTitle('Tag: ' . $tag)
            ->setDescription('Explore posts tagged with ' . $tag)
            ->setUrl(url('/blog/tag/' . $tag))
            ->setType('website');

        JsonLdMulti::setTitle('Tag: ' . $tag);
        JsonLdMulti::setDescription('Explore posts tagged with ' . $tag);
        JsonLdMulti::setType('WebPage');
        // Buat objek Schema.org untuk halaman tag
        $tagSchema = Schema::webPage()
            ->name('Tag: ' . $tag)
            ->description('Explore posts tagged with ' . $tag)
            ->url(url('/blog/tag/' . $tag));
        $data = [
            'title' => $tag,
            'posts' => $posts,
            'related_post' => $related_post,
            'currentTag' => $tag,
            'tagSchema' => $tagSchema,
        ];

        return view('front.pages.blog.tag-post', $data);
    }
}
