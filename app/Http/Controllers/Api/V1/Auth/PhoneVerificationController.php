<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\VerificationCodeRequest;
use App\Http\Requests\Auth\VerifyCodeRequest;
use App\Http\Resources\UserResource;
use App\Models\PhoneVerification;
use App\Models\User;
use App\Services\VerificationService as ServicesVerificationService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class PhoneVerificationController extends Controller
{
    public function requestVerificationCode(VerificationCodeRequest $request): JsonResponse
    {
        try {
            $phoneVerification = PhoneVerification::firstOrCreate([
                'phone_number' => $request->phone_number,
                'phone_country_code' => $request->phone_country_code,
            ]);

            (new ServicesVerificationService())->sendPhoneVerificationCode($phoneVerification);

            return $this->responseWithResult('success', 'Phone verification code sent successfully.', 200, $phoneVerification);
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }

    public function verifyCode(VerifyCodeRequest $request): JsonResponse
    {
        try {
            $phoneVerification = PhoneVerification::where('phone_number', $request->phone_number)
                ->where('phone_country_code', $request->phone_country_code)
                ->first();

            if (!$phoneVerification) {
                throw new Exception('Phone verification record not found!');
            }

            if ($phoneVerification->phone_verify_code !== $request->verification_code) {
                throw new Exception('Invalid verification code!');
            }

            $phoneVerification->update(["phone_last_verified_at" => now()]);

            $phoneVerification->resetVerificationCode();

            $user = User::where('phone_number', $request->phone_number)
                ->where('phone_country_code', $request->phone_country_code)
                ->whereNotNull('phone_verified_at')
                ->first();

            $response = null;

            if(!$user) {
                $response = ['proceed_action' => 'create-profile','message' => 'User need to register their profile!'];
            }

            if ($user && !$user->enabled_two_factor) {

                $token = Auth::login($user);

                if (!$token) {
                    return $this->responseWithResult('error', 'Unauthorized', 401);
                }

                $response = [
                    "message" => "User authenticated successfully!",
                    'user' => new UserResource($user),
                    'authorization' => [
                        'token' => $token,
                        'type' => 'bearer',
                    ],
                ];
            }

            if ($user && $user->enabled_two_factor) {
                $response = ['proceed_action' => 'add-additional-password','message' => 'Two Factor was enabled. User need to provide additional password for their login.'];
            }

            return $this->responseWithResult('success', 'Verify code successfully', 200, $response);
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }
}
