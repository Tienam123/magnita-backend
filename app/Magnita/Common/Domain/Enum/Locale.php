<?php

namespace App\Magnita\Common\Domain\Enum;

enum Locale: string
{
    case UA = 'ua';

    case RU = 'ru';

    case EN = 'en';

    /**
     * @return string[]
     */
    public static function valuesToArray(): array
    {
        return array_map(
            static fn (\UnitEnum $case) => $case->value,
            self::cases()
        );
    }

}
