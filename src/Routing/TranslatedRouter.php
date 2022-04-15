<?php

namespace Ofat\LaravelTranslatableRoutes\Routing;

use Illuminate\Container\Container;
use Illuminate\Contracts\Events\Dispatcher;
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
        $translatedUri = $this->translationParser->processUri($uri);
        $route = $this->createRoute($methods, $translatedUri, $action)->defaultName($uri);
        return $this->routes->add($route);
    }

    public function newRoute($methods, $uri, $action)
    {
        return (new TranslatedRoute($methods, $uri, $action))
            ->setRouter($this)
            ->setContainer($this->container);
    }

    public function locale($locale)
    {
        $this->updateGroupStack(['locale' => $locale]);

        return $this;
    }

    public function localeGroup($routes)
    {
        foreach(config('translatable-routes.locales', []) as $locale)
        {
            app()->setLocale($locale);
            $this
                ->locale($locale)
                ->middleware(LocaleDetect::class)
                ->prefix($locale)
                ->group($routes);

            array_pop($this->groupStack);
        }
    }
}
