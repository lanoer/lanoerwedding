<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use CyrildeWit\EloquentViewable\Contracts\Viewable;

class Foto extends Model implements Viewable
{
    use HasFactory, SoftDeletes, InteractsWithViews;

    protected $guarded = [];
    public $timestamps = true;
    public function Album()
    {
        return $this->belongsTo(Album::class, 'album_id');
    }

    public function scopeSearch($query, $value)
    {
        $query->where('title', 'LIKE', "%$value%");
    }
}
