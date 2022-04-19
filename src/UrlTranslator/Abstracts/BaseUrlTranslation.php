<?php

declare(strict_types=1);

namespace Ofat\LaravelTranslatableRoutes\UrlTranslator\Abstracts;

use Illuminate\Contracts\Routing\UrlGenerator;
use Ofat\LaravelTranslatableRoutes\Routing\TranslatedRoute;
use Ofat\LaravelTranslatableRoutes\UrlTranslator\Contracts\UrlTranslation;

abstract class BaseUrlTranslation implements UrlTranslation
{
    protected ?TranslatedRoute $route = null;

    public function __construct(protected UrlGenerator $urlGenerator)
    {
    }

    abstract public function getTranslatedUrl(string $locale): string;

    public function setRoute(?TranslatedRoute $route): BaseUrlTranslation
    {
        $this->route = $route;
        return $this;
    }
}
