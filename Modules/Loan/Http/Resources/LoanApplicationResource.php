<?php

namespace LoanModule\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LoanApplicationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'loan_id' => $this->id,
            'amount' => $this->amount . __('attrs.currency'),
            'term_by_month' => $this->term,
            'status' => $this->status?->name,
            'created_at' => $this->created_at,
        ];
    }
}
