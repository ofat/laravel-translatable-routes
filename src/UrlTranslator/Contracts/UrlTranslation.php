<?php

declare(strict_types=1);

namespace Ofat\LaravelTranslatableRoutes\UrlTranslator\Contracts;

interface UrlTranslation
{
    public function isApplicable(): bool;

    public function getTranslatedUrl(string $locale): string;
}
