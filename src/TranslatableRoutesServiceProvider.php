<?php

namespace Ofat\LaravelTranslatableRoutes;

use Illuminate\Routing\Route;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Ofat\LaravelTranslatableRoutes\Routing\TranslatableRouter;
use Ofat\LaravelTranslatableRoutes\Routing\UrlGenerator;

class TranslatableRoutesServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/translatable-routes.php' => config_path('translatable-routes.php'),
        ]);
    }

    public function register()
    {
        $this->app->singleton('router', function ($app) {
            return new TranslatableRouter(new TranslationParser(), $app['events'], $app);
        });

        $this->app->singleton('url', function ($app) {
            $routes = $app['router']->getRoutes();

            // The URL generator needs the route collection that exists on the router.
            // Keep in mind this is an object, so we're passing by references here
            // and all the registered routes will be available to the generator.
            $app->instance('routes', $routes);

            return new UrlGenerator(
                new TranslationParser(),
                $routes, $app->rebinding(
                'request', $this->requestRebinder()
            ), $app['config']['app.asset_url']
            );
        });
    }

    /**
     * Get the URL generator request rebinder.
     *
     * @return \Closure
     */
    protected function requestRebinder()
    {
        return function ($app, $request) {
            $app['url']->setRequest($request);
        };
    }
}
