<?php

declare(strict_types=1);

namespace Ofat\LaravelTranslatableRoutes;

use Illuminate\Routing\Router;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\ServiceProvider;
use Ofat\LaravelTranslatableRoutes\Http\Controllers\SwitchLocaleController;
use Ofat\LaravelTranslatableRoutes\Routing\TranslatedRouter;
use Ofat\LaravelTranslatableRoutes\Routing\TranslatedUrlGenerator;
use Ofat\LaravelTranslatableRoutes\UrlTranslator\Context;
use Ofat\LaravelTranslatableRoutes\UrlTranslator\Strategies\EmptyParametersUrlTranslation;
use Ofat\LaravelTranslatableRoutes\UrlTranslator\Strategies\EmptyRouteUrlTranslation;

class TranslatableRoutesServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/translatable-routes.php' => config_path('translatable-routes.php'),
        ]);
    }

    public function register(): void
    {
        $this->extendRouter();
        $this->extendUrlGenerator();
        $this->registerRoutes();
        $this->registerUrlTranslatorContext();
    }

    protected function extendRouter(): void
    {
        $this->app->extend(Router::class, static function (Router $service, $app) {
            return new TranslatedRouter(new TranslationParser(), $service, $app['events'], $app);
        });
    }

    protected function extendUrlGenerator(): void
    {
        $this->app->extend('url', static function (UrlGenerator $service, $app) {
            $routes = $app['router']->getRoutes();

            return new TranslatedUrlGenerator(new TranslationParser(), $routes, $service->getRequest(), $app['config']['app.asset_url']);
        });
    }

    protected function registerRoutes(): void
    {
        $this->app['router']->get('switch-locale/{locale}', SwitchLocaleController::class)->name('switch-locale');
    }

    protected function registerUrlTranslatorContext(): void
    {
        $this->app->bind(Context::class, static function ($app) {
            $context = new Context();
            $context->addStrategy($app->make(EmptyRouteUrlTranslation::class));
            $context->addStrategy($app->make(EmptyParametersUrlTranslation::class));

            foreach (config('translatable-routes.url-translators', []) as $class) {
                $context->addStrategy($app->make($class));
            }

            return $context;
        });
    }
}
