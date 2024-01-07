<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\URL;

class ForceHttps
{
    public function handle($request, Closure $next)
    {
        if (!$request->secure() && app()->environment() === 'production') {
            URL::forceScheme('https');
        }

        return $next($request);
    }
}
