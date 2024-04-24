<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\CreateProfileRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class CreateProfileController extends Controller
{
    public function __invoke(CreateProfileRequest $request): JsonResponse
    {
        try {
            $user = User::create($request->validated() + ['phone_verified_at' => now()]);

            $token = Auth::login($user);

            $response = [
                'user' => new UserResource($user),
                'authorization' => [
                    'token' => $token,
                    'type' => 'bearer',
                ],
            ];

            return $this->responseWithResult('success', 'User created successfully.', 200, $response);

        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }
}
