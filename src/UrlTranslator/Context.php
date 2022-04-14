<?php

namespace Ofat\LaravelTranslatableRoutes\UrlTranslator;

use Illuminate\Routing\Route;
use Ofat\LaravelTranslatableRoutes\UrlTranslator\Contracts\UrlTranslation;
use Ofat\LaravelTranslatableRoutes\UrlTranslator\Exceptions\NotFoundStrategy;

class Context
{
    /**
     * @var UrlTranslation[]
     */
    protected array $strategies = [];

    public function addStrategy(UrlTranslation $urlTranslation): void
    {
        $this->strategies[] = $urlTranslation;
    }

    /**
     * @param Route $route
     * @param $locale
     * @return string
     * @throws \Error
     */
    public function translateUrl(Route $route, $locale): string
    {
        foreach ($this->strategies as $strategy) {
            $strategy->setRoute($route);

            if ($strategy->isApplicable()) {
                return $strategy->getTranslatedUrl($locale);
            }
        }

        throw new NotFoundStrategy('Strategy for url translation not found');
    }
}
