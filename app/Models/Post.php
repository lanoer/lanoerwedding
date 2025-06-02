<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Cviebrock\EloquentSluggable\Sluggable;
use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use Spatie\Feed\FeedItem;
use App\Models\SubCategory;
use App\Models\User;
use App\Models\Comment;

class Post extends Model implements HasMedia, Viewable
{
    use HasFactory;
    use InteractsWithMedia;
    use InteractsWithViews;
    use Sluggable;

    protected $guarded = [];

    protected $removeViewsOnDelete = true;

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('resized')
            ->width(500)
            ->height(150)
            ->keepOriginalImageFormat()
            ->performOnCollections('post_content')
            ->nonQueued();
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'post_title',
            ],
        ];
    }

    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        $query->where(function ($query) use ($term) {
            $query->where('post_title', 'like', $term);
        });
    }

    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class, 'category_id', 'id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function toFeedItem(): FeedItem
    {


        return FeedItem::create([
            'id' => $this->id,
            'title' => $this->post_title,
            'summary' => $this->meta_desc,
            'updated' => $this->updated_at,
            'link' => route('blog.detail', $this->slug),
            'authorName' => $this->author->name,
        ]);
    }

    public static function getFeedItems()
    {
        return Post::where('isActive', 1)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function (Post $post) {
                return $post->toFeedItem();
            });
    }
}
