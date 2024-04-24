<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AdditionalLoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginWithAdditionalPasswordController extends Controller
{
    public function __invoke(AdditionalLoginRequest $request): JsonResponse
    {
        try {
            $user = User::where('phone_number', $request->phone_number)
                ->where('phone_country_code', $request->phone_country_code)
                ->first();

            if (!$user) {
                return $this->responseWithResult('error', 'User not found', 404);
            }


            if (!Hash::check($request->additional_password, $user->additional_password)) {
                return $this->responseWithResult('error', 'Password incorrect!', 401);
            }

            $token = Auth::login($user);

            if (!$token) {
                return $this->responseWithResult('error', 'Unauthorized', 401);
            }

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
