<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialToken extends Model
{
    use HasFactory;
    protected $fillable = ['provider', 'access_token', 'expires_at'];
    protected $dates = ['expires_at'];
}
