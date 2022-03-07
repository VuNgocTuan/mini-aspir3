<?php

namespace BankUserModule\Providers;

use App\Providers\BaseRepositoryServiceProvider;

class RepositoryServiceProvider extends BaseRepositoryServiceProvider
{
    protected $repositories = [
        'BankUser'
    ];

    protected $repositoryPath = "BankUserModule\Repositories";
}
