<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;

class Album extends Model implements Viewable
{
    use HasFactory, Sluggable, InteractsWithViews;
    protected $fillable = ['album_name', 'slug', 'ordering', 'is_active', 'image'];


    public function Foto()
    {
        return $this->hasMany(Foto::class, 'album_id', 'id');
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => ['album_name']
            ]
        ];
    }
}
