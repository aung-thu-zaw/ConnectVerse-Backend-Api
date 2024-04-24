<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [new Middleware('auth:api', ["logout","refresh"])];
    }

    public function logout(): JsonResponse
    {
        try {
            Auth::logout();

            return $this->responseWithResult('success', 'User logged out successfully', 200);
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }

    public function refresh(): JsonResponse
    {
        try {
            return response()->json([
                'status' => 'success',
                // 'user' => new UserResource(Auth::user()),
                'authorization' => [
                    'token' => Auth::refresh(),
                    'type' => 'bearer',
                ],
            ]);
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }
}
