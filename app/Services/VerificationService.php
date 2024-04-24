<?php

namespace App\Services;

use App\Models\PhoneVerification;
use Illuminate\Support\Facades\Log;
use Twilio\Rest\Client;

class VerificationService
{
    public function sendPhoneVerificationCode(PhoneVerification $phoneVerification): void
    {
        $phoneVerification->generateVerificationCode();

        $client = new Client(config('services.twilio.sid'), config('services.twilio.token'));

        try {
            $client->messages->create(
                $phoneVerification->phone_number,
                [
                    'from' => config('services.twilio.phone'),
                    'body' => 'Your verification code is: ' . $phoneVerification->phone_verify_code. 'The code will be expire in 30 minutes.',
                ]
            );
        } catch (\Exception $e) {
            Log::error('Twilio SMS sending failed: ' . $e->getMessage());
        }
    }
}
