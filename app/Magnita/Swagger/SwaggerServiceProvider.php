<?php

namespace App\Magnita\Swagger;

use App\Magnita\Swagger\Infrastructure\Console\GenerateDocumentation;
use Illuminate\Support\ServiceProvider;

class SwaggerServiceProvider extends ServiceProvider
{

    private array $consoleCommands = [
        GenerateDocumentation::class
    ];

    public function boot(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/Infrastructure/config/magnita.php','magnita');
        $this->loadRoutes();
        $this->loadViews();
        $this->loadConsoleCommands();

    }

    public function loadConsoleCommands():void
    {
        $this->commands($this->consoleCommands);
    }


    private function loadViews(): void
    {
        $this->loadViewsFrom(
            __DIR__ . '/Infrastructure/views',
            'swagger'
        );
    }

    private function loadRoutes(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/Infrastructure/routes/api.php');
    }



}
