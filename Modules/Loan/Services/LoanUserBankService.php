<?php

namespace LoanModule\Services;

class LoanUserBankService extends LoanService
{
    public function apply($userBankId, $loanApplicationId)
    {
        return $this->loanApplicationRepository->applyByBanker($userBankId, $loanApplicationId);
    }
}
