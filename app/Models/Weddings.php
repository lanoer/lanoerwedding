<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Weddings extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function weddingMakeups()
    {
        return $this->belongsTo(WeddingMakeups::class);
    }
}
