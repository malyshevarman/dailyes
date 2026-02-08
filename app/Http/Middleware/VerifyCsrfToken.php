<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;
use Closure;

class VerifyCsrfToken extends Middleware
{
    public function handle($request, Closure $next)
    {
       $response = $next($request);
       $response->headers->set('Access-Control-Allow-Origin' , '*');
       $response->headers->set('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, PUT, DELETE');
       $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Accept, Authorization, X-Requested-With, Application');

       return $response;
    }

    /**
     * Indicates whether the XSRF-TOKEN cookie should be set on the response.
     *
     * @var bool
     */
    protected $addHttpCookie = true;

    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [



        'api/backend/download',
        'api/backend/download/store-multiple',
        'api/backend/video/store-multiple',
        'api/backend/gallery-item/store-multiple',
        'api/cabinet/download',
        'api/cabinet/gallery-item/store-multiple',
    ];
}