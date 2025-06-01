<?php

declare (strict_types=1);

namespace App\Magnita\Swagger\Infrastructure\Attributes;

use App\Magnita\Common\Application\Service\ConfigReader;
use App\Magnita\Common\Domain\Enum\Locale;
use OpenApi\Attributes as OA;
use OpenApi\Attributes\Schema;

#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD)]
class AcceptLanguageRequestHeader extends OA\Parameter
{
    public function __construct()
    {
        $config = ConfigReader::make();

        parent::__construct(
            name: 'Accept-Language',
            in: 'header',
            schema: new Schema(
                type: 'string',
                default: $config->getDefaultLocale(),
                enum: Locale::class
            )
        );
    }

}