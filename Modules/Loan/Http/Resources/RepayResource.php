<?php

namespace LoanModule\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RepayResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'loan_id' => $this->loan_id,
            'amount' => $this->amount . __('attrs.currency'),
            'repay_date' => $this->pay_date,
        ];
    }
}
