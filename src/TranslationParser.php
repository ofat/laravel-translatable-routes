<?php

namespace Ofat\LaravelTranslatableRoutes;

class TranslationParser
{

    const PATTERN = '/\[(.*?)\]/';

    public function processUri(string $string, $locale = null) : string
    {
        return preg_replace_callback(static::PATTERN, function($matches) use($locale) {
            return str()->slug( __($matches[1], [], $locale) );
        }, $string);
    }

}
