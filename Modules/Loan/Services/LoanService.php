<?php

namespace LoanModule\Services;

use LoanModule\Repositories\LoanApplication\LoanApplicationRepositoryInterface;
use LoanModule\Repositories\LoanPay\LoanPayRepositoryInterface;
use UserModule\Models\User;

class LoanService
{
    public function __construct(
        protected LoanApplicationRepositoryInterface $loanApplicationRepository,
        protected LoanPayRepositoryInterface $loanPayRepository
    ) {
    }

    public function getLoanApplicationList(?int $userId = null, ?int $status)
    {
        return $this->loanApplicationRepository->getList($userId, $status);
    }
}
