<?php

namespace Ofat\LaravelTranslatableRoutes\UrlTranslator;

use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Request;
use \Illuminate\Support\Facades\Route as RouteFacade;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UrlTranslator
{

    /**
     * @var Route|null
     */
    protected ?Route $previousRoute = null;

    public function __construct(
        protected UrlGenerator $urlGenerator,
        protected Context $context
    )
    {}

    /**
     * @param string $locale
     * @return string
     * @throws \Exception
     */
    public function getTranslatedPreviousUrl(string $locale): string
    {
        $this->detectPreviousRoute();
        app()->setLocale($locale);

        return $this->context->translateUrl($this->previousRoute, $locale);
    }

    /**
     * @return void
     */
    protected function detectPreviousRoute()
    {
        $oldUrl = parse_url($this->urlGenerator->previous());

        if(isset($oldUrl['path']))
        {
            try {
                $this->previousRoute = RouteFacade::getRoutes()->match(Request::create($oldUrl['path']));
            } catch (HttpException $exception)
            {
            }
        }
    }
}
