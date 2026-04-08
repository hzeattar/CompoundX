<?php

declare(strict_types=1);

namespace App\Support;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiResponse
{
    public static function success(
        Request $request,
        mixed $data = null,
        ?string $message = null,
        ?array $meta = null,
        int $status = 200,
    ): JsonResponse {
        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => $message,
            'errors' => null,
            'meta' => self::meta($request, $meta),
        ], $status);
    }

    public static function error(
        Request $request,
        string $message,
        ?array $errors = null,
        int $status = 400,
        ?array $meta = null,
    ): JsonResponse {
        return response()->json([
            'success' => false,
            'data' => null,
            'message' => $message,
            'errors' => $errors,
            'meta' => self::meta($request, $meta),
        ], $status);
    }

    private static function meta(Request $request, ?array $meta = null): array
    {
        return array_filter([
            'request_id' => $request->attributes->get('request_id'),
            'locale' => $request->attributes->get('resolved_locale', app()->getLocale()),
            'timestamp' => now()->toIso8601String(),
            ...($meta ?? []),
        ], static fn (mixed $value): bool => $value !== null);
    }
}
