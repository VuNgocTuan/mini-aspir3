<?php

namespace LoanModule\Repositories\LoanPay;

use App\Repositories\RepositoryAbstract;
use Illuminate\Database\Eloquent\Collection;
use LoanModule\Models\LoanPay;

class LoanPayRepository extends RepositoryAbstract implements LoanPayRepositoryInterface
{
    public function __construct(LoanPay $model)
    {
        $this->model = $model;
    }

    public function repay(int $loanApplicationId, $amount): LoanPay
    {
        $loanPay = $this->store([
            'loan_id' => $loanApplicationId,
            'amount' => $amount,
            'pay_date' => now()
        ]);

        return $loanPay;
    }

    public function getList(int $loanApplicationId): Collection
    {
        return $this->findByField('loan_id', $loanApplicationId)->get();
    }
}
