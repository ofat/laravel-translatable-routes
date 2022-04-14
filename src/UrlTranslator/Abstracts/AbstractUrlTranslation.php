<?php

namespace Ofat\LaravelTranslatableRoutes\UrlTranslator\Abstracts;

use Illuminate\Contracts\Routing\UrlGenerator;
use Ofat\LaravelTranslatableRoutes\Routing\TranslatedRoute;
use Ofat\LaravelTranslatableRoutes\UrlTranslator\Contracts\UrlTranslation;

abstract class AbstractUrlTranslation implements UrlTranslation
{
    /**
     * @var TranslatedRoute|null
     */
    protected ?TranslatedRoute $route = null;


    public function __construct(protected UrlGenerator $urlGenerator)
    {
    }

    /**
     * @param string $locale
     * @return string
     */
    abstract public function getTranslatedUrl(string $locale): string;

    /**
     * @param TranslatedRoute|null $route
     * @return AbstractUrlTranslation
     */
    public function setRoute(?TranslatedRoute $route): AbstractUrlTranslation
    {
        $this->route = $route;
        return $this;
    }
}
