<?php

namespace Ofat\LaravelTranslatableRoutes;

class TranslationParser
{

    const PATTERN = '/\[(.*?)\]/';

    public function processUri(string $string) : string
    {
        return preg_replace_callback(static::PATTERN, function($matches){
            return str()->slug( __($matches[1]) );
        }, $string);
    }

}
