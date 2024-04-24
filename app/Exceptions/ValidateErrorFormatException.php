<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;

class ValidateErrorFormatException extends ExceptionHandler
{
    protected function invalidJson($request, ValidationException $exception)
    {
        return response()->json([
            'errors' => $this->transformErrors($exception),
        ], $exception->status);
    }

    /**
     * @return array<string>
     */
    protected function transformErrors(ValidationException $exception)
    {
        $errors = [];

        foreach ($exception->errors() as $field => $message) {
            $errors[$field] = $message[0];
        }

        return $errors;
    }
}
