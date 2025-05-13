<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Video extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];

    protected $fillable = [
        'video_name',
        'video_url'
    ];

    // Tambahkan ini untuk debugging
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($video) {
            Log::info('Deleting video: ' . $video->id);
        });
    }
}
