<?php

namespace App\Responses;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ApiResponse
{
    /**
     * Génère une réponse JSON:API standardisée.
     */
    public static function success(mixed $data, int $status = Response::HTTP_OK): JsonResponse
    {
        return response()->json($data, $status);
    }

    /**
     * Génère une réponse d'erreur au format JSON:API.
     */
    public static function error(string $detail, string $code, int $status): JsonResponse
    {

        return response()->json([
            'errors' => [
                'status' => (string)$status,
                'code' => $code,
                'title' => Response::$statusTexts[$status] ?? 'Error',
                'detail' => $detail,

            ],
            "meta" => [
                "message" => "L'authentification a échoué",
                'timestamp' => now()->toISOString()
            ]
        ], $status);
    }
}
