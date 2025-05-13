<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;
class SoundSystem extends Model
{
    use HasFactory, SoftDeletes, Sluggable;
    protected $guarded = ['id'];

    public function sounds()
    {
        return $this->belongsTo(Sound::class, 'sounds_id', 'id');
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