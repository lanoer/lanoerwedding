<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use CyrildeWit\EloquentViewable\Contracts\Viewable;

class Weddings extends Model implements Viewable
{
    use HasFactory, SoftDeletes, InteractsWithViews;

    protected $guarded = [];

    public function weddingMakeups()
    {
        return $this->belongsTo(WeddingMakeups::class, 'wedding_makeups_id', 'id');
    }
}
