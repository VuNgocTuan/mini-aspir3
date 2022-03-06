<?php

namespace LoanModule\Repositories\LoanPay;

use App\Repositories\RepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use LoanModule\Models\LoanPay;

interface LoanPayRepositoryInterface extends RepositoryInterface
{
    public function repay(int $loanApplicationId, $amount): LoanPay;

    public function getList(int $loanApplicationId): Collection;
}
