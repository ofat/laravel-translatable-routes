<?php

namespace Ofat\LaravelTranslatableRoutes\Routing;

use Illuminate\Http\Request;
use Illuminate\Routing\RouteCollectionInterface;
use Illuminate\Routing\UrlGenerator;
use Ofat\LaravelTranslatableRoutes\TranslationParser;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

class TranslatedUrlGenerator extends UrlGenerator
{
    /**
     * Create a new Translated URL Generator instance.
     *
     * @param TranslationParser $translationParser
     * @param \Illuminate\Routing\RouteCollectionInterface $routes
     * @param \Illuminate\Http\Request $request
     * @param null $assetRoot
     */
    public function __construct(
        protected TranslationParser $translationParser,
        RouteCollectionInterface $routes,
        Request $request,
        $assetRoot = null)
    {
        parent::__construct($routes, $request, $assetRoot);
    }

    /**
     * @inheritDoc
     */
    public function to($path, $extra = [], $secure = null)
    {
        $path = $this->translationParser->processUri($path);
        return parent::to($path, $extra, $secure);
    }

    /**
     * Generate an absolute URL to the given path with locale at the start
     *
     * @param  string  $path
     * @param  mixed  $extra
     * @param  string|null $locale
     * @param  bool|null  $secure
     * @return string
     */
    public function withLocale($path, $extra = [], $locale = null, $secure = null)
    {
        if(is_null($locale))
        {
            $locale = app()->getLocale();
        }
        $path = sprintf('%s/%s', $locale, $path);
        $path = $this->translationParser->processUri($path, $locale);
        return parent::to($path, $extra, $secure);
    }

    /**
     * @inheritDoc
     */
    public function route($name, $parameters = [], $absolute = true)
    {
        if (! is_null($route = $this->routes->getByName($name))) {
            return $this->toRoute($route, $parameters, $absolute);
        }

        return $this->routeInLocale(app()->getLocale(), $name, $parameters, $absolute);
    }

    /**
     * Generate the URL to a named route in given locale
     *
     * @param string $locale
     * @param string $name
     * @param mixed $parameters
     * @param bool $absolute
     * @return string
     * @throws \Illuminate\Routing\Exceptions\UrlGenerationException
     */
    public function routeInLocale($locale, $name, $parameters = [], $absolute = true)
    {
        $localedName = sprintf('%s.%s', $locale, $name);
        if (! is_null($route = $this->routes->getByName($localedName))) {
            return $this->toRoute($route, $parameters, $absolute);
        }

        throw new RouteNotFoundException("Route [{$name}] or [{$localedName}] not defined.");
    }
}
