<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ceremonial extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function ceremonialEvents()
    {
        return $this->hasMany(CeremonialEvent::class);
    }
}
