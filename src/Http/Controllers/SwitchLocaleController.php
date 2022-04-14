<?php

namespace Ofat\LaravelTranslatableRoutes\Http\Controllers;

use Illuminate\Routing\Controller;
use Ofat\LaravelTranslatableRoutes\UrlTranslator\UrlTranslator;

class SwitchLocaleController extends Controller
{
    /**
     * @param string $locale
     * @param UrlTranslator $urlTranslator
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function __invoke(string $locale, UrlTranslator $urlTranslator)
    {
        return redirect( $urlTranslator->getTranslatedPreviousUrl($locale) );
    }
}
