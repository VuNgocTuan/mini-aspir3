<?php

namespace LoanModule\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use LoanModule\Http\Resources\ListOfBankerResource;
use LoanModule\Services\LoanUserBankService;

class LoanBankUserController extends Controller
{
    public function __construct(protected LoanUserBankService $loanUserBankService)
    {
    }

    public function apply(Request $request)
    {
        $loanApplicationId = (int) $request->id;

        if (!empty($loanApplicationId) || !is_numeric($loanApplicationId)) {
            abort(404);
        }

        dd($loanApplicationId);

        // $this->loanUserBankService->apply($loanApplicationId);
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
