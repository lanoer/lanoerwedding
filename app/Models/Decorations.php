<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use CyrildeWit\EloquentViewable\Contracts\Viewable;

class Decorations extends Model implements Viewable
{
    use HasFactory, SoftDeletes, InteractsWithViews;
    protected $guarded = ['id'];




    public function images()
    {
        return $this->hasMany(DecorationImage::class, 'decoration_id');
    }
}
