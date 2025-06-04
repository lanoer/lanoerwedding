<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DecorationImage extends Model
{
    use HasFactory;
    protected $fillable = ['decoration_id', 'image'];
}
