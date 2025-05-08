<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LiveMusic extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];

    public function live()
    {
        return $this->belongsTo(Live::class, 'lives_id', 'id');
    }
}
