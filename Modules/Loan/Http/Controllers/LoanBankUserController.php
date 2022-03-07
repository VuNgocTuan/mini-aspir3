<?php

namespace LoanModule\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use LoanModule\Http\Requests\BankerLoanApplyRequest;
use LoanModule\Http\Resources\ListOfBankerResource;
use LoanModule\Services\LoanUserBankService;

class LoanBankUserController extends Controller
{
    public function __construct(protected LoanUserBankService $loanUserBankService)
    {
    }

    public function apply(BankerLoanApplyRequest $request)
    {
        $loanApplicationId = $request->id;
        $bankUser = $this->getCurrentBankUser();

        $this->loanUserBankService->apply($bankUser->id, $loanApplicationId);

        return $this->generateSuccessResponse();
    }

    public function getLoanApplicationList(Request $request)
    {
        $loanApplications = $this->loanUserBankService->getLoanApplicationList(
            $request->input('user_id'),
            $request->input('status')
        );

        return ListOfBankerResource::collection($loanApplications);
    }
}
