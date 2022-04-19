<?php

declare(strict_types=1);

namespace Ofat\LaravelTranslatableRoutes;

class TranslationParser
{
    public const PATTERN = '/\[(.*?)]/';

    public function processUri(string $string, ?string $locale = null): string
    {
        return preg_replace_callback(self::PATTERN, static function ($matches) use ($locale) {
            return str()->slug(__($matches[1], [], $locale));
        }, $string);
    }
}
