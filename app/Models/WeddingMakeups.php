<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeddingMakeups extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function weddings()
    {
        return $this->hasMany(Weddings::class);
    }
}
