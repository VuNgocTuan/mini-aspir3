<?php

namespace UserModule\Http\Requests;

use App\Http\Requests\BaseRequest;

class AuthenticateRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|email|max:255',
            'password' => 'required|max:255',
        ];
    }
}
