<?php

namespace App\Magnita\Swagger\Infrastructure\Console;

use App\Magnita\Swagger\Application\Service\DocumentationGenerator;
use Illuminate\Console\Command;

class GenerateDocumentation extends Command
{
    protected $signature = 'magnita:swagger:generate';

    protected $description = 'Command description';

    public function handle(DocumentationGenerator $generator): void
    {
        $generator->generate();
        $this->info('Documentation generated successfully');
    }
}
