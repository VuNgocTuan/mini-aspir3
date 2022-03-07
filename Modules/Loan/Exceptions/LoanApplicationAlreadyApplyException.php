<?php

namespace LoanModule\Exceptions;

use App\Exceptions\BaseException;
use Illuminate\Http\Response;

class LoanApplicationAlreadyApplyException extends BaseException
{
    public function __construct()
    {
        parent::__construct(
            __('messages.loan.application_already_apply'),
            Response::HTTP_NOT_ACCEPTABLE
        );
    }
}
