<?php

namespace UserModule\Providers;

use App\Providers\BaseRepositoryServiceProvider;

class RepositoryServiceProvider extends BaseRepositoryServiceProvider
{
    protected $repositories = ['User'];

	protected $repositoryPath = "UserModule\Repositories";
}
