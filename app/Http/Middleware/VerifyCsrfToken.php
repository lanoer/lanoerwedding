<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        '/decoration/upload-image',
        '/aboutBackend/upload-image',
        '/wedding/sub/upload-image',
        '/event/sub/upload-image',
        '/entertainment/sound/soundSystem/upload-image',
        '/entertainment/live/livemusic/upload-image',
        '/entertainment/ceremonial/ceremonialevent/upload-image',
        '/aboutBackend/upload-image'
    ];
}
