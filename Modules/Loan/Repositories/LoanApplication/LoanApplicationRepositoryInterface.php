<?php

namespace LoanModule\Repositories\LoanApplication;

use App\Repositories\RepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use LoanModule\Models\LoanApplication;

interface LoanApplicationRepositoryInterface extends RepositoryInterface
{
    public function isUserCanApply(int $userId): bool;

    public function apply(int $userId, int $termByMonth, $amount): LoanApplication;

    public function getListOfUser(int $userId): Collection;

    public function get(int $userId, int $loanApplicationId): LoanApplication;

    public function getLoanApplicationToRepay(int $userId, int $loanApplicationId): LoanApplication;

    public function updateStatus(int $loanApplicationId, int $loanStatus): bool;
}