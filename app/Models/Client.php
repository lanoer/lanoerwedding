<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function getImageAttribute($value)
    {
        if ($value) {
            return asset('storage/back/images/client/' . $value);
        }
        return asset('back/assets/images/default.png');
    }
}
