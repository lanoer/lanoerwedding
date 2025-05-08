<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sound extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];

    public function soundSystems()
    {
        return $this->hasMany(SoundSystem::class, 'sounds_id', 'id');
    }
}
