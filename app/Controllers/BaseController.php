<?php

declare(strict_types=1);

namespace App\Controllers;

class BaseController
{
    final protected function sanitizeInput(string|int $value): string|int
    {
        return (is_int($value))
            ? $value
            : htmlspecialchars(trim($value));
    }

    final protected function successResponse(array $data, int $statusCode = 200, string $message = 'success'): void
    {
        response()->httpCode($statusCode)->json([
            'error' => false,
            'message' => $message,
            'data' => $data
        ]);
    }

    final protected function errorResponse(array $data, int $statusCode = 500, string $message = 'error'): void
    {
        response()->httpCode($statusCode)->json([
            'error' => false,
            'message' => $message,
            'data' => $data
        ]);
    }
}