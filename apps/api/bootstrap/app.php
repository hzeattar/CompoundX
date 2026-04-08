<?php

use App\Support\ApiResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException;
use Stancl\Tenancy\Exceptions\TenantCouldNotBeIdentifiedById;
use Stancl\Tenancy\Exceptions\TenantCouldNotBeIdentifiedByPathException;
use Stancl\Tenancy\Exceptions\TenantCouldNotBeIdentifiedByRequestDataException;
use Stancl\Tenancy\Exceptions\TenantCouldNotBeIdentifiedOnDomainException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        apiPrefix: 'api/v1',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request, \Throwable $exception) => $request->is('api/*') || $request->expectsJson()
        );

        $exceptions->render(function (ValidationException $exception, Request $request) {
            return ApiResponse::error(
                request: $request,
                message: 'The given data was invalid.',
                errors: $exception->errors(),
                status: Response::HTTP_UNPROCESSABLE_ENTITY,
            );
        });

        $exceptions->render(function (AuthenticationException $exception, Request $request) {
            return ApiResponse::error(
                request: $request,
                message: 'Authentication is required to access this resource.',
                status: Response::HTTP_UNAUTHORIZED,
            );
        });

        $exceptions->render(function (TokenExpiredException $exception, Request $request) {
            return ApiResponse::error(
                request: $request,
                message: 'The provided token has expired.',
                status: Response::HTTP_UNAUTHORIZED,
            );
        });

        $exceptions->render(function (JWTException $exception, Request $request) {
            return ApiResponse::error(
                request: $request,
                message: 'A valid JWT token is required.',
                status: Response::HTTP_UNAUTHORIZED,
            );
        });

        $tenantResolutionExceptions = [
            TenantCouldNotBeIdentifiedOnDomainException::class,
            TenantCouldNotBeIdentifiedByRequestDataException::class,
            TenantCouldNotBeIdentifiedByPathException::class,
            TenantCouldNotBeIdentifiedById::class,
        ];

        foreach ($tenantResolutionExceptions as $tenantResolutionException) {
            $exceptions->render(function (\Throwable $exception, Request $request) use ($tenantResolutionException) {
                if (! $exception instanceof $tenantResolutionException) {
                    return null;
                }

                return ApiResponse::error(
                    request: $request,
                    message: 'No tenant is mapped to the provided request host.',
                    status: Response::HTTP_NOT_FOUND,
                );
            });
        }

        $exceptions->render(function (\Throwable $exception, Request $request) {
            if (! ($request->is('api/*') || $request->expectsJson())) {
                return null;
            }

            $status = $exception instanceof HttpExceptionInterface
                ? $exception->getStatusCode()
                : Response::HTTP_INTERNAL_SERVER_ERROR;

            $message = $status >= 500
                ? 'An unexpected server error occurred.'
                : ($exception->getMessage() ?: Response::$statusTexts[$status] ?? 'Request failed.');

            $errors = config('app.debug')
                ? ['exception' => class_basename($exception)]
                : null;

            return ApiResponse::error(
                request: $request,
                message: $message,
                errors: $errors,
                status: $status,
            );
        });
    })->create();
