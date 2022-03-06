<?php

namespace App\Http\Traits;

use BankUserModule\Models\BankUser;
use UserModule\Models\User;

trait CurrentUserTrait
{
    public function getCurrentUser(): ?User
    {
        return auth('users')->user();
    }

    public function getCurrentBankUser(): ?BankUser
    {
        return auth('bankUsers')->user();
    }
}
