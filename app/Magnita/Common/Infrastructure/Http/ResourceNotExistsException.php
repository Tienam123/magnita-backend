<?php

namespace App\Magnita\Common\Infrastructure\Http;

use App\Magnita\Common\Domain\Enum\ErrorCode;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ResourceNotExistsException extends HttpException
{
    private string|\BackedEnum $error_code;

    public function __construct(string $message, string|\BackedEnum $error_code = ErrorCode::COMMON_RESOURCE_NOT_FOUND)
    {
        $this->error_code = $error_code;

        parent::__construct(
            statusCode: 404,
            message: $message,
        );
    }

    public function getErrorCode(): string
    {
        return is_string($this->error_code) ? $this->error_code : (string) $this->error_code->value;
    }

}