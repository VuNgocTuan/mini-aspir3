<?php

namespace LoanModule\Repositories\LoanPay;

use App\Repositories\RepositoryAbstract;
use LoanModule\Models\LoanPay;

class LoanPayRepository extends RepositoryAbstract implements LoanPayRepositoryInterface
{
    public function __construct(LoanPay $model)
    {
        $this->model = $model;
    }
}
