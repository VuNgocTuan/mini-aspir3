<?php

namespace UserModule\Services;

use UserModule\Repositories\User\UserRepositoryInterface;

class AuthService
{
    public function __construct(protected UserRepositoryInterface $userRepository)
    {
    }

    public function authenticate(string $email, string $password)
    {
        $user = $this->userRepository->authenticate($email, $password);

        return $user?->createToken($user?->name)->plainTextToken;
    }
}
