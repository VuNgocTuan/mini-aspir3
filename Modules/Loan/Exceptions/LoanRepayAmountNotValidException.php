<?php

namespace LoanModule\Exceptions;

use App\Exceptions\BaseException;
use Illuminate\Http\Response;

class LoanRepayAmountNotValidException extends BaseException
{
    public function __construct(private $weeklyAmount = 0)
    {
        $msg = str_replace(':amount', $weeklyAmount, __('messages.loan.repay_amount_not_valid'));
        parent::__construct(
            $msg,
            Response::HTTP_NOT_ACCEPTABLE
        );
    }
}
