<?php

namespace LoanModule\Services;

use LoanModule\Repositories\LoanApplication\LoanApplicationRepositoryInterface;
use LoanModule\Repositories\LoanPay\LoanPayRepositoryInterface;

class LoanService
{
    public function __construct(
        protected LoanApplicationRepositoryInterface $loanApplicationRepository,
        protected LoanPayRepositoryInterface $loanPayRepository
    ) {
    }
}
