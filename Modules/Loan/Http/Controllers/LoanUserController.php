<?php

namespace LoanModule\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use LoanModule\Http\Requests\LoanApplyRequest;
use LoanModule\Http\Requests\RepayRequest;
use LoanModule\Http\Resources\ListOfUserResource;
use LoanModule\Http\Resources\LoanApplicationResource;
use LoanModule\Http\Resources\RepayResource;
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
        $termByMonth = $request->input('term_by_month');
        $amount = $request->input('amount');

        //Check current user not have loan status is application or open
        if (!$user || !$this->loanUserService->isUserCanApply($user)) {
            return $this->generateErrorResponse(
                __('messages.loan.not_acceptable'),
                Response::HTTP_NOT_ACCEPTABLE
            );
        }

        //Create Loan Application for user
        $newLoanApplication = $this->loanUserService->apply(
            $user,
            $termByMonth,
            $amount
        );

        return new LoanApplicationResource($newLoanApplication);
    }

    public function getLoanApplicationList(Request $request)
    {
        $user = $this->getCurrentUser();

        $loanApplications = $this->loanUserService->getLoanApplicationList($user->id, $request->input('status'));

        return ListOfUserResource::collection($loanApplications);
    }

    public function repay(RepayRequest $request, $loanApplicationId)
    {
        $user = $this->getCurrentUser();
        $amount = $request->input('amount');

        $repay = $this->loanUserService->repay($user, $loanApplicationId, $amount);

        return new RepayResource($repay);
    }
}
