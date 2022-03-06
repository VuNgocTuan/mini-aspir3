<?php

namespace LoanModule\Repositories\LoanApplication;

use App\Repositories\RepositoryInterface;

interface LoanApplicationRepositoryInterface extends RepositoryInterface
{
    public function isUserCanApply(int $userId): bool;
}
