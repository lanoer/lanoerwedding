<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use CyrildeWit\EloquentViewable\Contracts\Viewable;

class CeremonialEvent extends Model implements Viewable
{
    use HasFactory, SoftDeletes, Sluggable, InteractsWithViews;
    protected $guarded = ['id'];

    public function ceremonial()
    {
        return $this->belongsTo(Ceremonial::class, 'ceremonial_id');
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
