<?php

namespace Ofat\LaravelTranslatableRoutes\UrlTranslator\Contracts;

interface UrlTranslation
{
    /**
     * @return bool
     */
    public function isApplicable(): bool;

    /**
     * @param string $locale
     * @return string
     */
    public function getTranslatedUrl(string $locale): string;
}
