<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use Cviebrock\EloquentSluggable\Sluggable;
use CyrildeWit\EloquentViewable\Contracts\Viewable;

class CateringPackages extends Model implements Viewable
{
    use HasFactory, SoftDeletes, Sluggable, InteractsWithViews;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function mediumCaterings()
    {
        return $this->hasMany(MediumCatering::class, 'catering_packages_id');
    }
    public function premiumCaterings()
    {
        return $this->hasMany(PremiumCatering::class, 'catering_packages_id');
    }
}
