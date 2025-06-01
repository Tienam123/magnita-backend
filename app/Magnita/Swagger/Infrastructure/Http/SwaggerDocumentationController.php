<?php

declare(strict_types=1);

namespace App\Magnita\Swagger\Infrastructure\Http;


use App\Magnita\Swagger\Application\Service\ConfigReader;
use App\Magnita\Swagger\Application\Service\DocumentationStorage;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class SwaggerDocumentationController
{
    public function __construct(
        private readonly ConfigReader $configReader,
        private readonly DocumentationStorage $documentationStorage,
    )
    {
    }

    public function viewDocumentation():View
    {
        if (!$this->configReader->swaggerIsEnabled()) {
            abort(404);
        }
        return view('swagger::swagger',[
            'json_url' => route('swagger.get-documentation-json')
        ]);
    }

    public function getDocumentationJson():JsonResponse|View
    {
        if (! $this->configReader->swaggerIsEnabled()) {
            abort(404);
        }

        return new JsonResponse(
            data: $this->documentationStorage->getContent(),
            json: true
        );
    }

}