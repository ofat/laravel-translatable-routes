<?php

declare(strict_types=1);

namespace Ofat\LaravelTranslatableRoutes\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;

class LocaleDetect
{
    /**
     * Handle an incoming request.
     *
     * @throws AuthenticationException
     */
    public function handle(Request $request, Closure $next): mixed
    {
        if ($request->segment(1)) {
            app()->setLocale($request->segment(1));
        }

        return $next($request);
    }
}
