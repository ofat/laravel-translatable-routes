<?php

declare(strict_types=1);

namespace Ofat\LaravelTranslatableRoutes\Http\Controllers;

use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Redirector;
use Ofat\LaravelTranslatableRoutes\UrlTranslator\UrlTranslator;

class SwitchLocaleController extends Controller
{
    /**
     * @throws Exception
     */
    public function __invoke(string $locale, UrlTranslator $urlTranslator): Redirector|RedirectResponse
    {
        return redirect($urlTranslator->getTranslatedPreviousUrl($locale));
    }
}
