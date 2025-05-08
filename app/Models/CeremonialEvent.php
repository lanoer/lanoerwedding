<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CeremonialEvent extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];

    public function ceremonial()
    {
        return $this->belongsTo(Ceremonial::class, 'ceremonial_id', 'id');
    }
}
