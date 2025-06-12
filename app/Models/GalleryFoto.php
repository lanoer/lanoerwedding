<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;

class GalleryFoto extends Model implements Viewable
{
    use HasFactory, Sluggable, InteractsWithViews;
    protected $guarded = [];


    public function FotoGallery()
    {
        return $this->hasMany(FotoGallery::class, 'gallery_fotos_id', 'id');
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => ['gallery_name']
            ]
        ];
    }
}
