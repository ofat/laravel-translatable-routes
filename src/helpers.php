<?php

declare(strict_types=1);

use Illuminate\Routing\Exceptions\UrlGenerationException;

if (! function_exists('routeInLocale')) {
    /**
     * Generate the URL to a named route in given locale
     *
     * @throws UrlGenerationException
     */
    function routeInLocale(string $locale, array|string $name, mixed $parameters = [], bool $absolute = true): string
    {
        return app('url')->routeInLocale($locale, $name, $parameters, $absolute);
    }
}

if (! function_exists('urlWithLocale')) {
    /**
     * Generate an absolute URL to the given path with locale at the start
     */
    function urlWithLocale(string $path, mixed $extra = [], ?string $locale = null, ?bool $secure = null): string
    {
        return app('url')->withLocale($path, $extra, $locale, $secure);
    }
}
