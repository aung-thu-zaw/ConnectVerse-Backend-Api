<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LoginRequest extends FormRequest
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
            "username" => ["nullable", "string", "max:100", Rule::exists("users", "username")],
            "phone_number" => ["nullable", "phone", Rule::exists("users", "phone_number")],
            "phone_country_code" => [
                Rule::requiredIf(function () {
                    return !empty($this->input('phone_number'));
                }),
                "string",
                "max:2"
            ],
            "password" => ["required", "string", "min:8"],
        ];
    }
}
