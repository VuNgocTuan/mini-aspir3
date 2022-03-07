<?php

namespace LoanModule\Http\Requests;

use App\Http\Requests\BaseRequest;

class BankerLoanApplyRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'id' => 'required|numeric|exists:loan_applications',
        ];
    }
}
