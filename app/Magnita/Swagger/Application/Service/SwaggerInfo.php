<?php

declare(strict_types=1);

namespace App\Magnita\Swagger\Application\Service;

use OpenApi\Attributes as OA;

#[OA\Info(
  version: '1.0',
  title: 'Documentation Magnita',
  contact: new OA\Contact(
      name: 'Magnita',
      email: 'dr.tienam123@gmail.com'
    )
)]
#[OA\SecurityScheme(
    securityScheme: 'bearer',
    type: 'http',
    description: 'Bearer Token',
    in: 'header',
    scheme: 'bearer',
)]
#[OA\Server(
    url: '/api/v1',
    description: 'v1 API prefix',
)]
class SwaggerInfo
{

}