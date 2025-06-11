<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PremiumCateringImage extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $protected = ['premium_caterings_id', 'image'];
}
