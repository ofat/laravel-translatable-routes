<?php

declare(strict_types=1);

namespace Ofat\LaravelTranslatableRoutes\Routing;

use Closure;
use Illuminate\Container\Container;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Routing\Route;
use Illuminate\Routing\Router;
use Ofat\LaravelTranslatableRoutes\Http\Middleware\LocaleDetect;
use Ofat\LaravelTranslatableRoutes\TranslationParser;

class TranslatedRouter extends Router
{
    public function __construct(
        protected TranslationParser $translationParser,
        Router $router,
        Dispatcher $events,
        ?Container $container = null
    ) {
        parent::__construct($events, $container);
        $this->routes = $router->getRoutes();
        $this->middleware = $router->getMiddleware();
        $this->middlewareGroups = $router->getMiddlewareGroups();
    }

    /**
     * @param array|string $methods
     * @param string $uri
     * @param array|string|callable|null $action
     * @return Route|TranslatedRoute
     */
    public function addRoute($methods, $uri, $action): Route|TranslatedRoute
    {
        $translatedUri = $this->translationParser->processUri($uri);
        $route = $this->createRoute($methods, $translatedUri, $action)->defaultName($uri);
        return $this->routes->add($route);
    }

    /**
     * @param array|string $methods
     * @param string $uri
     * @param mixed $action
     * @return Route|TranslatedRoute
     */
    public function newRoute($methods, $uri, $action): Route|TranslatedRoute
    {
        return (new TranslatedRoute($methods, $uri, $action))
            ->setRouter($this)
            ->setContainer($this->container);
    }

    public function localeGroup(Closure|string $callback): void
    {
        $currentLocale = app()->getLocale();
        foreach (config('translatable-routes.locales', []) as $locale) {
            app()->setLocale($locale);
            $this
                ->locale($locale)
                ->middleware(LocaleDetect::class)
                ->prefix($locale)
                ->group($callback);

            array_pop($this->groupStack);
        }
        app()->setLocale($currentLocale);
    }

    /**
     * @return $this
     */
    public function locale(string $locale): static
    {
        $this->updateGroupStack(['locale' => $locale]);

        return $this;
    }
}
