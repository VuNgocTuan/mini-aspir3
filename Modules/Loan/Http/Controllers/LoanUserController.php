<?php

namespace LoanModule\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use LoanModule\Http\Requests\LoanApplyRequest;
use LoanModule\Services\LoanUserService;

class LoanUserController extends Controller
{
    public function __construct(
        protected LoanUserService $loanUserService
    ) {
    }

    public function apply(LoanApplyRequest $request)
    {
        $user = $this->getCurrentUser();

        //Check current user not have loan status is application or open
        if (!$user || !$this->loanUserService->isUserCanApply($user)) {
            return $this->generateErrorResponse(
                __('messages.loan.not_acceptable'),
                Response::HTTP_NOT_ACCEPTABLE
            );
        }

        //Create Loan Application for user

    }
}
