<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Live extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];

    public function liveMusic()
    {
        return $this->hasMany(LiveMusic::class, 'lives_id', 'id');
    }
}
