<?php

namespace Ofat\LaravelTranslatableRoutes\Routing;

use Illuminate\Container\Container;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Routing\Events\Routing;
use Illuminate\Routing\Route;
use Illuminate\Routing\RouteCollection;
use Illuminate\Routing\Router;
use Ofat\LaravelTranslatableRoutes\Http\Middleware\LocaleDetect;
use Ofat\LaravelTranslatableRoutes\TranslationParser;

class TranslatedRouter extends Router
{
    public function __construct(
        protected TranslationParser $translationParser,
        RouteCollection $routes,
        Dispatcher $events,
        Container $container = null)
    {
        parent::__construct($events, $container);
        $this->routes = $routes;
    }

    public function addRoute($methods, $uri, $action)
    {
        $uri = $this->translationParser->processUri($uri);
        return $this->routes->add($this->createRoute($methods, $uri, $action));
    }

    public function languageGroup($routes)
    {
        foreach(config('translatable-routes.locales') as $locale)
        {
            app()->setLocale($locale);
            $this
                ->middleware(LocaleDetect::class)
                ->name($locale.'.')
                ->prefix($locale)
                ->group($routes);
        }
    }
}
