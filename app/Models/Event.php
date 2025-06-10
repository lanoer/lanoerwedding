<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use CyrildeWit\EloquentViewable\Contracts\Viewable;

class Event extends Model implements Viewable
{
    use HasFactory, SoftDeletes, InteractsWithViews;
    protected $guarded = [];

    public function eventMakeup()
    {
        return $this->belongsTo(EventMakeups::class, 'event_makeups_id');
    }
}
