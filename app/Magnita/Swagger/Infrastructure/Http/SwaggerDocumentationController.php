<?php

declare(strict_types=1);

namespace App\Magnita\Swagger\Infrastructure\Http;


use App\Magnita\Swagger\Application\Service\ConfigReader;
use App\Magnita\Swagger\Application\Service\DocumentationStorage;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use OpenApi\Attributes as OA;

class SwaggerDocumentationController
{
    public function __construct(
        private ConfigReader $configReader,
        private DocumentationStorage $documentationStorage,
    )
    {
    }

    #[OA\Get(
        path: '/swagger/documentation',
        operationId: 'swagger.documentation.get',
        description: 'Показывает страницу с документацией API, если включено в конфигурации.',
        summary: 'Отображение Swagger UI',
        tags: ['Swagger'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Страница с документацией успешно отображена (Swagger UI)'
            ),
            new OA\Response(
                response: 404,
                description: 'Документация отключена или не найдена'
            )
        ]
    )]
    public function viewDocumentation():View
    {
        if (!$this->configReader->swaggerIsEnabled()) {
            abort(404);
        }
        return view('swagger::swagger',[
            'json_url' => route('swagger.get-documentation-json')
        ]);
    }

    public function getDocumentationJson()
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