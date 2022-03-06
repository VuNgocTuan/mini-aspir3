<?php

namespace LoanModule\Http\Requests;

use App\Http\Requests\BaseRequest;

class LoanApplyRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'term' => 'required|numeric|max:120',
            'amount' => "required|numeric|min:10",
        ];
    }

    public function messages(): array
    {
        return [
            'amount.min' => __('messages.amount.min'),
        ];
    }
}
