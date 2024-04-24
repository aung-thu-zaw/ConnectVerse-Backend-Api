<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "username" => ["required", "string", "max:100", "regex:/^[a-z0-9]+(?:[_-][a-z0-9]+)*$/"],
            "display_name" => ["required","string","max:100"],
            'phone_number' => [
                'required',
                'phone',
                Rule::exists('phone_verifications', 'phone_number')->where(function ($query) {
                    $query->whereNotNull('phone_last_verified_at');
                }),
            ],
            'phone_country_code' => ['required', 'string'],
            'recovery_email' => ['nullable',"email", 'string',Rule::unique("users", "recovery_email")],
            'avatar' => ["nullable","image","mimes:png,jpg,jpeg","max:1500"]
        ];
    }
}
