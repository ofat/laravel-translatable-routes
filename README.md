# Package to make Laravel routes translatable

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

To define group with added language prefix you can use `languageGroup` method
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
