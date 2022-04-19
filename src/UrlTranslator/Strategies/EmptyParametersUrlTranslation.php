<?php

declare(strict_types=1);

namespace Ofat\LaravelTranslatableRoutes\UrlTranslator\Strategies;

use Ofat\LaravelTranslatableRoutes\UrlTranslator\Abstracts\BaseUrlTranslation;

/**
 * Url translation strategy for routes without parameters
 */
class EmptyParametersUrlTranslation extends BaseUrlTranslation
{
    public function getTranslatedUrl(string $locale): string
    {
        $routeName = $this->route->getName();

        return $this->urlGenerator->route($locale . substr($routeName, strpos($routeName, '.')));
    }

    public function isApplicable(): bool
    {
        return empty($this->route->parameters());
    }
}
