<?php

declare(strict_types=1);

namespace Ofat\LaravelTranslatableRoutes\UrlTranslator;

use Exception;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route as RouteFacade;
use Ofat\LaravelTranslatableRoutes\Routing\TranslatedRoute;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UrlTranslator
{
    protected ?TranslatedRoute $previousRoute = null;

    public function __construct(
        protected UrlGenerator $urlGenerator,
        protected Context $context
    ) {
    }

    /**
     * @throws Exception
     */
    public function getTranslatedPreviousUrl(string $locale): string
    {
        $this->detectPreviousRoute();
        app()->setLocale($locale);

        return $this->context->translateUrl($this->previousRoute, $locale);
    }

    protected function detectPreviousRoute(): void
    {
        $oldUrl = parse_url($this->urlGenerator->previous());

        if (isset($oldUrl['path'])) {
            try {
                $this->previousRoute = RouteFacade::getRoutes()->match(Request::create($oldUrl['path']));
            } catch (HttpException $exception) {
            }
        }
    }
}
