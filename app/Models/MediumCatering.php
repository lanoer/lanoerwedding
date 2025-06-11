<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use CyrildeWit\EloquentViewable\Contracts\Viewable;

class MediumCatering extends Model implements Viewable
{
    use HasFactory, SoftDeletes, InteractsWithViews;
    protected $guarded = [];

    public function CateringPackages()
    {
        return $this->belongsTo(CateringPackages::class, 'catering_packages_id');
    }

    public function images()
    {
        return $this->hasMany(MediumCateringImage::class, 'medium_caterings_id');
    }
}
