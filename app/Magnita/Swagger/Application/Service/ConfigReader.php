<?php

namespace App\Magnita\Swagger\Application\Service;

class ConfigReader
{
    public function swaggerIsEnabled():bool
    {
        return (bool) config('magnita.swagger.swagger_enabled', false);
    }
}