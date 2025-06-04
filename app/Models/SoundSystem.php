<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use CyrildeWit\EloquentViewable\Contracts\Viewable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class SoundSystem extends Model implements Viewable, HasMedia
{
    use HasFactory, SoftDeletes, Sluggable, InteractsWithViews, InteractsWithMedia;
    protected $guarded = ['id'];

    public function sounds()
    {
        return $this->belongsTo(Sound::class, 'sounds_id', 'id');
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('resized')
            ->width(500)
            ->height(150)
            ->keepOriginalImageFormat()
            ->performOnCollections('sound_content')
            ->nonQueued();
    }
}
