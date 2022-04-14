[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/support-ukraine.svg?t=1" />](https://supportukrainenow.org)

# Package to make Laravel routes translatable

[![Latest Version on Packagist](https://img.shields.io/packagist/v/ofat/laravel-translatable-routes.svg?style=flat-square)](https://packagist.org/packages/ofat/laravel-translatable-routes)
[![MIT Licensed](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)

This package provides you possibility to translate your urls. For example:

```
EN: /en/country/germany, /en/about-us
DE: /de/land/deutschland, /de/uber-uns
```

It is very useful for good search engine optimization (seo).

## Installation

1. Install package via composer:
```bash
composer require ofat/laravel-translatable 
```

2. Add your translations to resource/lang like usual Laravel translations.

resources/lang/en.json:
```json
{
    "country": "Country",
    "about-us": "About us"
}
```

resources/lang/de.json:
```json
{
    "country": "Land",
    "about-us": "Uber uns"
}
```

3. Define your supported locales in config file:

config/translatable-routes.php:
```php
return [
    'locales' => ['en', 'de']
];
```

## Routing

Once the package is installed you can use your translation strings in 
route defining with square brackets.

To define group with added language prefix you can use `localeGroup` method
and write all routes inside it.

```php
Route::localeGroup(function() {
    Route::get('[country]/{country}', function($country) {
    
    });
    Route::get('[about-us]', function(){
        return 'hi!';
    });
});
```

### Named Routes

You can also use names for your routes inside localeGroup. It will create 
separate route name for each locale:

```php
Route::localeGroup(function(){
    Route::get('[country]/{country}', function($country){
    
    })->name('country')
});
```

## URL Generating

### Generate URL by route 

You can use normal `route` function to generate url in current locale:

```php
route('country', ['country' => $country]);

url()->route('country', ['country' => $country])
```

Depends on current locale it will create `/en/country/...` or `/de/land/...`

You can use `routeInLocale` method if you need to generate URL in concrete locale 
or just add locale in your route name:

```php
routeInLocale('de', 'country', ['country' => $country]);

url()->routeInLocale('de', 'country', ['country' => $country]);

route('de.country', ['country' => $country]);
```

### Generate URL by path

You can also use translation keys in square brackets in `url` function.
But it doesn't add locale prefix to your URL

```php
url('[country]/belgium')

url()->to('[country]/belgium')
```

To add locale prefix to your url:

```php
url()->withLocale('[country]/belgium'); // generates `en/country/belgium`

urlWithLocale('[country]/belgium');

urlWithLocale('[country]/belgium', $params, 'en'); // specify needed locale. generates `de/land/belgium`
```

## Locale switch

To generate url for language switching you can use named route `switch-locale`

```php
route('switch-locale', 'fr')
```

All static routes will be switching by default. But for routes with parameters
you can add strategies and define logic for translation:

```php

namespace App\Service\UrlTranslator;

use App\Models\Country;
use Ofat\LaravelTranslatableRoutes\UrlTranslator\Abstracts\AbstractUrlTranslation;

class CountryUrlTranslation extends AbstractUrlTranslation
{
    /**
     * Get current route translated url
     * 
     * @param string $locale
     * @return string
     */
    public function getTranslatedUrl(string $locale): string
    {
        $country = Country::query()
            ->where('url->'.$this->route->getLocale(), $this->route->parameter('country'))
            ->firstOrFail();

        return $this->urlGenerator->route('country', $country->url);
    }

    /**
     * Check if current route is applicable to this strategy
     *
     * @return bool
     */
    public function isApplicable(): bool
    {
        return strpos($this->route->getName(), '.country') > 0;
    }
}
```

In this case if you try to switch language on page `/en/country/france` it will redirect to
`/fr/les-pays/la-france`

In `isApplicable` method you should write your logic for checking if 
route is determined to your group needs.

In `getTranslatedUrl` method you should write your logic to generate url for 
your route on new locale
