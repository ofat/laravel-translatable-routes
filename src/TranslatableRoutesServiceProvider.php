<?php

namespace Ofat\LaravelTranslatableRoutes;

use Illuminate\Routing\Route;
use Illuminate\Routing\Router;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\ServiceProvider;
use Ofat\LaravelTranslatableRoutes\Routing\TranslatedRouter;
use Ofat\LaravelTranslatableRoutes\Routing\TranslatedUrlGenerator;

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
        $this->app->extend(Router::class, function (Router $service, $app) {
            return new TranslatedRouter(new TranslationParser(), $service->getRoutes(), $app['events'], $app);
        });

        $this->app->extend('url', function (UrlGenerator $service, $app) {
            $routes = $app['router']->getRoutes();

            return new TranslatedUrlGenerator(new TranslationParser(), $routes, $service->getRequest(), $app['config']['app.asset_url']);
        });
    }

}
