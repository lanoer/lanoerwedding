<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logo extends Model
{
    use HasFactory;

    protected $fillable = [
        'logo_utama',
        'logo_email',
        'logo_favicon',
        'logo_front',
        'logo_front2',
    ];

    public function getLogoUtamaAttribute($value)
    {
        if ($value) {
            return asset('/back/images/logo/' . $value);
        } else {
            return asset('/back/images/logo/logo.png');
        }
    }

    public function getLogoEmailAttribute($value)
    {
        if ($value) {
            return asset('/back/images/logo/' . $value);
        } else {
            return asset('/back/images/logo/logo-email.png');
        }
    }

    public function getLogoFaviconAttribute($value)
    {
        if ($value) {
            return asset('/back/images/logo/' . $value);
        } else {
            return asset('/back/images/logo/favicon.ico');
        }
    }

    public function getLogoFrontAttribute($value)
    {
        if ($value) {
            return asset('/back/images/logo/' . $value);
        } else {
            return asset('/back/images/logo/logo-front.png');
        }
    }

    public function getLogoFront2Attribute($value)
    {
        if ($value) {
            return asset('/back/images/logo/' . $value);
        } else {
            return asset('/back/images/logo/logo-front2.png');
        }
    }
}
