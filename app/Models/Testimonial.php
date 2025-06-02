<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use CyrildeWit\EloquentViewable\Contracts\Viewable;

class Testimonial extends Model
{
    use HasFactory, SoftDeletes, InteractsWithViews;

    protected $guarded = ['id'];

    public function getImageAttribute($value)
    {
        if ($value) {
            return asset('storage/back/images/testimoni/' . $value);
        }
        return asset('back/assets/images/default.png');
    }
}
