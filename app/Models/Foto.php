<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Foto extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    public $timestamps = true;
    public function Album()
    {
        return $this->belongsTo(Album::class, 'album_id');
    }

    public function scopeSearch($query, $value)
    {
        $query->where('title', 'LIKE', "%$value%");
    }
}
