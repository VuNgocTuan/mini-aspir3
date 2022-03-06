<?php

namespace LoanModule\Providers;

use App\Providers\BaseRepositoryServiceProvider;

class RepositoryServiceProvider extends BaseRepositoryServiceProvider
{
    protected $repositories = [
        'LoanApplication',
        'LoanPay'
    ];

    protected $repositoryPath = "LoanModule\Repositories";
}
