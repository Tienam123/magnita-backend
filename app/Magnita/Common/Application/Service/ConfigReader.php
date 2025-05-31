<?php

namespace App\Magnita\Common\Application\Service;

use App\Magnita\Common\Domain\Enum\Locale;

class ConfigReader
{

    public static function make():self
    {
        return new self();
    }

    public function getDefaultLocale():Locale
    {
        return Locale::from(config('magnita.default_locale'));
    }
}