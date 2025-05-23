<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;

class Event extends Model
{
    use HasFactory, SoftDeletes, Sluggable;
    protected $guarded = [];

    public function eventMakeup()
    {
        return $this->belongsTo(EventMakeups::class, 'event_makeups_id');
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
