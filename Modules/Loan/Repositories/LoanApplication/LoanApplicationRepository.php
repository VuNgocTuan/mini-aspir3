<?php

namespace LoanModule\Repositories\LoanApplication;

use App\Repositories\RepositoryAbstract;
use LoanModule\Models\LoanApplication;
use LoanModule\Models\LoanStatus;

class LoanApplicationRepository extends RepositoryAbstract implements LoanApplicationRepositoryInterface
{
    public function __construct(LoanApplication $model)
    {
        $this->model = $model;
    }

    public function isUserCanApply(int $userId): bool
    {
        $loanApplication = $this->findByField('user_id', $userId)
            ->where('status_id', LoanStatus::APPLICATION)
            ->orWhere('status_id', LoanStatus::OPEN)
            ->first();

        return !isset($loanApplication);
    }
}
