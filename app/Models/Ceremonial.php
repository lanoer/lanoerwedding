<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Ceremonial extends Model
{
    use HasFactory, Sluggable;
    protected $guarded = ['id'];

    public function ceremonialEvents()
    {
        return $this->hasMany(CeremonialEvent::class);
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
