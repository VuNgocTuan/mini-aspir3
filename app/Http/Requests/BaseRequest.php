<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class BaseRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        $validators = $validator->errors()->toArray();

        $errors = [];
        foreach ($validators as $key => $value) {
            $errors[$key] = $value[0];
        }

        throw new HttpResponseException(response()->json([
            "errors" => $errors
        ], Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}
