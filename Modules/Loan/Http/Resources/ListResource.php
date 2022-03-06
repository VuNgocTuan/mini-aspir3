<?php

namespace LoanModule\Http\Resources;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\JsonResource;
use LoanModule\Http\Traits\LoanTermTraits;
use LoanModule\Models\LoanStatus;

class ListResource extends JsonResource
{
    use LoanTermTraits;

    public function toArray($request)
    {
        $data = [
            'loan_id' => $this->id,
            'amount' => $this->amount . __('attrs.currency'),
            'term_by_month' => $this->term,
        ];

        if ($this->status_id != LoanStatus::APPLICATION) {
            $data['start_date'] = $this->start_date;
            $data['expired_date'] = $this->end_date;
            $data['repays'] = RepayResource::collection($this->repays);
        }

        if ($this->status_id == LoanStatus::OPEN) {
            $data['weekly_loan_amount_repay'] = $this->getWeeklyLoanAmountRepay($this->start_date, $this->end_date, $this->amount) . __('attrs.currency');
            $data['loan_amount_remains'] = $this->getLoanAmountRemains($this->repays, $this->amount) . __('attrs.currency');
        }

        $data['status'] = $this->status?->name;
        $data['created_at'] = $this->created_at;

        return $data;
    }
}
