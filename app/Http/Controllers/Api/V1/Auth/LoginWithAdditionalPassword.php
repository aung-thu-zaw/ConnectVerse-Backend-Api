<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AdditionalLoginRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;

class LoginWithAdditionalPassword extends Controller
{
    public function __invoke(AdditionalLoginRequest $request): JsonResponse
    {
        try {
            $credentials = $request->only('phone_number', 'additional_password');

            $token = Auth::attempt($credentials);

            if (!$token) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthorized',
                ], 401);
            }

            $user = Auth::user();

            $response = [
                'user' => new UserResource($user),
                'authorization' => [
                    'token' => $token,
                    'type' => 'bearer',
                ],
            ];

            return $this->responseWithResult('success', 'User logged in successfully', 200, $response);
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }
}
