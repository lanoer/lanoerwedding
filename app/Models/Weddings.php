<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use CyrildeWit\EloquentViewable\Contracts\Viewable;

class Weddings extends Model implements Viewable
{
    use HasFactory, SoftDeletes, Sluggable, InteractsWithViews;

    protected $guarded = [];

    public function weddingMakeups()
    {
        return $this->belongsTo(WeddingMakeups::class, 'wedding_makeups_id', 'id');
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
}
