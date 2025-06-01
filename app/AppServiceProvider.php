<?php

namespace App;

use App\Magnita\Auth\AuthServiceProvider;
use App\Magnita\Common\CommonServiceProvider;
use App\Magnita\Common\Infrastructure\Providers\TelescopeServiceProvider;
use App\Magnita\Swagger\SwaggerServiceProvider;
use App\Magnita\User\UserServiceProvider;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    private array $modules = [
        UserServiceProvider::class,
        AuthServiceProvider::class,
        CommonServiceProvider::class,
        SwaggerServiceProvider::class
    ];

    public function register():void
    {
        if (!$this->app->isProduction() && class_exists(\Laravel\Telescope\TelescopeServiceProvider::class)) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    public function boot(): void
    {
        foreach ($this->modules as $module) {
            $this->app->register($module);
        }
    }
}
