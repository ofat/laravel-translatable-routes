<?php

namespace Ofat\LaravelTranslatableRoutes\Routing;

use Illuminate\Http\Request;
use Illuminate\Routing\RouteCollectionInterface;
use Ofat\LaravelTranslatableRoutes\TranslationParser;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

class UrlGenerator extends \Illuminate\Routing\UrlGenerator
{
    public function __construct(protected
            TranslationParser $translationParser,
            RouteCollectionInterface $routes,
            Request $request,
            $assetRoot = null)
    {
        parent::__construct($routes, $request, $assetRoot);
    }

    /**
     * Get the URL to a named route.
     *
     * @param  string  $name
     * @param  mixed  $parameters
     * @param  bool  $absolute
     * @return string
     *
     * @throws \Symfony\Component\Routing\Exception\RouteNotFoundException
     */
    public function route($name, $parameters = [], $absolute = true)
    {
        if (! is_null($route = $this->routes->getByName($name))) {
            return $this->toRoute($route, $parameters, $absolute);
        }

        $name = app()->getLocale().'.'.$name;
        if (! is_null($route = $this->routes->getByName($name))) {
            return $this->toRoute($route, $parameters, $absolute);
        }

        throw new RouteNotFoundException("Route [{$name}] not defined.");
    }
}
