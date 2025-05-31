<?php

namespace App\Magnita\Common;

use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\ServiceProvider;

class CommonServiceProvider extends ServiceProvider
{

    private array $consoleCommands = [];

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/Infrastructure/Database/migrations');
        $this->mergeConfigFrom(__DIR__ . '/Infrastructure/config/magnita.php', 'magnita');
        $this->loadConsoleCommands();
        $this->registerSchedulerTasks();
    }

    public function loadConsoleCommands():void
    {
        $this->commands($this->consoleCommands);
    }

    private function registerSchedulerTasks(): void
    {
        Schedule::command('telescope:prune')->daily();
    }

    private function loadRoutes(): void
    {
    }

}
