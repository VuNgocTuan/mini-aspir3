<?php

namespace UserModule\Repositories\User;

use App\Repositories\RepositoryInterface;
use UserModule\Models\User;

interface UserRepositoryInterface extends RepositoryInterface
{
    public function authenticate(string $email, string $password): ?User;
}
