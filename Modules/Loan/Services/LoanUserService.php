<?php

namespace LoanModule\Services;

use UserModule\Models\User;

class LoanUserService extends LoanService
{
    public function isUserCanApply(User $user): bool
    {
        return $this->loanApplicationRepository->isUserCanApply($user->id);
    }

    public function apply(User $user)
    {
    }
}
