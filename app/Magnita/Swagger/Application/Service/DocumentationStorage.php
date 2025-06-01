<?php

declare(strict_types=1);

namespace App\Magnita\Swagger\Application\Service;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;

class DocumentationStorage
{
    private const string FILENAME = 'api-documentation.json';

    private Filesystem $disk;

    public function __construct()
    {
        $this->disk = Storage::disk('local');
    }

    public function saveContent(string $jsonContent): void
    {
        $this->disk->put(self::FILENAME, $jsonContent);
    }

    public function getContent(): string
    {
        return $this->disk->get(self::FILENAME) ?? '';
    }

}