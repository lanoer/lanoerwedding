<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class WeddingMakeups extends Model
{
    use HasFactory, Sluggable;

    protected $guarded = [];

    public function weddings()
    {
        return $this->hasMany(Weddings::class);
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
