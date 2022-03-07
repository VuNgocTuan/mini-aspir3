<?php

namespace LoanModule\Services;

class LoanUserBankService extends LoanService
{
    public function apply($loanApplicationId)
    {
        $loanApplication = $this->loanApplicationRepository->find($loanApplicationId)->first();

        dd($loanApplication);
    }
}
