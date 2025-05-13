<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;

class LiveMusic extends Model
{
    use HasFactory, SoftDeletes, Sluggable;
    protected $guarded = ['id'];

    public function live()
    {
        return $this->belongsTo(Live::class, 'lives_id', 'id');
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
