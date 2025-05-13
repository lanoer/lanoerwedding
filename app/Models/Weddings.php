<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;

class Weddings extends Model
{
    use HasFactory, SoftDeletes, Sluggable;

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
