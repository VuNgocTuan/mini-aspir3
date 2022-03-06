<?php

namespace LoanModule\Http\Requests;

use App\Http\Requests\BaseRequest;

class RepayRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'amount' => "required|numeric|min:1",
        ];
    }

    public function messages(): array
    {
        return [
            'amount.min' => __('messages.amount.min'),
        ];
    }
}
