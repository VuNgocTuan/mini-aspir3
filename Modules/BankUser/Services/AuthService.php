<?php

namespace BankUserModule\Services;

use BankUserModule\Repositories\BankUser\BankUserRepositoryInterface;

class AuthService
{
    public function __construct(protected BankUserRepositoryInterface $bankUserRepository)
    {
    }

    public function authenticate(string $email, string $password)
    {
        $bankUser = $this->bankUserRepository->authenticate($email, $password);

        return $bankUser?->createToken($bankUser?->name)->plainTextToken;
    }
}
