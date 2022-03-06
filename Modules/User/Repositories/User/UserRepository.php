<?php

namespace UserModule\Repositories\User;

use App\Repositories\RepositoryAbstract;
use Illuminate\Support\Facades\Hash;
use UserModule\Models\User;

class UserRepository extends RepositoryAbstract implements UserRepositoryInterface
{
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function authenticate(string $email, string $password): ?User
    {
        $user = $this->findByField('email', $email)->first();

        if (!$user || !Hash::check($password, $user->password)) {
            return null;
        }

        return $user;
    }
}
