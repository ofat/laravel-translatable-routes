<?php

if (! function_exists('routeInLocale')) {
    /**
     * Generate the URL to a named route in given locale
     *
     * @param string $locale
     * @param array|string $name
     * @param mixed $parameters
     * @param bool $absolute
     * @return string
     * @throws \Illuminate\Routing\Exceptions\UrlGenerationException
     */
    function routeInLocale($locale, $name, $parameters = [], $absolute = true)
    {
        return app('url')->routeInLocale($locale, $name, $parameters, $absolute);
    }
}

if (! function_exists('urlWithLocale')) {
    /**
     * Generate an absolute URL to the given path with locale at the start
     *
     * @param  string  $path
     * @param  mixed  $extra
     * @param  string|null $locale
     * @param  bool|null  $secure
     * @return string
     */
    function urlWithLocale($path, $extra = [], $locale = null, $secure = null)
    {
        return app('url')->withLocale($path, $extra, $locale, $secure);
    }
}

