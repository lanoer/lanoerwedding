<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use CyrildeWit\EloquentViewable\Contracts\Viewable;

class WeddingMakeups extends Model implements Viewable
{
    use HasFactory,  InteractsWithViews;

    protected $guarded = [];

    public function weddings()
    {
        return $this->hasMany(Weddings::class);
    }
}
