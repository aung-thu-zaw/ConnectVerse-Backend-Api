<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhoneVerification extends Model
{
    use HasFactory;

    public function generateVerificationCode(): void
    {
        $this->timestamps = false;
        $this->phone_verify_code = (string) rand(100000, 999999);
        $this->phone_verify_code_expires_at = now()->addMinutes(30);
        $this->save();
    }

    public function resetVerificationCode(): void
    {
        $this->timestamps = false;
        $this->phone_verify_code = null;
        $this->phone_verify_code_expires_at = null;
        $this->save();
    }
}
