<?php

use App\Magnita\Common\Domain\AbstractDomainException;
use App\Magnita\Common\Infrastructure\Http\ResourceNotExistsException;
use App\Magnita\Common\Infrastructure\Middleware\SetLocaleFromRequest;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


/**
 * Check if functions exists, because it can cause "Cannot redeclare function" error in unit tests
 */
if (!function_exists('notFoundExceptionToResponse')) {
    function notFoundExceptionToResponse(NotFoundHttpException $e): JsonResponse
    {
        $data = [
            'message' => 'API route not found.',
        ];

        appendDebugDataToResponse($data, $e);

        return new JsonResponse(
            data: $data,
            status: 404
        );
    }
}

/**
 * Check if functions exists, because it can cause "Cannot redeclare function" error in unit tests
 */
if (!function_exists('notFoundExceptionToResponse')) {
    function notFoundExceptionToResponse(NotFoundHttpException $e): JsonResponse
    {
        $data = [
            'message' => 'API route not found.',
        ];

        appendDebugDataToResponse($data, $e);

        return new JsonResponse(
            data: $data,
            status: 404
        );
    }
}

if (!function_exists('validationExceptionToResponse')) {
    function validationExceptionToResponse(ValidationException $e): JsonResponse
    {
        $data = [
            'message' => 'The given data was invalid.',
            // return only first validation error for property, by default Laravel returns array with only first error
            'errors' => array_map(static function ($errors) {
                return $errors[0];
            }, $e->validator->getMessageBag()->toArray()),
        ];

        appendDebugDataToResponse($data, $e);

        return new JsonResponse(
            data: $data,
            status: 422
        );
    }
}

if (!function_exists('httpExceptionToResponse')) {
    function httpExceptionToResponse(HttpException $e): JsonResponse
    {
        $data = [
            'message' => $e->getMessage(),
        ];

        appendDebugDataToResponse($data, $e);

        return new JsonResponse(
            data: $data,
            status: $e->getStatusCode()
        );
    }
}

if (!function_exists('modelNotFoundExceptionToResponse')) {
    function modelNotFoundExceptionToResponse(ModelNotFoundException $e): JsonResponse
    {
        $data = [
            'message' => 'API resource not exists.',
        ];

        appendDebugDataToResponse($data, $e);

        return new JsonResponse(
            data: $data,
            status: 404
        );
    }
}

if (!function_exists('domainExceptionToResponse')) {
    function domainExceptionToResponse(AbstractDomainException $e): JsonResponse
    {
        $data = [
            'message' => 'Domain error.',
            'errors' => [
                [
                    'code' => $e->getDomainErrorCode(),
                    'message' => $e->getMessage(),
                    'context' => $e->getPublicContext(),
                ],
            ],
        ];

        appendDebugDataToResponse($data, $e);

        return new JsonResponse(
            data: $data,
            status: $e->getStatusCode()
        );
    }
}

if (!function_exists('authenticationExceptionToResponse')) {
    function authenticationExceptionToResponse(AuthenticationException $e): JsonResponse
    {
        $data = [
            'message' => $e->getMessage(),
        ];

        appendDebugDataToResponse($data, $e);

        return new JsonResponse(
            data: $data,
            status: 401
        );
    }
}

if (!function_exists('exceptionToResponse')) {
    function exceptionToResponse(\Throwable $e): JsonResponse
    {
        $data = [
            'message' => 'Server error.',
        ];

        appendDebugDataToResponse($data, $e);

        return new JsonResponse(
            data: $data,
            status: 500
        );
    }
}

if (!function_exists('appendDebugDataToResponse')) {
    function appendDebugDataToResponse(array &$data, \Throwable $e): void
    {
        if (config('app.debug', false)) {
            $data['exception'] = [
                'file' => $e->getFile(),
                'class' => get_class($e),
                'line' => $e->getLine(),
                'message' => $e->getMessage(),
                'trace' => $e->getTrace(),
            ];
        }
    }
}

if (!function_exists('resourceNotExistsExceptionToResponse')) {
    function resourceNotExistsExceptionToResponse(ResourceNotExistsException $e): JsonResponse
    {
        $data = [
            'message' => $e->getMessage(),
            'errors' => [
                [
                    'code' => $e->getErrorCode(),
                ],
            ],
        ];

        appendDebugDataToResponse($data, $e);

        return new JsonResponse(
            data: $data,
            status: $e->getStatusCode()
        );
    }
}




return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([

        ]);

        return $middleware->append(SetLocaleFromRequest::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {

        // don't write domain exception into log
        $exceptions->report(static function (AbstractDomainException $e) {})->stop();

        $exceptions->render(static function (\Throwable $e) {

            if ($e instanceof ValidationException) {
                return validationExceptionToResponse($e);
            }

            if ($e instanceof ResourceNotExistsException) {
                return resourceNotExistsExceptionToResponse($e);
            }

            if ($e instanceof HttpException) {
                return httpExceptionToResponse($e);
            }

            if ($e instanceof ModelNotFoundException) {
                return modelNotFoundExceptionToResponse($e);
            }

            if ($e instanceof AbstractDomainException) {
                return domainExceptionToResponse($e);
            }

            if ($e instanceof AuthenticationException) {
                return authenticationExceptionToResponse($e);
            }

            return exceptionToResponse($e);

        });

    })->create();
