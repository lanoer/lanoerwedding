<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Album extends Model
{
    use HasFactory, Sluggable;
    protected $guarded = ['id'];

    public function Foto()
    {
        return $this->hasMany(Foto::class, 'album_id', 'id');
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => ['album_name']
            ]
        ];
    }
}
