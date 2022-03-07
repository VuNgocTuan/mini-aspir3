<?php

namespace BankUserModule\Repositories\BankUser;

use App\Repositories\RepositoryInterface;
use BankUserModule\Models\BankUser;

interface BankUserRepositoryInterface extends RepositoryInterface
{
    public function authenticate(string $email, string $password): ?BankUser;
}
