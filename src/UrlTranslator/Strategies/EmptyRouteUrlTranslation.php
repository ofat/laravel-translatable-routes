<?php

namespace Ofat\LaravelTranslatableRoutes\UrlTranslator\Strategies;

use Ofat\LaravelTranslatableRoutes\UrlTranslator\Abstracts\AbstractUrlTranslation;

/**
 * Url Translation Strategy for empty routes
 */
class EmptyRouteUrlTranslation extends AbstractUrlTranslation
{

    public function getTranslatedUrl(string $locale): string
    {
        return redirect('/'.$locale);
    }

    public function isApplicable(): bool
    {
        return is_null($this->route);
    }
}
