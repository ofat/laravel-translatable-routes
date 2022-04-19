<?php

declare(strict_types=1);

namespace Ofat\LaravelTranslatableRoutes\UrlTranslator;

use Ofat\LaravelTranslatableRoutes\Routing\TranslatedRoute;
use Ofat\LaravelTranslatableRoutes\UrlTranslator\Contracts\UrlTranslation;
use Ofat\LaravelTranslatableRoutes\UrlTranslator\Exceptions\NotFoundStrategy;

class Context
{
    /**
     * @var array<UrlTranslation>
     */
    protected array $strategies = [];

    public function addStrategy(UrlTranslation $urlTranslation): void
    {
        $this->strategies[] = $urlTranslation;
    }

    public function translateUrl(TranslatedRoute $route, string $locale): string
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
