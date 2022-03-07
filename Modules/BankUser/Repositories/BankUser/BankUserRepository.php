<?php

namespace BankUserModule\Repositories\BankUser;

use App\Repositories\RepositoryAbstract;
use BankUserModule\Models\BankUser;
use Illuminate\Support\Facades\Hash;

class BankUserRepository extends RepositoryAbstract implements BankUserRepositoryInterface
{
    public function __construct(BankUser $model)
    {
        return $this->model = $model;
    }

    public function authenticate(string $email, string $password): ?BankUser
    {
        $bankUser = $this->findByField('email', $email)->first();

        if (!$bankUser || !Hash::check($password, $bankUser->password)) {
            return null;
        }

        return $bankUser;
    }
}
