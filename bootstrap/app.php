<?php

use App\Http\Middleware\ForceJsonResponse;
use App\Responses\ApiResponse;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Response;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        apiPrefix: 'api/v1',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->api(prepend: [
            ForceJsonResponse::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (ValidationException $exception, Request $request) {
            return ApiResponse::error( $exception->getMessage(), 'VALIDATION_ERROR', Response::HTTP_UNPROCESSABLE_ENTITY, $exception->errors()  );
        });

        $exceptions->render(function (NotFoundHttpException $exception, Request $request) {
            return ApiResponse::error( 'Resource not found', 'NOT_FOUND', Response::HTTP_NOT_FOUND );
        });

        $exceptions->render(function (AuthorizationException $exception, Request $request) {
            return ApiResponse::error( $exception->getMessage(), 'FORBIDDEN', Response::HTTP_FORBIDDEN );
        });

        $exceptions->render(function (AccessDeniedHttpException $exception, Request $request) {
            return ApiResponse::error( $exception->getMessage(), 'UNAUTHORIZED', Response::HTTP_UNAUTHORIZED );
        });

        $exceptions->render(function (QueryException $exception, Request $request) {
            return ApiResponse::error( $exception->getMessage(), 'QUERY_ERROR', Response::HTTP_INTERNAL_SERVER_ERROR );
        });

        $exceptions->render(function (AuthenticationException $exception, Request $request) {
            return ApiResponse::error( $exception->getMessage(), 'UNAUTHENTICATED', Response::HTTP_UNAUTHORIZED );
        });
    })->create();
