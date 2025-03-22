<?php

use App\Http\Middleware\ForceJsonResponse;
use App\Http\Middleware\SetLanguage;
use App\Responses\ApiResponse;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Response;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
//        then: function () {
//            Route::prefix('api/v1')
//                ->group(base_path('routes/api/api_v1.php'));
//        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->api(prepend: [
            ForceJsonResponse::class,
            SetLanguage::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Gestion explicite de AuthorizationException
        $exceptions->render(function (AuthorizationException $exception, Request $request) {
            return ApiResponse::error($exception->getMessage(), 'UNAUTHORIZED', Response::HTTP_UNAUTHORIZED);
        });

        // Gestion de AccessDeniedHttpException
        $exceptions->render(function (AccessDeniedHttpException $exception, Request $request) {
            return ApiResponse::error($exception->getMessage(), 'FORBIDDEN', Response::HTTP_FORBIDDEN);
        });

        $exceptions->render(function (ValidationException $exception, Request $request) {
            return ApiResponse::error( $exception->getMessage(), 'VALIDATION_ERROR', Response::HTTP_UNPROCESSABLE_ENTITY);
        });

        $exceptions->render(function (NotFoundHttpException $exception, Request $request) {
            return ApiResponse::error( 'Resource not found', 'NOT_FOUND', Response::HTTP_NOT_FOUND );
        });

        $exceptions->render(function (QueryException $exception, Request $request) {
            return ApiResponse::error( $exception->getMessage(), 'QUERY_ERROR', Response::HTTP_INTERNAL_SERVER_ERROR );
        });

        $exceptions->render(function (AuthenticationException $exception, Request $request) {
            return ApiResponse::error( $exception->getMessage(), 'UNAUTHENTICATED', Response::HTTP_UNAUTHORIZED );
        });

        $exceptions->render(function (ConflictHttpException $exception, Request $request) {
            return ApiResponse::error( $exception->getMessage(), 'CONFLICT', Response::HTTP_CONFLICT );
        });

        $exceptions->render(function (ThrottleRequestsException $exception, Request $request) {
            return ApiResponse::error( $exception->getMessage(), 'TOO_MANY_REQUESTS', Response::HTTP_TOO_MANY_REQUESTS );
        });

        // 400 Bad Request
        $exceptions->render(function (Exception $exception, Request $request) {
            return ApiResponse::error( $exception->getMessage(), 'BAD_REQUEST', Response::HTTP_BAD_REQUEST );
        });

    })->create();
