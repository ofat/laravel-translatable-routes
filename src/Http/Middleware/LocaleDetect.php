<?php

namespace Ofat\LaravelTranslatableRoutes\Http\Middleware;

class LocaleDetect
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function handle($request, \Closure $next)
    {
        if ($request->segment(1)) {
            app()->setLocale( $request->segment(1) );
        }

        return $next($request);
    }
}
