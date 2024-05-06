<?php

namespace App\Http\Requests\Chat;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ContactRequest extends FormRequest
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
            'name' => ['nullable', 'string', 'max:100'],
            'phone_number' => ['required', 'phone', Rule::exists('users', 'phone_number')],
            'phone_country_code' => ['required', 'string', Rule::exists('users', 'phone_country_code')],
            'private_my_phone' => ["required","boolean"]
        ];
    }
}
