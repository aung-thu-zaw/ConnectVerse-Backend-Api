<?php

namespace App\Http\Middleware;

use App\Models\PhoneVerification;
use App\Models\User;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPhoneVerifyCode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response|JsonResponse
    {
        if (auth()->user() && auth()->check()) {
            $user = User::findOrFail(auth()->id());

            $phoneVerification = PhoneVerification::where('phone_number', $user->phone_number)
                ->where('phone_country_code', $request->phone_country_code)
                ->first();

            if ($phoneVerification && $phoneVerification->phone_verify_code && $phoneVerification->phone_verify_code_expires_at !== null) {

                $expirationTime = Carbon::parse($phoneVerification->phone_verify_code_expires_at);

                if ($expirationTime->lt(now())) {
                    $phoneVerification->resetVerificationCode();
                    Auth::logout();

                    return response()->json(['message' => 'The verification code has expired. Please try again.']);
                }
            }
        }
        return $next($request);
    }
}
