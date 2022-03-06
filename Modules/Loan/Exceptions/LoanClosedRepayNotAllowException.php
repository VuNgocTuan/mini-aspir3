<?php

namespace LoanModule\Exceptions;

use App\Exceptions\BaseException;
use Illuminate\Http\Response;

class LoanClosedRepayNotAllowException extends BaseException
{
    public function __construct()
    {
        parent::__construct(
            __('messages.loan.closed_not_acceptable'),
            Response::HTTP_NOT_ACCEPTABLE
        );
    }
}
