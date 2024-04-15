<?php

namespace App\Http\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponses
{
    protected function apiExceptionResponse(\Exception $e): JsonResponse
    {
        return response()->json(['message' => $e->getMessage(), 'status' => 500], 500);
    }

    /**
     * @param  mixed  $data
     */
    protected function responseWithResult(string $status, string $message, int $statusCode, $data = null): JsonResponse
    {
        $responseData = [
            'status' => $status,
            'message' => $message,
        ];

        if ($data !== null) {
            $responseData['data'] = $data;
        }

        return response()->json($responseData, $statusCode);
    }
}
