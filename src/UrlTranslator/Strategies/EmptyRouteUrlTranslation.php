<?php

declare(strict_types=1);

namespace Ofat\LaravelTranslatableRoutes\UrlTranslator\Strategies;

use Ofat\LaravelTranslatableRoutes\UrlTranslator\Abstracts\BaseUrlTranslation;

/**
 * Url Translation Strategy for empty routes
 */
class EmptyRouteUrlTranslation extends BaseUrlTranslation
{
    public function getTranslatedUrl(string $locale): string
    {
        return url('/' . $locale);
    }

    public function isApplicable(): bool
    {
        return is_null($this->route);
    }
}
