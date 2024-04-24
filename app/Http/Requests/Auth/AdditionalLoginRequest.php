<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdditionalLoginRequest extends FormRequest
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
            'phone_number' => [
                'required',
                'phone',
                Rule::exists('users', 'phone_number')->where(function ($query) {
                    $query->whereNotNull('phone_last_verified_at');
                }),
            ],
            'phone_country_code' => ['required', 'string', Rule::exists('users', 'phone_country_code')],
            'additional_password' => ['required', 'string', 'min:8'],
        ];
    }
}
