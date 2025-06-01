<?php

namespace App\Magnita\Swagger\Application\Service;

use \App\Magnita\Common\Application\Service\ConfigReader as CommonConfigReader;
use OpenApi\Generator;

class DocumentationGenerator
{
    public function __construct(
        private DocumentationStorage $documentationStorage,
        private CommonConfigReader $commonConfigReader
    ) {
    }

    public function generate(): void
    {
        $pathToScan = dirname(__DIR__, 3);

        $openapi = Generator::scan([$pathToScan]);

        if ($openapi === null) {
            throw new \RuntimeException('API generation failed. Generator return null');
        }

        $openapi->info->description = $this->getAPIDescription();

        $jsonContent = $openapi->toJson();
        $this->documentationStorage->saveContent($jsonContent);
    }

    private function getAPIDescription(): string
    {
        return view('swagger::api-description', [
            'default_locale' => $this->commonConfigReader->getDefaultLocale(),
        ])->render();
    }

}